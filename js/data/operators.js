let operators = new Map();

function request_operators(on_loaded) {
    let request = {
        success: request_operators_success,
        error: request_operators_error,
        data: '',
        success_data: on_loaded
    };
    send_request(php.get_operators, request);
}

function request_operators_success(response, data) {
    let operators_array = response;
    let on_loaded = data;

    operators_array.forEach(function(operator) {
        operators.set(operator.id, operator);
    });

    console.log('operators loaded');

    if (on_loaded !== undefined) {
        on_loaded();
    }
}

function request_operators_error(response) {
    console.log(response);
    toast_error(error.cannot_load_operators);
}