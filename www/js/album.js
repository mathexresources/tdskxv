document.addEventListener("DOMContentLoaded", function () {
    var swiper = new Swiper(".mySwiper", {
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },

        grabCursor: true
    });
});

// Modal photo viewer
const modal = document.getElementById('photoModal');
modal.addEventListener('show.bs.modal', function (event) {
    const img = event.relatedTarget;
    const path = img.getAttribute('data-bs-path');
    document.getElementById('photoModalImage').src = path;
});

