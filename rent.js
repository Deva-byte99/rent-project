document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".rent-btn").forEach(button => {
        button.addEventListener("click", function(event) {
            event.preventDefault();
            
            if (!localStorage.getItem("isLoggedIn")) {
                alert("You must log in first to rent a vehicle!");
                localStorage.setItem("redirectAfterLogin", window.location.href);
                window.location.href = "login.html";
            } else {
                let vehicleId = this.getAttribute("data-id");
                let vehicleName = this.getAttribute("data-name");
                let vehiclePrice = this.getAttribute("data-price");

                let orders = JSON.parse(localStorage.getItem("orders")) || [];
                orders.push({ id: vehicleId, name: vehicleName, price: vehiclePrice });

                localStorage.setItem("orders", JSON.stringify(orders));

                alert("Vehicle ordered successfully!");
                window.location.href = "order.html"; // Redirect to order page
            }
        });
    });
});
