let couriers_bindings = new Map();

document.addEventListener("DOMContentLoaded", () => {
    request_couriers(display_couriers);
});

function display_couriers() {
    let table = document.getElementById('table-couriers-body');

    couriers.forEach(function(courier) {
        if (courier.id !== "1") {
            let courier_bindings = {};
            let row = table.insertRow();
            courier_bindings.row = row;

            for (let field_id in courier) {
                let field = courier[field_id];
                let cell = row.insertCell();
                cell.innerText = field;
                courier_bindings[field_id] = cell;
            }

            couriers_bindings.set(courier.id, courier_bindings);
            let cell = row.insertCell();

            let edit_button = document.createElement('button');
            edit_button.name = courier.id;
            let edit_icon = document.createElement('i');
            edit_icon.name = courier.id;
            edit_icon.classList.add('fas');
            edit_icon.classList.add('fa-edit');
            edit_button.appendChild(edit_icon)
            edit_button.classList.add('btn');
            edit_button.addEventListener('click', edit_courier)
            cell.appendChild(edit_button);

            let delete_button = document.createElement('button');
            delete_button.name = courier.id;
            let delete_icon = document.createElement('i');
            delete_icon.name = courier.id;
            delete_icon.classList.add('fas');
            delete_icon.classList.add('fa-trash-alt');
            delete_button.appendChild(delete_icon)
            delete_button.classList.add('btn');
            delete_button.addEventListener('click', delete_courier);
            cell.appendChild(delete_button);
        }
    });
}

function add_courier_modal() {
    $('#add-courier-modal').modal('show');
}

function edit_courier() {

}

function delete_courier() {

}