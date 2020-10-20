let couriers = new Map();

function request_couriers(on_loaded) {
    let request = {
        success: request_couriers_success,
        error: request_couriers_error,
        data: '',
        success_data: on_loaded
    };
    send_request(php.get_couriers, request);
}

function request_couriers_success(response, data) {
    let couriers_array = response;
    let on_loaded = data;

    couriers_array.forEach(function(courier) {
        couriers.set(courier.id, courier);
    });

    console.log('couriers loaded');

    if (on_loaded !== undefined) {
        on_loaded();
    }
}

function request_couriers_error(response) {
    console.log(response);
    toast_error(error.cannot_load_couriers);
}