let table;
let bindings = new Map();
let fields = ['id', 'name', 'status', 'contacts'];
let modal_add = 'modal-add';
let modal_delete = 'modal-delete';
let modal_edit = 'modal-edit';

document.addEventListener("DOMContentLoaded", () => {
    table = document.getElementById('table-body');
    request_couriers(display_couriers);
});

function display_couriers() {
    couriers.forEach(function(courier) {
        display_courier(courier);
    });
}
function display_courier(courier) {
    if (courier.id !== "1") {
        let courier_bindings = {};
        let row = table.insertRow();
        courier_bindings.row = row;

        fields.forEach(function (field) {
            let value = courier[field];
            let cell = row.insertCell();
            courier_bindings[field] = cell;
            cell.innerHTML = value;
        });

        bindings.set(courier.id, courier_bindings);
        let cell = row.insertCell();
        cell.classList.add('controls-cell');

        let button_group = document.createElement('div');
        button_group.classList.add('btn-group');

        let edit_button = document.createElement('button');
        let edit_icon = document.createElement('i');
        edit_button.name = courier.id;
        edit_icon.classList.add('fas');
        edit_icon.classList.add('fa-edit');
        edit_button.appendChild(edit_icon);
        edit_button.classList.add('btn');
        edit_button.addEventListener('click', open_modal_edit);
        button_group.appendChild(edit_button);

        let delete_button = document.createElement('button');
        let delete_icon = document.createElement('i');
        delete_button.name = courier.id;
        delete_icon.classList.add('fas');
        delete_icon.classList.add('fa-eraser');
        delete_button.appendChild(delete_icon);
        delete_button.classList.add('btn');
        delete_button.addEventListener('click', open_modal_delete);
        button_group.appendChild(delete_button);

        cell.appendChild(button_group);
    }
}

function toggle_modal_add() {
    halfmoon.toggleModal(modal_add);
}
function add_courier() {
    let courier = parse_modal(modal_add, fields, 'id');

    let request = {
        success: add_courier_success,
        error: add_courier_error,
        data: extract_data(courier),
        success_data: courier
    }
    send_request(php.add_courier, request);
}
function add_courier_success(response, data) {
    let courier = data;

    courier.id = response;
    display_courier(courier);
    couriers.set(courier.id, courier);
    toggle_modal_add();
    clear_modal(modal_add, fields, 'id');
}
function add_courier_error(response) {
    console.log(response);
    toast_error(error.cannot_add_courier);
}

let delete_id;
function open_modal_delete(event) {
    delete_id = event.target.closest('button').name;
    let courier = couriers.get(delete_id);
    let output = document.getElementById('modal-delete-courier');
    output.innerText = '№'+courier.id+': '+courier.name;
    toggle_modal_delete()
}
function toggle_modal_delete() {
    halfmoon.toggleModal(modal_delete);
}
function delete_courier() {
    let request = {
        success: delete_courier_success,
        error: delete_courier_error,
        data: 'courier_id=' + delete_id,
        success_data: delete_id
    }
    send_request(php.delete_courier, request);
}
function delete_courier_success(response, data) {
    let courier_id = data;

    bindings.get(courier_id).row.remove();
    couriers.delete(courier_id);
    bindings.delete(courier_id);
    toggle_modal_delete();
}
function delete_courier_error(response) {
    console.log(response);
    toast_error(error.cannot_delete_courier);
}

function open_modal_edit(event) {
    let edit_id = event.target.closest('button').name;
    let courier = couriers.get(edit_id);
    fill_modal(modal_edit, fields, courier);
    toggle_modal_edit();
}
function toggle_modal_edit() {
    halfmoon.toggleModal(modal_edit);
}
function edit_courier() {
    let courier = parse_modal(modal_edit, fields);

    let request = {
        success: edit_courier_success,
        error: edit_courier_error,
        data: extract_data(courier),
        success_data: courier
    }
    send_request(php.edit_courier, request);
}
function edit_courier_success(response, data) {
    let courier = data;

    couriers.set(courier.id, courier);
    let courier_bindings = bindings.get(courier.id);
    fields.forEach(function (field) {
        courier_bindings[field].innerText = courier[field];
    });
    toggle_modal_edit();
}
function edit_courier_error(response) {
    console.log(response);
    toast_error(error.cannot_edit_courier);
}