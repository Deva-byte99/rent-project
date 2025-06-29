document.addEventListener("DOMContentLoaded", function () {
    let orderList = document.getElementById("orderList");
    let orders = JSON.parse(localStorage.getItem("orders")) || [];

    if (orders.length === 0) {
        orderList.innerHTML = "<tr><td colspan='2'>No orders yet.</td></tr>";
    } else {
        orders.forEach(order => {
            let row = document.createElement("tr");
            row.innerHTML = `<td>${order.name}</td><td>$${order.price}</td>`;
            orderList.appendChild(row);
        });
    }
});
