$(document).on('click', '.js-current-sorting' , function(){

	toggle_Sorting_Catalog($(this));
	
});

$(document).on('click', '.js-sorting-option' , function(){
	$('.js-current-sorting__value').text($(this).text());
	toggle_Sorting_Catalog($('.js-current-sorting'));
	
});


function toggle_Sorting_Catalog(element){

	var that = element

	if(that.hasClass('active')){

		$('.sorting-options').removeClass('js-visible-list');
		that.removeClass('active');
		that.find('.toggle-current-sorting ').toggleClass('status-off');

	} else {

		$('.sorting-options').removeClass('js-visible-list');
		that.addClass('active');
		$('.sorting-options').addClass('js-visible-list');
		that.find('.toggle-current-sorting ').toggleClass('status-off');
	}
}