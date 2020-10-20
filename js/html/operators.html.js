let table;
let bindings = new Map();
let fields = ['id', 'name', 'status', 'contacts'];
let modal_add = 'modal-add';
let modal_delete = 'modal-delete';
let modal_edit = 'modal-edit';

document.addEventListener("DOMContentLoaded", () => {
    table = document.getElementById('table-body');
    request_operators(display_operators);
});

function display_operators() {
    display_operators_summary();
    operators.forEach(function(operator) {
        display_operator(operator);
    });
}
function display_operator(operator) {
    if (operator.id !== "1") {
        let operator_bindings = {};
        let row = table.insertRow();
        operator_bindings.row = row;

        fields.forEach(function (field) {
            let value = operator[field];
            let cell = row.insertCell();
            operator_bindings[field] = cell;
            cell.innerHTML = value;
        });

        bindings.set(operator.id, operator_bindings);
        let cell = row.insertCell();
        cell.classList.add('controls-cell');
        add_controls(cell, operator, open_modal_edit, open_modal_delete);
    }
}

function toggle_modal_add() {
    halfmoon.toggleModal(modal_add);
}
function add_operator() {
    let operator = parse_modal(modal_add, fields, 'id');

    let request = {
        success: add_operator_success,
        error: add_operator_error,
        data: extract_data(operator),
        success_data: operator
    }
    send_request(php.add_operator, request);
}
function add_operator_success(response, data) {
    let operator = data;

    operator.id = response;
    display_operator(operator);
    operators.set(operator.id, operator);
    display_operators_summary();
    toggle_modal_add();
    clear_modal(modal_add, fields, 'id');
}
function add_operator_error(response) {
    console.log(response);
    toast_error(error.cannot_add_operator);
}

let delete_id;
function open_modal_delete(event) {
    delete_id = event.target.closest('button').name;
    let operator = operators.get(delete_id);
    let output = document.getElementById('modal-delete-operator');
    output.innerText = operator.id+': '+operator.name;
    toggle_modal_delete()
}
function toggle_modal_delete() {
    halfmoon.toggleModal(modal_delete);
}
function delete_operator() {
    let request = {
        success: delete_operator_success,
        error: delete_operator_error,
        data: 'operator_id=' + delete_id,
        success_data: delete_id
    }
    send_request(php.delete_operator, request);
}
function delete_operator_success(response, data) {
    let operator_id = data;

    bindings.get(operator_id).row.remove();
    operators.delete(operator_id);
    bindings.delete(operator_id);
    display_operators_summary();
    toggle_modal_delete();
}
function delete_operator_error(response) {
    console.log(response);
    toast_error(error.cannot_delete_operator);
}

function open_modal_edit(event) {
    let edit_id = event.target.closest('button').name;
    let operator = operators.get(edit_id);
    fill_modal(modal_edit, fields, operator);
    toggle_modal_edit();
}
function toggle_modal_edit() {
    halfmoon.toggleModal(modal_edit);
}
function edit_operator() {
    let operator = parse_modal(modal_edit, fields);

    let request = {
        success: edit_operator_success,
        error: edit_operator_error,
        data: extract_data(operator),
        success_data: operator
    }
    send_request(php.edit_operator, request);
}
function edit_operator_success(response, data) {
    let operator = data;

    operators.set(operator.id, operator);
    let operator_bindings = bindings.get(operator.id);
    fields.forEach(function (field) {
        operator_bindings[field].innerText = operator[field];
    });
    display_operators_summary();
    toggle_modal_edit();
}
function edit_operator_error(response) {
    console.log(response);
    toast_error(error.cannot_edit_operator);
}

function display_operators_summary() {
    let by_status = new Map();

    operators.forEach(function (operator) {
        if (operator.id !== '1') {
            let status = operator.status;
            if (by_status.has(status)) {
                by_status.set(status, by_status.get(status) + 1);
            } else {
                by_status.set(status, 1);
            }
        }
    });

    let summary_table = document.getElementById('operators_summary');
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