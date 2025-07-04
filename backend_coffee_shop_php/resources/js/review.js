const stars = document.querySelectorAll("#star-rating .star");
const ratingInput = document.getElementById("rating");

stars.forEach((star) => {
    star.addEventListener("click", () => {
        const value = star.dataset.value;
        ratingInput.value = value;

        stars.forEach((s) => s.classList.remove("selected"));


        stars.forEach((s) => {
            if (s.dataset.value <= value) {
                s.classList.add("selected");
            }
        });
    });

    star.addEventListener("mouseover", () => {
        stars.forEach((s) => s.classList.remove("hovered"));
        stars.forEach((s) => {
            if (s.dataset.value <= star.dataset.value) {
                s.classList.add("hovered");
            }
        });
    });

    star.addEventListener("mouseout", () => {
        stars.forEach((s) => s.classList.remove("hovered"));
    });
});




const btns_remove_alert = document.querySelectorAll('.btns_remove_alert');

btns_remove_alert.forEach(btn => {
    btn.addEventListener('click', function () {
        const alertBox = btn.closest('.alert');
        if (alertBox) alertBox.remove();
    });
});
