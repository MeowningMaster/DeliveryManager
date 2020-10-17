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
    update_couriers();
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
    edit_button.addEventListener('click', open_modal_edit);
    button_group.appendChild(edit_button);

    let delete_button = document.createElement('button');
    let delete_icon = document.createElement('i');
    delete_button.name = order.id;
    delete_icon.classList.add('fas');
    delete_icon.classList.add('fa-eraser');
    delete_button.appendChild(delete_icon);
    delete_button.classList.add('btn');
    delete_button.addEventListener('click', open_modal_delete);
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

let delete_id;
function open_modal_delete(event) {
    delete_id = event.target.closest('button').name;
    let order = orders.get(delete_id);
    let output = document.getElementById('modal-delete-order');
    output.innerText = order.id+': '+order.client;
    toggle_modal_delete()
}
function toggle_modal_delete() {
    halfmoon.toggleModal(modal_delete);
}
function delete_order() {
    let request = {
        success: delete_order_success,
        error: delete_order_error,
        data: 'order_id=' + delete_id,
        success_data: delete_id
    }
    send_request(php.delete_order, request);
}
function delete_order_success(response, data) {
    let order_id = data;

    bindings.get(order_id).row.remove();
    orders.delete(order_id);
    bindings.delete(order_id);
    toggle_modal_delete();
}
function delete_order_error(response) {
    console.log(response);
    toast_error(error.cannot_delete_order);
}

function open_modal_edit(event) {
    let edit_id = event.target.closest('button').name;
    let order = orders.get(edit_id);
    fill_modal(modal_edit, fields, order);
    toggle_modal_edit();
}
function toggle_modal_edit() {
    halfmoon.toggleModal(modal_edit);
}
function edit_order() {
    let order = parse_modal(modal_edit, fields);

    let request = {
        success: edit_order_success,
        error: edit_order_error,
        data: extract_data(order),
        success_data: order
    }
    send_request(php.edit_order, request);
}
function edit_order_success(response, data) {
    let order = data;

    orders.set(order.id, order);
    let order_bindings = bindings.get(order.id);
    fields.forEach(function (field) {
        if (field == 'courier_id') {
            order_bindings[field].innerText = couriers.get(order.courier_id).name;
        } else {
            order_bindings[field].innerText = order[field];
        }
    });
    toggle_modal_edit();
}
function edit_order_error(response) {
    console.log(response);
    toast_error(error.cannot_edit_order);
}