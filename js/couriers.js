let couriers = new Map();

function request_couriers(on_ready) {
    let link = new XMLHttpRequest();
    link.onreadystatechange = function() {
        request_couriers_callback(link, on_ready);
    }

    link.open('GET', 'php/couriers/get_couriers.php');
    link.send();
}

function request_couriers_callback(link, on_ready) {
    if(link.readyState === 4) {
        if(link.status === 200) {
            let couriers_array = JSON.parse(link.responseText);
            couriers_array.forEach(function(courier) {
                couriers.set(courier.id, courier);
            });
            if (on_ready !== undefined) {
                on_ready();
            }
        } else {
            console.log(link.response);
            console.log(link.responseText);
            alert('Нет соединения с базой данных');
        }
    }
}