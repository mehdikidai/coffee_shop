import "./bootstrap";
import Swal from "sweetalert2";
import AirDatepicker from "air-datepicker";
import "air-datepicker/air-datepicker.css";
import localeEn from "air-datepicker/locale/en";

const confirmDelete = (els) => {
    document.querySelectorAll(els).forEach((form) => {
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
};

confirmDelete(".form-delete-user");

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

new AirDatepicker("#input_filter_statistics", {
    locale: localeEn,
    autoClose: true,
    isMobile: false,
    dateFormat: "d-MM-yy",
    range: true,
    multipleDatesSeparator: " | ",
    //inline: true
    //visible: true,
});

const btnMenu = document.getElementById("btn_menu");
if (btnMenu) {
    btnMenu.addEventListener("click", function () {
        document.getElementById("sidebar").classList.add("active");
    });
}

const btnClose = document.getElementById("btn_close");
if (btnClose) {
    btnClose.addEventListener("click", function () {
        document.getElementById("sidebar").classList.remove("active");
    });
}

confirmDelete(".form-delete-category");

document.addEventListener("DOMContentLoaded", () => {
    const wrapper = document.getElementById("ingredients-wrapper");
    if (!wrapper) return;

    function checkWrapperEmpty() {
        if (wrapper.children.length === 0) {
            wrapper.style.display = "none";
        } else {
            wrapper.style.display = "block";
        }
    }

    checkWrapperEmpty();

    wrapper.querySelectorAll(".remove-ingredient").forEach((btn) => {
        btn.addEventListener("click", (e) => {
            const group = e.target.closest(".ingredient-group");
            group.remove();
            checkWrapperEmpty();
        });
    });
});

document.querySelectorAll(".btn-receipt").forEach((el) => {
    el.addEventListener("click", (e) => {
        const imgUrl = e.target.dataset.img;
        document.getElementById("receiptImage").src = imgUrl;

        const modal = new bootstrap.Modal(
            document.getElementById("receiptModal")
        );
        modal.show();
    });
});



let index = 1;

document.getElementById("add-ingredient").addEventListener("click", () => {
    const wrapper = document.getElementById("ingredients-wrapper");
    const firstItem = wrapper.querySelector(".ingredient-item");

    const clone = firstItem.cloneNode(true);


    clone.querySelectorAll("select, input").forEach(el => {
        if (el.name.includes("ingredient_id")) {
            el.name = `ingredients[${index}][ingredient_id]`;
        }
        if (el.name.includes("quantity")) {
            el.name = `ingredients[${index}][quantity]`;
        }
        if (el.type !== "hidden") {
            el.value = "";  // تنظيف القيم القديمة
        }
    });

    wrapper.appendChild(clone);
    index++;
});

document.addEventListener("click", e => {
    if (e.target.classList.contains("remove-ingredient")) {
        const item = e.target.closest(".ingredient-item");

        if (!item) return;

        item.remove();

    }
});
