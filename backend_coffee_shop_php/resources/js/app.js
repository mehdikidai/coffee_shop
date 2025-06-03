import "./bootstrap";
import Swal from "sweetalert2";
import AirDatepicker from "air-datepicker";
import "air-datepicker/air-datepicker.css";
import localeEn from "air-datepicker/locale/en";

document.querySelectorAll(".form-delete-user").forEach((form) => {
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        Swal.fire({
            title: "Are you sure?",
            text: "This action cannot be undone.",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});

document.querySelectorAll(".btns_remove_alert").forEach((btn) => {
    btn.addEventListener("click", () => {
        btn.parentElement.remove();
    });
});

let today = new Date();
let tomorrow = new Date();
tomorrow.setDate(today.getDate());

new AirDatepicker("#input_filter", {
    locale: localeEn,
    autoClose: true,
    isMobile: false,
    dateFormat: "yyyy-MM-dd",
    //visible: true,
});
