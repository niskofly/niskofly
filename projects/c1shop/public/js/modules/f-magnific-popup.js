$('.js-popup-gallery').magnificPopup({
	delegate: '.js-popup-photo',
	type: 'image',
	tLoading: 'Loading image #%curr%...',
	mainClass: 'mfp-img-mobile',
	gallery: {
		enabled: true,
		navigateByImgClick: true,
		preload: [0,1]
	},
	image: {
		tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
		titleSrc: function(item) {
			return item.el.attr('title');
		}
	}
});

$('.js-popup-photo__this').magnificPopup({
	type: 'image',
	closeOnContentClick: true,
	image: {
		verticalFit: false
	}
});