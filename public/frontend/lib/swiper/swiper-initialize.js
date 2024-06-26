const restSwiper = new Swiper(".rest-swiper", {
    slidesPerView: "auto",
    spaceBetween: 30,
    freeMode: true,
    navigation: {
        nextEl: ".rest-swiper-next",
        prevEl: ".rest-swiper-prev",
    }
});

const filterSwiper = new Swiper(".filter-swiper", {
    slidesPerView: "auto",
    spaceBetween: 16,
    freeMode: true,
});

const featureSwiper = new Swiper(".feature-swiper", {
    slidesPerView: "auto",
    slidesPerView: 1,
    freeMode: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        768: {
            slidesPerView: 2,
        },
        1200: {
            slidesPerView: 3,
        },
    },
});