
$('.single-banner').slick({
  dots: true,
  autoplay:true,
  dots: false,
  autoplaySpeed: 2000,
  fade: true
});

// Menú responsive
$(function () {
  $('[data-toggle="offcanvas"]').on('click', function () {
    $('.offcanvas-collapse').toggleClass('open');
    $('body').toggleClasss('offcanvas-expanded');
  })
})


