/* Swiper Start */

function swiperStart() {
    const swiper1 = new Swiper('.hero__swiper', {
        loop: true,
        speed: 1500,
        effect: 'fade',
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        }
    });

    const swiper2 = new Swiper('.fp-service__swiper', {
        loop: false,
        speed: 800,
        slidesPerView: 1.3,
        spaceBetween: 20,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        },
        breakpoints: {
            500: {
                slidesPerView: 2.5,
                spaceBetween: 30,
            }
        }
    });

    const swiper3 = new Swiper('.fp-blog__swiper', {
        loop: true,
        slidesPerView: 1.3,
        spaceBetween: 20,
        speed: 5000,
        allowTouchMove: false,
        autoplay: {
        delay: 0,
        },
        centeredSlides: true,
        breakpoints: {
            500: {
                slidesPerView: 3,
                spaceBetween: 30,
            }
        }
    });

    const swiper4 = new Swiper('.hero-news__swiper', {
        loop: true,
        direction: 'vertical',
        speed: 1000,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        }
    });

    const swiper5 = new Swiper('.fp-mission__swiper', {
        loop: true,
        loopAdditionalSlides: 1,
        slidesPerView: 1.6,
        spaceBetween: 20,
        speed: 5000,
        allowTouchMove: false,
        updateOnWindowResize: false,
        autoplay: {
            delay: 0,
        },
        centeredSlides: true,
        breakpoints: {
            500: {
                slidesPerView: 2,
            }
        },
        on: {
            resize: function() {
              swiper5.autoplay.start();
            }
        }
    });

    const swiper6 = new Swiper('.single-service-target__swiper', {
        loop: true,
        slidesPerView: 1.5,
        spaceBetween: 20,
        speed: 5000,
        allowTouchMove: false,
        autoplay: {
            delay: 0,
        },
        centeredSlides: true,
        breakpoints: {
            500: {
                slidesPerView: 2,
                spaceBetween: 25,
            },
            1024: {
                slidesPerView: 3.5,
                spaceBetween: 30,
            }
        },
        on: {
            resize: function() {
              swiper6.autoplay.start();
            }
        }
    });

    const swiper8 = new Swiper('.flow-timeline-media-swiper', {
        loop: true,
        loopAdditionalSlides: 1,
        slidesPerView: 1.5,
        spaceBetween: 20,
        speed: 5000,
        allowTouchMove: false,
        updateOnWindowResize: false,
        autoplay: {
            delay: 0,
        },
        centeredSlides: true,
        breakpoints: {
            500: {
                slidesPerView: 2,
                spaceBetween: 25,
            },
            1024: {
                slidesPerView: 3.5,
                spaceBetween: 30,
            }
        },
        on: {
            resize: function() {
              swiper8.autoplay.start();
            }
        }
    });

    const swiper9 = new Swiper('.single-service-case-swiper', {
        loop: false,
        speed: 800,
        slidesPerView: 1.2,
        spaceBetween: 30,
        centeredSlides: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        },
        breakpoints: {
            500: {
                slidesPerView: 1,
                spaceBetween: 30,
            }
        }
    });

    const swiper10 = new Swiper('.single-service-header__swiper', {
        loop: true,
        speed: 1500,
        effect: 'fade',
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        }
    });

    const swiper11 = new Swiper('.hero-service__swiper', {
        loop: true,
        speed: 1500,
        effect: 'fade',
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        }
    });

}

window.onload = function() {
    swiperStart();
}

