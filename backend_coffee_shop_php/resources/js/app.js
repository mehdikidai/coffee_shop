import "./bootstrap";
import Swal from "sweetalert2";
import AirDatepicker from "air-datepicker";
import "air-datepicker/air-datepicker.css";
import localeEn from "air-datepicker/locale/en";
import localeAr from "air-datepicker/locale/AR";
import localeFr from "air-datepicker/locale/fr";

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

const getLocale = () => {
    const html = document.documentElement;
    switch (html.attributes.lang.value) {
        case "ar":
            return localeAr;
        case "fr":
            return localeFr;
        default:
            return localeEn;
    }
};

new AirDatepicker("#input_filter", {
    locale: getLocale(),
    autoClose: true,
    isMobile: false,
    dateFormat: "yyyy-MM-dd",
    isMobile: true,

    //visible: true,
});


/*

const dateFromPicker = new AirDatepicker("#date_from", {
    locale: getLocale(),
    dateFormat: "dd-MM-yyyy",
    buttons: ["clear"],
    autoClose: true,
    isMobile: true,
    onSelect({ date }) {
        if (!date) {
            dateFromPicker.hide();
            document.querySelector("#date_to").value = "";
            dateToPicker.selectDate(null);
        }
    },
});

const dateToPicker = new AirDatepicker("#date_to", {
    locale: getLocale(),
    dateFormat: "dd-MM-yyyy",
    buttons: ["clear"],
    autoClose: true,
    isMobile: true,
    onSelect({ date }) {
        if (!date) {
            dateToPicker.hide();
        }
    },
});

*/



let dateToPicker;

const dateFromPicker = new AirDatepicker("#date_from", {
    locale: getLocale(),
    dateFormat: "dd-MM-yyyy",
    buttons: ["clear"],
    autoClose: true,
    isMobile: true,
    onSelect({ date }) {
        if (!date) {
            dateFromPicker.hide();
            const dateToInput = document.querySelector("#date_to");
            if (dateToInput) {
                dateToInput.value = "";
            }

            if (dateToPicker) {
                dateToPicker.destroy();
                dateToPicker = new AirDatepicker("#date_to", {
                    locale: getLocale(),
                    dateFormat: "dd-MM-yyyy",
                    buttons: ["clear"],
                    autoClose: true,
                    isMobile: true,
                    onSelect({ date }) {
                        if (!date) {
                            dateToPicker.hide();
                        }
                    },
                });
            }
        }
    },
});

dateToPicker = new AirDatepicker("#date_to", {
    locale: getLocale(),
    dateFormat: "dd-MM-yyyy",
    buttons: ["clear"],
    autoClose: true,
    isMobile: true,
    onSelect({ date }) {
        if (!date) {
            dateToPicker.hide();
        }
    },
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

document.addEventListener("DOMContentLoaded", () => {
    const btnAddIngredient = document.getElementById("add-ingredient");

    if (btnAddIngredient) {
        let index = 1;

        btnAddIngredient.addEventListener("click", () => {
            const wrapper = document.getElementById("ingredients-wrapper");
            const firstItem = wrapper.querySelector(".ingredient-item");

            const clone = firstItem.cloneNode(true);

            clone.querySelectorAll("select, input").forEach((el) => {
                if (el.name.includes("ingredient_id")) {
                    el.name = `ingredients[${index}][ingredient_id]`;
                }
                if (el.name.includes("quantity")) {
                    el.name = `ingredients[${index}][quantity]`;
                }
                if (el.type !== "hidden") {
                    el.value = "";
                }
            });

            wrapper.appendChild(clone);
            index++;
        });
    }

    document.addEventListener("click", (e) => {
        if (e.target.classList.contains("remove-ingredient")) {
            const item = e.target.closest(".ingredient-item");

            if (!item) return;

            item.remove();
        }
    });
});


const btnQrCode = document.querySelectorAll('.btn_qr_code')

btnQrCode.forEach(btn => {
    btn.addEventListener('click', () => {
        const key = btn.dataset.key;
        const imgUrl = `https://api.qrserver.com/v1/create-qr-code/?data=${encodeURIComponent(key)}`;
        window.open(imgUrl, '_blank');
    });
});
