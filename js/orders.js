let orders = new Map();

function request_orders(on_ready) {
    let link = new XMLHttpRequest();
    link.onreadystatechange = function() {
        request_orders_callback(link, on_ready);
    }

    link.open('GET', 'php/orders/get_orders.php');
    link.send();
}

function request_orders_callback(link, on_ready) {
    if(link.readyState === 4) {
        if(link.status === 200) {
            let orders_array = JSON.parse(link.responseText);
            orders_array.forEach(function(order) {
                orders.set(order.id, order);
            });
            if (on_ready !== undefined) {
                on_ready();
            }
        } else {
            console.log(link.response);
        }
    }
}