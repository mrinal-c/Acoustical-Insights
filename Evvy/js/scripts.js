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

	var owl = $('.relevant-services-owl-carousel').owlCarousel({
		autoplay: true,
		autoplayTimeout: 4000,
		slideTransition: 'ease',
		autoplayHoverPause: true,
	    loop:false,
	    margin:55,
	    nav:true,
	    dots: false,
	    responsive:{
	        0:{
	            items:1
	        },
	        440:{
	            items:3
	        },
	        960:{
	            items:3
	        },
	        2200:{
	            items:5
	        }
	    }
	});


	var bannerOwl = $('.banner-owl-carousel').owlCarousel({
		autoplay: true,
		autoplayTimeout: 4000,
		slideTransition: 'ease',
		autoplayHoverPause: true,
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
	const items = document.querySelectorAll(".banner .owl-carousel .item");
	items.forEach((item, index) => {
		const prev = document.createElement("div");
		const next = document.createElement("div");

		prev.classList.add("banner-prev");
		next.classList.add("banner-next");

		const prevIcon = document.createElement("span");
		const nextIcon = document.createElement("span");
		prevIcon.classList.add("fa-solid", "fa-arrow-left", "icon");
		nextIcon.classList.add("fa-solid", "fa-arrow-right", "icon");

		prev.appendChild(prevIcon);
		next.appendChild(nextIcon);

		item.appendChild(prev);
		item.appendChild(next)
		
	})
	$('.banner-prev').click(function() {
		bannerOwl.trigger('prev.owl.carousel');
	});
	$('.banner-next').click(function() {
		bannerOwl.trigger('next.owl.carousel');
	});
});