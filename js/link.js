let php = {
    get_orders: 'php/orders/get_orders.php',
    add_order: 'php/orders/add_order.php',
    delete_order: 'php/orders/delete_order.php',
    delete_all_orders: 'php/orders/delete_all_orders.php',
    edit_order: 'php/orders/edit_order.php',

    get_couriers: 'php/couriers/get_couriers.php',
    add_courier: 'php/couriers/add_courier.php',
    delete_courier: 'php/couriers/delete_courier.php',
    edit_courier: 'php/couriers/edit_courier.php',

    get_operators: 'php/operators/get_operators.php',
    add_operator: 'php/operators/add_operator.php',
    delete_operator: 'php/operators/delete_operator.php',
    edit_operator: 'php/operators/edit_operator.php'
}

function send_request(php_file, request) {
    let link = new XMLHttpRequest();
    link.onreadystatechange = function() {
        request_callback(link, request);
    }

    link.open('GET', php_file + '?' + request.data);
    link.send();
}

function request_callback(link, request) {
    if(link.readyState === 4) {
        if(link.status === 200) {
            let response = JSON.parse(link.responseText);
            switch (response.status) {
                case 'OK':
                    request.success(response.data, request.success_data);
                    break;
                case 'ERROR':
                    toast_error(response.data, error_title.server_side_error);
                    break;
                default:
                    toast_error(error.strange_server_response, error_title.server_side_error);
            }

        } else {
            toast_error(error.no_database_connection);
            request.error(link.response);
        }
    }
}

function extract_data(object) {
    let data = '';
    Object.keys(object).forEach(key => {
        data += key+'=\''+object[key]+'\'&';
    });
    return data;
}