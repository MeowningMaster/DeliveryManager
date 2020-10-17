let orders = new Map();

function request_orders(on_loaded) {
    let request = {
        success: request_orders_success,
        error: request_orders_error,
        data: '',
        success_data: on_loaded
    };
    send_request(php.get_orders, request);
}

function request_orders_success(response, data) {
    let orders_array = response;
    let on_loaded = data;

    orders_array.forEach(function(order) {
        orders.set(order.id, order);
    });

    if (on_loaded !== undefined) {
        on_loaded();
    }
}

function request_orders_error(response) {
    console.log(response);
    toast_error(error.cannot_load_orders);
}