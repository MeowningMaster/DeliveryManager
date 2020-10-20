let orders = new Map();
let filter_fields = ['status', 'client', 'city', 'date', 'courier_id'];
let orders_filter = {
    status: {
        enabled: false,
        data: ''
    },
    client: {
        enabled: false,
        data: ''
    },
    city: {
        enabled: false,
        data: ''
    },
    date: {
        enabled: false,
        data: ''
    },
    courier_id: {
        enabled: false,
        data: ''
    }
}

function request_orders(on_loaded) {
    let request = {
        success: request_orders_success,
        error: request_orders_error,
        data: filter_to_data(orders_filter),
        success_data: on_loaded
    };
    send_request(php.get_orders, request);
}

function filter_to_data(filter) {
    let data = '';
    Object.keys(filter).forEach(function(key) {
        let value = filter[key];
        if (value.enabled) {
            data += key + '=' + value.data + '&';
        }
    });
    return data;
}

function request_orders_success(response, data) {
    let orders_array = response;
    let on_loaded = data;

    orders_array.forEach(function(order) {
        orders.set(order.id, order);
    });

    console.log('orders loaded');

    if (on_loaded !== undefined) {
        on_loaded();
    }
}

function request_orders_error(response) {
    console.log(response);
    toast_error(error.cannot_load_orders);
}