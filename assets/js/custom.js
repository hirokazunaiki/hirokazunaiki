
/* -------------------------------------------------------------------------- */

/*	Load
/* -------------------------------------------------------------------------- */

$(window).on('load', function() {
    $('body').addClass('appear');
});

/* -------------------------------------------------------------------------- */

/*	Global Navigation
/* -------------------------------------------------------------------------- */

function NavAnime() {
    var headerH = $('.site-header').outerHeight(true);
    var elemTop = $('.site-footer').offset().top;
    var scroll = $(window).scrollTop();
    var windowHeight = $(window).height();
    if (scroll >= headerH) {
        $('body').addClass('HeaderHeightMin');
        if (scroll >= elemTop - windowHeight){
            $('body').addClass('HeaderHidden');
        } else {
            $('body').removeClass('HeaderHidden');
        }
    } else {
        $('body').removeClass('HeaderHeightMin');
    }    
}

$(window).scroll(function() {
    NavAnime();
});

/* -------------------------------------------------------------------------- */

/*	Modal Navigation
/* -------------------------------------------------------------------------- */

$('.modal-btn').click(function() {
    $(this).toggleClass('active');
    $('body').toggleClass('panelactive');
});

$('a[href^="#"]').click(function() {
    $('.modal-btn').removeClass('active');
    $('body').removeClass('panelactive');
});

/* -------------------------------------------------------------------------- */

/*	Scroll Animation
/* -------------------------------------------------------------------------- */

function fadeInAnime() {
    $('.fadeInTrigger').each(function() {
        var elemPos = $(this).offset().top - 50;
        var scroll = $(window).scrollTop();
        var windowHeight = $(window).height();
        if (scroll >= elemPos - windowHeight) {
            $(this).addClass('fadeIn');
        } else {
            $(this).removeClass('fadeIn');
        }
    });
}

function fadeUpAnime() {
    $('.fadeUpTrigger').each(function() {
        var elemPos = $(this).offset().top - 50;
        var scroll = $(window).scrollTop();
        var windowHeight = $(window).height();
        if (scroll >= elemPos - windowHeight) {
            $(this).addClass('fadeUp');
        } else {
            $(this).removeClass('fadeUp');
        }
    });
}

function fadeDownAnime() {
    $('.fadeDownTrigger').each(function() {
        var elemPos = $(this).offset().top - 50;
        var scroll = $(window).scrollTop();
        var windowHeight = $(window).height();
        if (scroll >= elemPos - windowHeight) {
            $(this).addClass('fadeDown');
        } else {
            $(this).removeClass('fadeDown');
        }
    });
}

function fadeLeftAnime() {
    $('.fadeLeftTrigger').each(function() {
        var elemPos = $(this).offset().top - 50;
        var scroll = $(window).scrollTop();
        var windowHeight = $(window).height();
        if (scroll >= elemPos - windowHeight) {
            $(this).addClass('fadeLeft');
        } else {
            $(this).removeClass('fadeLeft');
        }
    });
}

function fadeRightAnime() {
    $('.fadeRightTrigger').each(function() {
        var elemPos = $(this).offset().top - 50;
        var scroll = $(window).scrollTop();
        var windowHeight = $(window).height();
        if (scroll >= elemPos - windowHeight) {
            $(this).addClass('fadeRight');
        } else {
            $(this).removeClass('fadeRight');
        }
    });
}

function zoomInAnime() {
    $('.zoomInTrigger').each(function() {
        var elemPos = $(this).offset().top - 50;
        var scroll = $(window).scrollTop();
        var windowHeight = $(window).height();
        if (scroll >= elemPos - windowHeight) {
            $(this).addClass('zoomIn');
        } else {
            $(this).removeClass('zoomIn');
        }
    });
}

function zoomOutAnime() {
    $('.zoomOutTrigger').each(function() {
        var elemPos = $(this).offset().top - 50;
        var scroll = $(window).scrollTop();
        var windowHeight = $(window).height();
        if (scroll >= elemPos - windowHeight) {
            $(this).addClass('zoomOut');
        } else {
            $(this).removeClass('zoomOut');
        }
    });
}

$(window).scroll(function() {
    fadeInAnime();
    fadeUpAnime();
    fadeDownAnime();
    fadeLeftAnime();
    fadeRightAnime();
    zoomInAnime();
    zoomOutAnime();
});

$(window).on('load', function() {
    setTimeout(function(){
        fadeInAnime();
        fadeUpAnime();
        fadeDownAnime();
        fadeLeftAnime();
        fadeRightAnime();
        zoomInAnime();
        zoomOutAnime();
    },2000);
});

/* -------------------------------------------------------------------------- */

/*	Page top
/* -------------------------------------------------------------------------- */

function PageTopAnime() {
    var windowHeight = $(window).height();
    var scroll = $(window).scrollTop();
    var elemTop = $('.site-footer').offset().top;
    if (scroll >= 300) {
        $('.page-top').removeClass('hidden');
        $('.page-top').addClass('visible');
        if (scroll >= elemTop - windowHeight) {
            $('.page-top').addClass('upMove');
        } else {
            $('.page-top').removeClass('upMove');
        }
    } else {
        if ($('.page-top').hasClass('visible')) {
            $('.page-top').removeClass('visible');
            $('.page-top').addClass('hidden');
        }
    }
}

$(window).scroll(function() {
    PageTopAnime();
});


/* -------------------------------------------------------------------------- */

/*	Scroll Timeline 
/* -------------------------------------------------------------------------- */

function ScrollTimeLineAnime() {
    $('.flow-timeline__item').each(function(){
        var elemPos = $(this).offset().top;
        var scroll = $(window).scrollTop();
        var windowHeight = $(window).height();
        var startPoint = windowHeight / 2;

        if ( scroll >= elemPos - windowHeight - startPoint ) {
            var H = $(this).outerHeight(true);
            var percent = ( scroll + startPoint - elemPos ) / ( H / 2 ) * 100;
            if ( percent > 100 ) {
                percent = 100;
            }
            $(this).children('.flow-timeline__border-line').css({
                height: percent + "%",
            });
        }
    });
}

$(window).on('scroll', function(){
    ScrollTimeLineAnime();
});

/* -------------------------------------------------------------------------- */

/*	Accodion Panel
/* -------------------------------------------------------------------------- */

$('.accordion__question').on('click', function(){
    $('.accordion__answer-wrapper').slideUp(500);
    var findElm = $(this).next('.accordion__answer-wrapper');
    if ( $(this).hasClass('close') ) {
        $(this).removeClass('close');
    } else {
        $('.close').removeClass('close');
        $(this).addClass('close');
        $(findElm).slideDown(500);
    }
});
