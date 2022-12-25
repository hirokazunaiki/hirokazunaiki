
/* -------------------------------------------------------------------------- */

/*	Shuffle Text
/* -------------------------------------------------------------------------- */

var arr = []

function TypingInit() {
    $('.js_typing').each(function(i) {
        arr[i] = new ShuffleText(this);
    });
}

function TypingAnime() {
    $(".js_typing").each(function(i) {
        var elemPos = $(this).offset().top;
        var scroll = $(window).scrollTop();
        var windowHeight = $(window).height();
        if (scroll >= elemPos - windowHeight) {
            if (!$(this).hasClass("endAnime")) {
                arr[i].start();
                arr[i].duration = 1000;
                $(this).addClass("endAnime");
            }
        } else {
            $(this).removeClass("endAnime");
        }
    });
}

$(window).scroll(function() {
    TypingInit();
    TypingAnime();
});

$(window).on('load', function() {
    TypingInit();
    setTimeout(function() {
        TypingAnime();
    }, 2000);
});
