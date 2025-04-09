document.addEventListener("DOMContentLoaded", function () {
    var swiper = new Swiper(".mySwiper-desktop", {
        slidesPerView: 3,
        autoplay: {
            delay: 1600, // Auto-swipe every 1 second
            disableOnInteraction: false, // Keeps autoplay running even if user interacts
        },
        loop: true, // Ensures smooth infinite scrolling
    });

    var swiper = new Swiper(".mySwiper-mobile", {
        slidesPerView: 1,
        autoplay: {
            delay: 1600, // Auto-swipe every 1 second
            disableOnInteraction: false, // Keeps autoplay running even if user interacts
        },
        loop: true, // Ensures smooth infinite scrolling
    });
});