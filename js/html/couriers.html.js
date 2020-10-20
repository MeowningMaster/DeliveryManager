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
    display_couriers_summary();
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
        add_controls(cell, courier, open_modal_edit, open_modal_delete);
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
    display_couriers_summary();
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
    output.innerText = courier.id+': '+courier.name;
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
    display_couriers_summary();
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
    display_couriers_summary();
    toggle_modal_edit();
}
function edit_courier_error(response) {
    console.log(response);
    toast_error(error.cannot_edit_courier);
}

function display_couriers_summary() {
    let by_status = new Map();

    couriers.forEach(function (courier) {
        if (courier.id !== '1') {
            let status = courier.status;
            if (by_status.has(status)) {
                by_status.set(status, by_status.get(status) + 1);
            } else {
                by_status.set(status, 1);
            }
        }
    });

    let summary_table = document.getElementById('couriers_summary');
    summary_table.innerHTML = '';

    for (let [key, value] of by_status.entries()) {
        let row = summary_table.insertRow();
        let cell_key = row.insertCell();
        let cell_value = row.insertCell();

        if (key === '') {
            cell_key.innerText = '*нет статуса*';
        } else {
            cell_key.innerText = key;
        }
        cell_value.innerText = value;
    }
}