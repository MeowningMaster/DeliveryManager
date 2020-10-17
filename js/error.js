let error = {
    no_database_connection: 'Нет подключения к базе данных',
    strange_server_response: 'Странный ответ со стороны сервера, возможно нет подключения',

    cannot_load_orders: 'Не удалось загрузить список заказов',
    cannot_add_order: 'Не удаеться добавить заказ',
    cannot_delete_order: 'Не удаеться удалить заказ',
    cannot_delete_all_orders: 'Не удаеться удалить все заказы',
    cannot_edit_order: 'Не удаеться изменить данные заказа',

    cannot_load_couriers: 'Не удалось загрузить список курьеров',
    cannot_add_courier: 'Не удаеться добавить курьера',
    cannot_delete_courier: 'Не удаеться удалить курьера',
    cannot_edit_courier: 'Не удаеться изменить данные курьера'
}

let error_title = {
    error: 'Ошибка!',
    server_side_error: 'Серверная ошибка!'
}

function toast_error(error, title = error_title.error) {
    halfmoon.initStickyAlert({
        content: error,
        title: title,
        alertType: "alert-danger"
    });
}