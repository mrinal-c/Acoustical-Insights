$(document).ready(function() {
	$('a.shownav').on('click', function(){
		$('nav.headernav').slideDown();
		$(this).next('a.hidenav').fadeIn();
		$(this).hide();
		$('header').css('z-index', '10');
		$('body').addClass('scrolloff');
	});
	$('a.hidenav').on('click', function(){
		$('nav.headernav').fadeOut();
		$(this).prev('a.shownav').fadeIn();
		$(this).hide();
		$('header').css('z-index', '2');
		$('body').removeClass('scrolloff');
	});

	var setscreen_width = $(window).width();
	if(setscreen_width < 1100){
		$('nav ul li').on('click', function(){
			$('nav.headernav').fadeOut('slow');
			$('a.hidenav').hide();
			$('a.shownav').fadeIn();
		});
	}


	$(window).scroll(function() {
		if($(this).scrollTop() >= 100){
			$('header').addClass('fixed');
		}else{
			$('header').removeClass('fixed');
		}
	});


	var owl = $('.owl-carousel').owlCarousel({
		autoplay: true,
		autoplayTimeout: 4000,
		slideTransition: 'ease',
		autoplayHoverPause: true,
		navText:["<div class='nav-btn prev-slide'></div>","<div class='nav-btn next-slide'></div>"],
	    loop:true,
		items: 1,
	    margin:55,
	    nav:true,
	    dots: false,
	    responsive:{
	        0:{
	            items:1
	        },
	        440:{
	            items:1
	        },
	        960:{
	            items:1
	        },
	        2200:{
	            items:1
	        }
	    }
	});
});