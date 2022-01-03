brands_slider = $('.js-b-slider-content').lightSlider({
	item:6,
	loop:false,
	slideMargin: 0,
	slideMove:1,
	easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
	speed:600,
	pager: false,
	responsive : [
	{
		breakpoint:800,
		settings: {
			item:3,
			slideMove:1,
		}
	},
	{
		breakpoint:480,
		settings: {
			item:2,
			slideMove:1
		}
	}
	]
});

promotions_slider = $('.js-b-slider-content_promotions').lightSlider({
	item:3,
	loop:false,
	slideMargin: 0,
	slideMove:1,
	easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
	speed:600,
	pager: false,
	responsive : [
	{
		breakpoint:800,
		settings: {
			item:3,
			slideMove:1,
		}
	},
	{
		breakpoint:480,
		settings: {
			item:2,
			slideMove:1
		}
	}
	]
});

news_slider = $('.js-b-slider-content_news').lightSlider({
	item:2,
	loop:false,
	slideMargin: 50,
	slideMove:1,
	easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
	speed:600,
	pager: false,
	responsive : [
	{
		breakpoint:800,
		settings: {
			item:3,
			slideMove:1,
		}
	},
	{
		breakpoint:480,
		settings: {
			item:2,
			slideMove:1
		}
	}
	]
});

document.querySelectorAll('.js-b-slider-content_realizovannye-proekty').forEach(function(element, index){
	window['realizovannye_proekty_'+index ]= $(element).lightSlider({
		item:5,
		loop:false,
		slideMargin: 6,
		slideMove:1,
		easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
		speed:600,
		pager: false,
		responsive : [
		{
			breakpoint:800,
			settings: {
				item:3,
				slideMove:1,
			}
		},
		{
			breakpoint:480,
			settings: {
				item:2,
				slideMove:1
			}
		}
		]
	});
})


$(document).on('click', '.js-prev-banner', function(){
	var slider = $(this).attr('data-slider');
	window[slider].goToPrevSlide();
});

$(document).on('click', '.js-next-banner', function(){
	var slider = $(this).attr('data-slider');
	window[slider].goToNextSlide();
});