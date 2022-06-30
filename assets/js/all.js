(function($){ 
   $(document).ready(function() {
    $('.information_menu').find('li').hover(function(e) {
        $('.information_menu').find('li').removeClass('active');
        $(this).addClass('active');
        $(".overlay-item").removeClass("active");
        $(".overlay-item").removeClass("inactive");
		$(".overlay-id"+$(this).data("id")).addClass("active").removeClass("inactive");
        $(".overlay-id"+$(this).data("id")).prev().addClass("inactive")
    });     
	
    $('.slideshow').children().on('mouseleave',function(e) {
		$(this).removeClass("active");
	});    
    
    $('.carousel').carousel();
   });
})(jQuery);

 

  $(document).ready(function()
	{


	if($('.bbb_viewed_slider').length)
	{
	var viewedSlider = $('.bbb_viewed_slider');

	viewedSlider.owlCarousel(
	{
	loop:true,
	margin:30,
	autoplay:true,
	autoplayTimeout:6000,
	nav:false,
	dots:false,
	responsive:
	{
	0:{items:1},
	575:{items:2},
	768:{items:3},
	991:{items:4},
	1199:{items:6}
	}
	});

	if($('.bbb_viewed_prev').length)
	{
	var prev = $('.bbb_viewed_prev');
	prev.on('click', function()
	{
	viewedSlider.trigger('prev.owl.carousel');
	});
	}

	if($('.bbb_viewed_next').length)
	{
	var next = $('.bbb_viewed_next');
	next.on('click', function()
	{
	viewedSlider.trigger('next.owl.carousel');
	});
	}
	}


	});
	  $(document).ready(function(){

		if($('.brands_slider').length)
		{
		var brandsSlider = $('.brands_slider');

		brandsSlider.owlCarousel(
		{
		loop:true,
		autoplay:true,
		autoplayTimeout:5000,
		nav:false,
		dots:false,
		autoWidth:true,
		items:8,
		margin:42
		});

		if($('.brands_prev').length)
		{
		var prev = $('.brands_prev');
		prev.on('click', function()
		{
		brandsSlider.trigger('prev.owl.carousel');
		});
		}

		if($('.brands_next').length)
		{
		var next = $('.brands_next');
		next.on('click', function()
		{
		brandsSlider.trigger('next.owl.carousel');
		});
		}
		}


	});
  $(function() {

  $("ul.dropdown-menu [data-toggle='dropdown']").on("click", function(event) {
    event.preventDefault();
    event.stopPropagation();

    $(this).siblings().toggleClass("show");


    if (!$(this).next().hasClass('show')) {
      $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
    }
    $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
      $('.dropdown-submenu .show').removeClass("show");
    });

  });
});
  $('#accordion .collapse').collapse('show');
  $(function() {
	$('.material-card > .mc-btn-action').click(function () {
		var card = $(this).parent('.material-card');
		var icon = $(this).children('i');
		icon.addClass('fa-spin-fast');

		if (card.hasClass('mc-active')) {
			card.removeClass('mc-active');

			window.setTimeout(function() {
				icon
					.removeClass('fa-arrow-left ripple')
					.removeClass('fa-spin-fast')
					.addClass('fa-bars');

			}, 800);
		} else {
			card.addClass('mc-active');

			window.setTimeout(function() {
				icon
					.removeClass('fa-bars')
					.removeClass('fa-spin-fast')
					.addClass('fa-arrow-left ripple');

			}, 800);
		}
	});});
$('#carousel').on('slide.bs.carousel', function (e) {

    var $e = $(e.relatedTarget);
    var idx = $e.index();
    var itemsPerSlide = 6;
    var totalItems = $('.carousel-item').length;

    if (idx >= totalItems-(itemsPerSlide-1)) {
        var it = itemsPerSlide - (totalItems - idx);
        for (var i=0; i<it; i++) {
            if (e.direction=="left") {
                $('.carousel-item').eq(i).appendTo('.carousel-inner');
            }
            else {
                $('.carousel-item').eq(0).appendTo('.carousel-inner');
            }
        }
    }
});