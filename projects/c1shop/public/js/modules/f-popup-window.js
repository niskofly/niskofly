$(".js-popup").magnificPopup();


function open_magnific_popup(namePopup){
	$.magnificPopup.open({
		items: {
			src: namePopup
		}
	});

	return false;
}

$(document).on('click', '.js-widget-popup', function(){
	open_magnific_popup($(this).attr('data-mfp-src'));
});


$(document).on('click', '.js-toggle-clients-tab', function(){
	$('.clients-tab__content.status-active').toggle('hide').removeClass('status-active');
	$(this).closest('.clients-tab').find('.clients-tab__content').toggle().addClass('status-active');
	$(this).find('.clients-tab__toggle').toggleClass('status-tab_close')
});