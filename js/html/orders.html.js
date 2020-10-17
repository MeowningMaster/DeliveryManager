let table;
let bindings = new Map();
let fields = ['id', 'status', 'client', 'contacts', 'city', 'address', 'date', 'time', 'cost', 'details', 'courier_id'];
let modal_add = 'modal-add';
let modal_delete = 'modal-delete';
let modal_delete_all = 'modal-delete-all';
let modal_edit = 'modal-edit';

document.addEventListener("DOMContentLoaded", () => {
    table = document.getElementById('table-body');
    request_couriers(on_couriers_loaded);
    request_orders(on_orders_loaded);
});

let processed_requests = 0;
let total_requests = 2;
function on_couriers_loaded() {
    processed_requests++;
    //update_couriers();
    on_request_process();
}
function on_orders_loaded() {
    processed_requests++;
    on_request_process();
}
function on_request_process() {
    if (processed_requests === total_requests) {
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
    let row = table.insertRow();
    order_bindings.row = row;

    fields.forEach(function (field) {
        let value = order[field];
        let cell = row.insertCell();
        order_bindings[field] = cell;

        if (field == 'courier_id') {
            cell.innerText = couriers.get(value).name;
        } else {
            cell.innerText = value;
        }
    });

    bindings.set(order.id, order_bindings);
    let cell = row.insertCell();
    cell.classList.add('controls-cell');

    let button_group = document.createElement('div');
    button_group.classList.add('btn-group');

    let edit_button = document.createElement('button');
    let edit_icon = document.createElement('i');
    edit_button.name = order.id;
    edit_icon.classList.add('fas');
    edit_icon.classList.add('fa-edit');
    edit_button.appendChild(edit_icon)
    edit_button.classList.add('btn');
    //edit_button.addEventListener('click', edit_order_modal);
    button_group.appendChild(edit_button);

    let delete_button = document.createElement('button');
    let delete_icon = document.createElement('i');
    delete_button.name = order.id;
    delete_icon.classList.add('fas');
    delete_icon.classList.add('fa-eraser');
    delete_button.appendChild(delete_icon);
    delete_button.classList.add('btn');
    //delete_button.addEventListener('click', delete_order);
    button_group.appendChild(delete_button);

    cell.appendChild(button_group);
}

function toggle_modal_add() {
    halfmoon.toggleModal(modal_add);
}
function add_order() {
    let order = parse_modal(modal_add, fields, 'id');

    let request = {
        success: add_order_success,
        error: add_order_error,
        data: extract_data(order),
        success_data: order
    }
    send_request(php.add_order, request);
}
function add_order_success(response, data) {
    let order = data;

    order.id = response;
    display_order(order);
    orders.set(order.id, order);
    toggle_modal_add();
    clear_modal(modal_add, fields, 'id');
}
function add_order_error(response) {
    console.log(response);
    toast_error(error.cannot_add_order);
}

/*function edit_order_modal(event) {
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
            bindings.get(order_id).row.remove();
            orders.delete(order_id);
            bindings.delete(order_id);
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
            bindings.clear();
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
    fields.forEach((field) => {
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
    fields.forEach((field) => {
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
    fields.forEach((field) => {
        let element = document.getElementById(add_modal_prepend + field);
        order[field] = element.value;
    });
    return order;
}*/