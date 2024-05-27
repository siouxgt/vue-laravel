const laCabms = $('#la_cabms').val();//Tal vez desaparezca
const participacion = $('#participacion').val();

$.each($('a.disabled'), function (index, value) {
    $(this).css('pointer-events', 'none');
    $(this).css('cursor', 'not-allowed');
});


document.addEventListener("DOMContentLoaded", () => {
    $('#myCarousel').carousel({
        interval: 3000
    })

    $('.carousel .carousel-item').each(function() {
        var minPerSlide = 2;
        var next = $(this).next();
        if (!next.length) {
            next = $(this).siblings(':first');
        }
        next.children(':first-child').clone().appendTo($(this));

        for (var i = 0; i < minPerSlide; i++) {
            next = next.next();
            if (!next.length) {
                next = $(this).siblings(':first');
            }
            next.children(':first-child').clone().appendTo($(this));
        }
    });
});