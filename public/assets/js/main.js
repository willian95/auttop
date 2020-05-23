
$(document).ready(function () {


$('.single-banner').slick({
  dots: true,
  autoplay:true,
  dots: false,
  autoplaySpeed: 2000,
  fade: true
});
});

	const responsiveBtnIcon = document.querySelector(".responsive-menu-btn");
const navMenu = document.querySelector(".nav__menu");

responsiveBtnIcon.addEventListener("click", () => {
  responsiveBtnIcon.classList.toggle("--is-open");
  navMenu.classList.toggle("--is-open");
});





