var $body,
windowHeight,
windowWidth,
mediaPoint1 = 1024,
mediaPoint2 = 768,
mediaPoint3 = 480,
mediaPoint4 = 320;

$(document).ready(function ($) {
	$body = $('body');
	windowWidth = $(window).width();
	windowHeight = $(window).height();

	//developer funcitons
	pageWidget(['index', 'catalog', 'product',
		'my-list', 'o-kompanii', 'realizovannye-proekty', 
		'clients', 'contact', 'service', 'gotovye-proekty',
		'servisnoe-garant', 'zapchasti', 'raschjot-komplektacii'], true);

	popupWidget([ 
		['Благодарность', '.thanks-popup'],
		['Заказать звонок', '.request-callback'],
		['Подбор комплекта', '.get-price-from-kit'],
		['Заявка на оборудование', '.request-from-product'],
		['Клиентов по России', '.clients-popup'],
		]);
	//getAllClasses('html','.elements_list');
});

$(window).on('load', function () {
	loadFunc();
});

$(window).on('resize', function () {
	resizeFunc();
});

$(window).on('scroll', function () {
	scrollFunc();
});

function loadFunc() {

}
function resizeFunc() {
	updateSizes();
}

function scrollFunc() {
	updateSizes();
}

function updateSizes() {
	windowWidth = $(window).width();
	windowHeight = $(window).height();
}

if ('objectFit' in document.documentElement.style === false) {
	document.addEventListener('DOMContentLoaded', function () {
		Array.prototype.forEach.call(document.querySelectorAll('img[data-object-fit]'), function (image) {
			(image.runtimeStyle || image.style).background = 'url("' + image.src + '") no-repeat 50%/' + (image.currentStyle ? image.currentStyle['object-fit'] : image.getAttribute('data-object-fit'));

			image.src = 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'' + image.width + '\' height=\'' + image.height + '\'%3E%3C/svg%3E';
		});
	});
}

//Functions for development
function getAllClasses(context, output) {
	var finalArray = [],
	mainArray = [],
		allElements = $(context).find($('*'));//get all elements of our page
	//If element has class push this class to mainArray
	for (var i = 0; i < allElements.length; i++) {
		var someElement = allElements[i],
		elementClass = someElement.className;
		if (elementClass.length > 0) {//if element have not empty class
			//If element have multiple classes - separate them
			var elementClassArray = elementClass.split(' '),
			classesAmount = elementClassArray.length;
			if (classesAmount === 1) {
				mainArray.push('.' + elementClassArray[0] + ' {');
			} else {
				var cascad = '.' + elementClassArray[0] + ' {';
				for (var j = 1; j < elementClassArray.length; j++) {
					cascad += ' &.' + elementClassArray[j] + ' { }';
				}
				mainArray.push(cascad);
			}
		}
	}

	//creating finalArray, that don't have repeating elements
	var noRepeatingArray = unique(mainArray);
	noRepeatingArray.forEach(function (item) {
		var has = false;
		var preWords = item.split('&');
		for (var i = 0; i < finalArray.length; ++i) {
			var newWords = finalArray[i].split('&');
			if (newWords[0] == preWords[0]) {
				has = true;
				for (var j = 0; j < preWords.length; ++j) {
					if (newWords.indexOf(preWords[j]) < 0) {
						newWords.push(preWords[j]);
					}
				}
				finalArray[i] = newWords.join('&');
			}
		}
		if (!has) {
			finalArray.push(item);
		}
	});
	for (var i = 0; i < finalArray.length; i++) {
		$('<div>' + finalArray[i] + ' }</div>').appendTo(output);
	}


	//function that delete repeating elements from arrays, for more information visit http://mathhelpplanet.com/static.php?p=javascript-algoritmy-obrabotki-massivov
	function unique(A) {
		var n = A.length, k = 0, B = [];
		for (var i = 0; i < n; i++) {
			var j = 0;
			while (j < k && B[j] !== A[i]) j++;
			if (j == k) B[k++] = A[i];
		}
		return B;
	}
}

function pageWidget(pages, backend) {
	var widgetWrap = $('<div class="widget_wrap"><p>СТРАНИЦЫ</p><ul class="widget_list"></ul></div>');
	widgetWrap.prependTo("body");
	for (var i = 0; i < pages.length; i++) {
		if(backend){
			if(i == 0){
				$('<li class="widget_item"><a class="widget_link" href="/">' + pages[i] + '</a></li>').appendTo('.widget_list');
			} else{
				$('<li class="widget_item"><a class="widget_link" href="/' + pages[i] + '">' + pages[i] + '</a></li>').appendTo('.widget_list');			
			}
		} else{
			$('<li class="widget_item"><a class="widget_link" href="/' + pages[i] + '.html' + '">' + pages[i] + '</a></li>').appendTo('.widget_list');
		}

	}
	var widgetStilization = $('<style>body {position:relative} .widget_wrap{position:fixed;top:0;left:0;z-index:9999;padding:10px 20px;background:#222;border-bottom-right-radius:10px;-webkit-transition:all .3s ease;transition:all .3s ease;-webkit-transform:translate(-100%,0);-ms-transform:translate(-100%,0);transform:translate(-100%,0)}.widget_wrap:after{content:" ";position:absolute;top:0;left:100%;width:24px;height:24px;background:#222 url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQAgMAAABinRfyAAAABGdBTUEAALGPC/xhBQAAAAxQTFRF////////AAAA////BQBkwgAAAAN0Uk5TxMMAjAd+zwAAACNJREFUCNdjqP///y/DfyBg+LVq1Xoo8W8/CkFYAmwA0Kg/AFcANT5fe7l4AAAAAElFTkSuQmCC) no-repeat 50% 50%;cursor:pointer}.widget_wrap:hover{-webkit-transform:translate(0,0);-ms-transform:translate(0,0);transform:translate(0,0)}.widget_item{padding:0 0 10px}.widget_link{color:#fff;text-decoration:none;font-size:15px;}.widget_link:hover{text-decoration:underline} </style>');
	widgetStilization.prependTo(".widget_wrap");
}


function popupWidget(popups) {
	var widgetWrap = $('<div class="widget_wrap-popup"><p> ВСПЛЫВАЮЩИЕ ОКНА </p><ul class="widget_list-popup"></ul></div>');
	widgetWrap.prependTo("body");
	for (var i = 0; i < popups.length; i++) {
		$('<li class="widget_item"><a class="widget_link js-widget-popup"  data-mfp-src="' + popups[i][1] + '" href="#">' + popups[i][0] + '</a></li>').appendTo('.widget_list-popup');

	}
	var widgetStilization = $('<style>body {position:relative} .widget_wrap-popup{position:fixed;top:24px;left:0;z-index:9999;padding:10px 20px;background:#222;border-bottom-right-radius:10px;-webkit-transition:all .3s ease;transition:all .3s ease;-webkit-transform:translate(-100%,0);-ms-transform:translate(-100%,0);transform:translate(-100%,0)}.widget_wrap-popup:after{content:" ";position:absolute;top:0;left:100%;width:24px;height:24px;background:#222 url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQAgMAAABinRfyAAAABGdBTUEAALGPC/xhBQAAAAxQTFRF////////AAAA////BQBkwgAAAAN0Uk5TxMMAjAd+zwAAACNJREFUCNdjqP///y/DfyBg+LVq1Xoo8W8/CkFYAmwA0Kg/AFcANT5fe7l4AAAAAElFTkSuQmCC) no-repeat 50% 50%;cursor:pointer}.widget_wrap-popup:hover{-webkit-transform:translate(0,0);-ms-transform:translate(0,0);transform:translate(0,0)}.widget_item{padding:0 0 10px}.widget_link{color:#fff;text-decoration:none;font-size:15px;}.widget_link:hover{text-decoration:underline} </style>');
	widgetStilization.prependTo(".widget_wrap-popup");
}

// Подключение слайдера и его функционала
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


// Подключение функций каталога
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


// Подключение функций для работы с magnific-popup.js
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

// Подключение функций для работы всплывающих окон
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

// Подключение функций для работы всплывающих окон
$('.input[type="tel"]').inputmask("+7 (999) 999-99-99");


// Подключение SVG на продакшен перенести его код в header выше подключения всех скриптов
;( function( window, document )
{
	'use strict';

	var file     = '/img/sprite/sprite.svg',
	revision = 1;

	if( !document.createElementNS || !document.createElementNS( 'http://www.w3.org/2000/svg', 'svg' ).createSVGRect )
		return true;

	var isLocalStorage = 'localStorage' in window && window[ 'localStorage' ] !== null,
	request,
	data,
	SVG_container = document.getElementById('SVG_container'),
	insertIT = function()
	{
		SVG_container.insertAdjacentHTML( 'afterbegin', data );
	},
	insert = function()
	{
		if( document.body ) insertIT();
		else document.addEventListener( 'DOMContentLoaded', insertIT );
	};

	if( isLocalStorage && localStorage.getItem( 'inlineSVGrev' ) == revision )
	{
		data = localStorage.getItem( 'inlineSVGdata' );
		if( data )
		{
			insert();
			return true;
		}
	}

	try
	{
		request = new XMLHttpRequest();
		request.open( 'GET', file, true );
		request.onload = function()
		{
			if( request.status >= 200 && request.status < 400 )
			{
				data = request.responseText;
				insert();
				if( isLocalStorage )
				{
					localStorage.setItem( 'inlineSVGdata',  data );
					localStorage.setItem( 'inlineSVGrev',   revision );
				}
			}
		}
		request.send();
	}
	catch( e ){}

}( window, document ) );


// НОВЫЙ JS

function getCookieValueByArrayFunctions(a, b, c) {
    b = '; ' + document.cookie;
    c = b.split('; ' + a + '=');
    return !!(c.length - 1) ? c.pop().split(';').shift() : '';
};

function setCookie (name, value, expires, path, domain, secure) {
    document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
};

$(document).on('click', '.js-add-list', function () {
    setCookieInfo('js-list-products', $(this).attr('data-product-id'), true)
});


function setCookieInfo(name_cokie, value, is_callback) {
    var today = new Date(),
        inWeek = new Date(),
        listProducts = getCookieValueByArrayFunctions(name_cokie),
        currentId = value;

    if(listProducts.length === 0){
        listProducts = [];
    } else {
        listProducts = listProducts.split('-');
    }

    if(listProducts.indexOf(currentId) == -1){
        listProducts.push(currentId);
    } else {

        var idx = listProducts.indexOf(currentId);
        if (idx != -1) {
            listProducts.splice(idx,1);
        }
    }

    if(is_callback){
        if(listProducts.length != 0){
            $('.js-count-basket').text(listProducts.length);
        } else {
            $('.js-count-basket').text('');
        }
	}


    listProducts = listProducts.join('-');
    inWeek.setDate(today.getDate()+31);

    setCookie(name_cokie, listProducts , inWeek, '/')
}

$(document).on('click', '.js-uploaded-product__delete', function () {
	var id = $(this).attr('data-product-id');
    setCookieInfo('js-list-products', id,  true);

    $('[data-uploaded-row="'+id+'"]').remove();
});
