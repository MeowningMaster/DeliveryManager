let orders_table;
let orders_bindings = new Map();
let order_fields = ['status', 'client', 'contacts', 'city', 'address', 'date', 'time', 'cost', 'details', 'courier_id'];
let add_modal_prepend = 'add-order-modal-';
let edit_modal_prepend = 'edit-order-modal-';

document.addEventListener("DOMContentLoaded", () => {
    orders_table = document.getElementById('table-orders-body');
    request_couriers(on_couriers_loaded);
    request_orders(on_orders_loaded);
});

let processed_requests = 0;
let pending_requests = 2;
function on_couriers_loaded() {
    processed_requests++;
    update_couriers();
    on_request_process();
}
function on_orders_loaded() {
    processed_requests++;
    on_request_process();
}
function on_request_process() {
    if (processed_requests === pending_requests) {
        display_orders();
    }
}

function display_orders() {
    orders.forEach(function(order) {
        display_order(order);
    });
}
function display_order(order) {
    let order_bindings = {};
    let row = orders_table.insertRow();
    order_bindings.row = row;

    for (let field_id in order) {
        let field = order[field_id];
        let cell = row.insertCell();
        if (field_id === 'courier_id') {
            cell.innerText = couriers.get(field).name;
        } else {
            cell.innerText = field;
        }
        order_bindings[field_id] = cell;
    }

    orders_bindings.set(order.id, order_bindings);
    let cell = row.insertCell();

    let edit_button = document.createElement('button');
    edit_button.name = order.id;
    let edit_icon = document.createElement('i');
    edit_icon.name = order.id;
    edit_icon.classList.add('fas');
    edit_icon.classList.add('fa-edit');
    edit_button.appendChild(edit_icon)
    edit_button.classList.add('btn');
    edit_button.addEventListener('click', edit_order_modal)
    cell.appendChild(edit_button);

    let delete_button = document.createElement('button');
    delete_button.name = order.id;
    let delete_icon = document.createElement('i');
    delete_icon.name = order.id;
    delete_icon.classList.add('fas');
    delete_icon.classList.add('fa-trash-alt');
    delete_button.appendChild(delete_icon);
    delete_button.classList.add('btn');
    delete_button.addEventListener('click', delete_order);
    cell.appendChild(delete_button);
}

function edit_order_modal(event) {
    let order_id = event.target.name;
    let order = orders.get(order_id);
    fill_edit_modal(order);
    $('#edit-order-modal').modal('show');
}
function fill_edit_modal(order) {
    for (const [key, value] of Object.entries(order)) {
        let element = document.getElementById(edit_modal_prepend + key);
        if (key === 'courier_id') {
            element.value = order.courier_id;
        } else {
            element.value = value;
        }
    }
}

function delete_order(event) {
    let order_id = event.target.name;
    let order = orders.get(order_id);
    let result = confirm('Удалить заказ №'+order.id+': '+order.client+' ['+order.date+']'+'?');

    if (result) {
        let link = new XMLHttpRequest();
        link.onreadystatechange = function() {
            delete_callback(link, order_id);
        }

        link.open('GET', 'php/orders/delete_order.php?order_id=' + order_id);
        link.send();
    }
}
function delete_callback(link, order_id) {
    if(link.readyState === 4) {
        if(link.status === 200) {
            orders_bindings.get(order_id).row.remove();
            orders.delete(order_id);
            orders_bindings.delete(order_id);
        } else {
            console.log(link.response);
            alert('Не удалось удалить заказ. Проверьте подключение к интернету');
        }
    }
}

function delete_all_orders() {
    let result = confirm('Удалить ВСЕ заказы?');

    if (result) {
        let link = new XMLHttpRequest();
        link.onreadystatechange = function() {
            delete_all_callback(link);
        }

        link.open('GET', 'php/orders/delete_all_orders.php');
        link.send();
    }
}
function delete_all_callback(link) {
    if(link.readyState === 4) {
        if(link.status === 200) {
            document.getElementById('table-orders-body').innerHTML = '';
            orders.clear();
            orders_bindings.clear();
        } else {
            console.log(link.response);
            console.log(link.responseText);
            alert('Не удалось очистить список заказов. Проверьте подключение к интернету');
        }
    }
}

function update_couriers() {
    let selects = document.getElementsByClassName('courier-select');
    Array.from(selects).forEach((select) => {
        couriers.forEach((courier) => {
            let option = document.createElement('option');
            option.value = courier.id;
            option.innerText = courier.name;
            select.appendChild(option);
        });
    });
}

function add_order_modal() {
    $('#add-order-modal').modal('show');
}
function clear_add_modal() {
    order_fields.forEach((field) => {
        let element = document.getElementById(add_modal_prepend + field);
        if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
            element.value = '';
        } else if (element.tagName === 'SELECT') {
            element.selectedIndex = 0;
        }
    });
}
function add_order() {
    $('#add-order-modal').modal('hide');

    let query = get_add_modal_query();

    let link = new XMLHttpRequest();
    link.onreadystatechange = function() {
        add_order_callback(link);
    }

    link.open('GET', 'php/orders/add_order.php'+query);
    link.send();
}
function get_add_modal_query() {
    let query = '?';
    order_fields.forEach((field) => {
        let element = document.getElementById(add_modal_prepend + field);
        query += field+'=\''+element.value+'\'&';
    });
    return query;
}
function add_order_callback(link) {
    if(link.readyState === 4) {
        if(link.status === 200) {
            let new_order_id = link.responseText;
            let order = get_add_modal_order(new_order_id);
            display_order(order);
            orders.set(new_order_id, order);
            clear_add_modal();
        } else {
            alert('Не удалось добавить заказ. Проверьте подключение к интернету');
            console.log(link.response);
        }
    }
}
function get_add_modal_order(new_order_id) {
    let order = {};
    order['id'] = new_order_id;
    order_fields.forEach((field) => {
        let element = document.getElementById(add_modal_prepend + field);
        order[field] = element.value;
    });
    return order;
}