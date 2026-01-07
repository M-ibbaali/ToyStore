import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", function () {
    // Auto-dismiss alerts after 5 seconds
    const successAlert = document.getElementById("alert-success");
    const errorAlert = document.getElementById("alert-error");

    if (successAlert) {
        setTimeout(() => {
            successAlert.style.opacity = "0";
            setTimeout(() => successAlert.remove(), 300);
        }, 5000);
    }

    if (errorAlert) {
        setTimeout(() => {
            errorAlert.style.opacity = "0";
            setTimeout(() => errorAlert.remove(), 300);
        }, 5000);
    }
});
