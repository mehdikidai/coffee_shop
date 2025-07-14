import "./bootstrap";
import AirDatepicker from "air-datepicker";
import "air-datepicker/air-datepicker.css";
import localeEn from "air-datepicker/locale/en";
import localeAr from "air-datepicker/locale/AR";
import localeFr from "air-datepicker/locale/fr";

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
    isMobile: true,
    dateFormat: "yyyy-MM-dd",
    buttons: ["clear"],
    onSelect({date, formattedDate, datepicker}) {
        if (!date) {
            datepicker.hide();
        } 
    }
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

// confirmDelete(".form-delete-category");

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

// const btnQrCode = document.querySelectorAll('.btn_qr_code')

// btnQrCode.forEach(btn => {
//     btn.addEventListener('click', () => {
//         const key = btn.dataset.key;
//         const imgUrl = `https://api.qrserver.com/v1/create-qr-code/?data=${encodeURIComponent(key)}`;
//         window.open(imgUrl, '_blank');
//     });
// });

const downloadQrCode = async (imageSrc, fileName) => {
    const fullName = `qrcode_${fileName}.png`;
    const image = await fetch(imageSrc);
    const imageBlob = await image.blob();
    const imageURL = URL.createObjectURL(imageBlob);
    const link = document.createElement("a");
    link.href = imageURL;
    link.download = fullName;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
};

const qrCodeModal = document.getElementById("qrCodeModal");

if (qrCodeModal !== null) {
    const btnQrCode = document.querySelectorAll(".btn_qr_code");
    const qrImage = document.getElementById("qrCodeImage");
    const qrModal = new bootstrap.Modal(qrCodeModal);
    const downloadBtn = document.getElementById("downloadQrCodeBtn");

    btnQrCode.forEach((btn) => {
        btn.addEventListener("click", () => {
            const key = btn.dataset.key;
            const loginkey = btn.dataset.loginkey;

            const fullKay = `${key}.${loginkey}`;

            const name = String(btn.dataset.name).replace(" ", "_");
            const imgUrl = `https://api.qrserver.com/v1/create-qr-code/?data=${encodeURIComponent(
                fullKay
            )}&margin=15&size=300x300`;
            qrImage.src = imgUrl;

            downloadBtn.addEventListener("click", () => {
                downloadQrCode(imgUrl, name);
            });
            qrModal.show();
        });
    });
}

// setting copy

const btnCopyKey = document.getElementById("btn_copy");

if (btnCopyKey) {
    btnCopyKey.addEventListener("click", (e) => {
        const key = e.target.dataset.key;

        const child = e.target.firstElementChild;

        console.log(child);

        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard
                .writeText(key)
                .then(() => {
                    console.log("Copied ✔️");
                    child.innerHTML = "check";
                })
                .catch((err) => {
                    console.error("Clipboard error:", err);
                })
                .finally(() => {
                    setTimeout(() => {
                        child.innerHTML = "content_copy";
                    }, 500);
                });
        }
    });
}

document.addEventListener("DOMContentLoaded", () => {
    const rows = document.querySelectorAll(".list_sheet");

    rows.forEach((row) => {
        row.addEventListener("mouseover", () => {
            const orderId = row.dataset.orderid;

            document
                .querySelectorAll(`.list_sheet[data-orderid="${orderId}"]`)
                .forEach((match) => {
                    match.classList.add("highlight-order");
                });
        });

        row.addEventListener("mouseout", () => {
            const orderId = row.dataset.orderid;

            document
                .querySelectorAll(`.list_sheet[data-orderid="${orderId}"]`)
                .forEach((match) => {
                    match.classList.remove("highlight-order");
                });
        });
    });
});
