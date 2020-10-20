function add_controls(cell, object, edit_event, delete_event) {
    cell.classList.add('controls-cell');

    let button_group = document.createElement('div');
    button_group.classList.add('btn-group');

    let edit_button = document.createElement('button');
    let edit_icon = document.createElement('i');
    edit_button.name = object.id;
    edit_icon.classList.add('fas');
    edit_icon.classList.add('fa-edit');
    edit_button.appendChild(edit_icon);
    edit_button.classList.add('btn');
    edit_button.addEventListener('click', edit_event);
    button_group.appendChild(edit_button);

    let delete_button = document.createElement('button');
    let delete_icon = document.createElement('i');
    delete_button.name = object.id;
    delete_icon.classList.add('fas');
    delete_icon.classList.add('fa-eraser');
    delete_button.appendChild(delete_icon);
    delete_button.classList.add('btn');
    delete_button.addEventListener('click', delete_event);
    button_group.appendChild(delete_button);

    cell.appendChild(button_group);
}