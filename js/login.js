

function login_form__onsubmit() {
    let form_id = 'login-form';
    let login_form = document.getElementById(form_id);
    let username_input = login_form.getElementById(form_id + 'username');
    let password_input = login_form.getElementById(form_id + 'password');

    let login_data = {
        username: username_input.value,
        password: password_input.value
    }

    login(login_data);
}

function login(login_data) {
    let request = {
        success: login_success,
        error: login_error,
        type: 'login',
        data: extract_data(login_data)
    }
    send_request(php.accounts, request);
}

function login_success() {

}

function login_error() {

}