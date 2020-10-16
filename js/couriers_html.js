let couriers_table;
let couriers_bindings = new Map();

document.addEventListener("DOMContentLoaded", () => {
    couriers_table = document.getElementById('table-couriers-body');
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
        let row = couriers_table.insertRow();
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
        edit_button.addEventListener('click', edit_courier_modal)
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
}

function add_courier_modal() {
    $('#add-courier-modal').modal('show');
}

function edit_courier_modal() {

}

function delete_courier(event) {
    let courier_id = event.target.name;
    let courier = couriers.get(courier_id);
    let result = confirm('Удалить курьера №'+courier.id+': '+courier.name+'?');

    if (result) {
        let link = new XMLHttpRequest();
        link.onreadystatechange = function() {
            delete_callback(link, courier_id);
        }

        link.open('GET', 'php/couriers/delete_courier.php?courier_id=' + courier_id);
        link.send();
    }
}
function delete_callback(link, courier_id) {
    if(link.readyState === 4) {
        if(link.status === 200) {
            couriers_bindings.get(courier_id).row.remove();
            couriers.delete(courier_id);
            couriers_bindings.delete(courier_id);
        } else {
            console.log(link.response);
            alert('Не удалось удалить курьера. Проверьте подключение к интернету');
        }
    }
}