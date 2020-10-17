function parse_modal(modal, fields, ignore = '') {
    let object = {};
    fields.forEach((field) => {
        if (field !== ignore) {
            let element = document.getElementById(modal + '-' + field);
            object[field] = element.value;
        }
    });
    return object;
}

function clear_modal(modal, fields, ignore = '') {
    fields.forEach((field) => {
        if (field !== ignore) {
            let element = document.getElementById(modal + '-' + field);
            if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                element.value = '';
            } else if (element.tagName === 'SELECT') {
                element.selectedIndex = 0;
            }
        }
    });
}

function fill_modal(modal, fields, data) {
    fields.forEach((field) => {
        let element = document.getElementById(modal + '-' + field);
        element.value = data[field];
    });
}