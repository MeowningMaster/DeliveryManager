function save_changes() {
    const couriers = document.getElementsByClassName("courier");
    if (couriers.length === 0) {
        return;
    }

    let s = "";
    let table = "id15115508_courierhelper_test";

    for (let i = 0; i < couriers.length; i++) {
        s += "UPDATE " + table + " SET deliveryCourier = " + couriers.item(i).value + " WHERE orderNumber = " + couriers.item(i).name + "\n";
    }

    let xhttp = new XMLHttpRequest();
    xhttp.open("POST", "change_couriers.php", false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("request=" + s);
    console.log(xhttp.responseText);
}