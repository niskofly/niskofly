var $body,
    windowHeight,
    windowWidth,
    mediaPoint1 = 1024,
    mediaPoint2 = 768,
    mediaPoint3 = 480,
    mediaPoint4 = 320;

function dd(data) {
    console.dir(data);
}

$(document).ready(function ($) {
    $body = $('body');
    windowWidth = $(window).width();
    windowHeight = $(window).height();

    //developer funcitons
    // pageWidget(['index', 'catalog', 'product',
    // 	'my-list', 'o-kompanii', 'realizovannye-proekty',
    // 	'clients', 'contact', 'service', 'gotovye-proekty',
    // 	'servisnoe-garant', 'zapchasti', 'raschjot-komplektacii'], true);

    // popupWidget([
    // 	['Благодарность', '.thanks-popup'],
    // 	['Заказать звонок', '.request-callback'],
    // 	['Подбор комплекта', '.get-price-from-kit'],
    // 	['Заявка на оборудование', '.request-from-product'],
    // 	['Клиентов по России', '.clients-popup'],
    // 	]);
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
        if (backend) {
            if (i == 0) {
                $('<li class="widget_item"><a class="widget_link" href="/">' + pages[i] + '</a></li>').appendTo('.widget_list');
            } else {
                $('<li class="widget_item"><a class="widget_link" href="/' + pages[i] + '">' + pages[i] + '</a></li>').appendTo('.widget_list');
            }
        } else {
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
    item: 4,
    loop: false,
    slideMargin: 10,
    slideMove: 1,
    easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
    speed: 600,
    pager: false,
    responsive: [
        {
            breakpoint: 800,
            settings: {
                item: 3,
                slideMove: 1,
            }
        },
        {
            breakpoint: 480,
            settings: {
                item: 1.5,
                slideMove: 1
            }
        }
    ]
});

promotions_slider = $('.js-b-slider-content_promotions').lightSlider({
    item: 3,
    loop: false,
    slideMargin: 10,
    slideMove: 1,
    easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
    speed: 600,
    pager: false,
    responsive: [
        {
            breakpoint: 832,
            settings: {
                item: 2,
                slideMove: 1,
            }
        },
        {
            breakpoint: 600,
            settings: {
                item: 1.2,
                slideMove: 1
            }
        }
    ]
});

news_slider = $('.js-b-slider-content_news').lightSlider({
    item: 3,
    loop: false,
    slideMargin: 50,
    slideMove: 1,
    easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
    speed: 600,
    pager: false,
    responsive: [
        {
            breakpoint: 800,
            settings: {
                item: 2,
                slideMove: 1,
            }
        },
        {
            breakpoint: 600,
            settings: {
                item: 1.2 ,
                slideMove: 1
            }
        }
    ]
});

customers_slider = $('.js-customers_slider').lightSlider({
    item: 5,
    loop: false,
    slideMargin: 10,
    slideMove: 1,
    easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
    speed: 600,
    pager: false,
    responsive: [
        {
            breakpoint: 800,
            settings: {
                item: 3,
                slideMove: 1,
            }
        },
        {
            breakpoint: 600,
            settings: {
                item: 2,
                slideMove: 1
            }
        },
        {
            breakpoint: 500,
            settings: {
                item: 1.2,
                slideMove: 1
            }
        }
    ]
});

document.querySelectorAll('.js-b-slider-content_realizovannye-proekty').forEach(function (element, index) {
    window['realizovannye_proekty_' + index] = $(element).lightSlider({
        item: 5,
        loop: false,
        slideMargin: 6,
        slideMove: 1,
        easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
        speed: 600,
        pager: false,
        responsive: [
            {
                breakpoint: 800,
                settings: {
                    item: 3,
                    slideMove: 1,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    item: 1.5,
                    slideMove: 1
                }
            }
        ]
    });
})


$(document).on('click', '.js-prev-banner', function () {
    var slider = $(this).attr('data-slider');
    window[slider].goToPrevSlide();
});

$(document).on('click', '.js-next-banner', function () {
    var slider = $(this).attr('data-slider');
    window[slider].goToNextSlide();
});


// Подключение функций каталога
$(document).on('click', '.js-current-sorting', function () {

    toggle_Sorting_Catalog($(this));

});


function toggle_Sorting_Catalog(element) {

    var that = element

    if (that.hasClass('active')) {

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
        preload: [0, 1]
    },
    image: {
        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
        titleSrc: function (item) {
            return item.el.attr('title');
        }
    }
});

$('.js-popup-gallery--dark').magnificPopup({
    delegate: '.js-popup-photo',
    type: 'image',
    tLoading: 'Loading image #%curr%...',
    mainClass: 'bg-dark',
    gallery: {
        enabled: true,
        navigateByImgClick: true,
        preload: [0, 1]
    },
    image: {
        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
        titleSrc: function (item) {
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
$(".js-popup").magnificPopup({
    mainClass: 'mfp-fade',
    removalDelay: 300,
});


function open_magnific_popup(namePopup) {
    $.magnificPopup.open({
        items: {
            src: namePopup
        },
        mainClass: 'mfp-fade',
        removalDelay: 300
    });

    return false;
}

$(document).on('click', '.js-widget-popup', function () {
    open_magnific_popup($(this).attr('data-mfp-src'));
});


$(document).on('click', '.js-toggle-clients-tab', function () {
    $('.clients-tab__toggle').addClass('status-tab_close');
    $(this).find('.clients-tab__toggle').removeClass('status-tab_close');

    $('.clients-tab__content').css('display', 'none');

    var tabContent = $(this).parent().find('.clients-tab__content');
    if (tabContent.hasClass('status-active')) {
        tabContent.css('display', 'none').removeClass('status-active');
        $('.clients-tab__toggle').addClass('status-tab_close');
    } else {
        $('.clients-tab__content').removeClass('status-active');
        tabContent.css('display', 'block').addClass('status-active');
    }

    //
    // $('.clients-tab__content.status-active').toggle('hide').removeClass('status-active');
    // $(this).parent('.clients-tab').find('.clients-tab__content').toggle().addClass('status-active');

});

// Подключение функций для работы всплывающих окон
$('.input[type="tel"]').inputmask("+7 (999) 999-99-99");


// Подключение SVG на продакшен перенести его код в header выше подключения всех скриптов
;( function (window, document) {
    'use strict';

    var file = '/img/sprite/sprite.svg',
        revision = 3;

    if (!document.createElementNS || !document.createElementNS('http://www.w3.org/2000/svg', 'svg').createSVGRect)
        return true;

    var isLocalStorage = 'localStorage' in window && window['localStorage'] !== null,
        request,
        data,
        SVG_container = document.getElementById('SVG_container'),
        insertIT = function () {
            SVG_container.insertAdjacentHTML('afterbegin', data);
        },
        insert = function () {
            if (document.body) insertIT();
            else document.addEventListener('DOMContentLoaded', insertIT);
        };

    if (isLocalStorage && localStorage.getItem('inlineSVGrev') == revision) {
        data = localStorage.getItem('inlineSVGdata');
        if (data) {
            insert();
            return true;
        }
    }

    try {
        request = new XMLHttpRequest();
        request.open('GET', file, true);
        request.onload = function () {
            if (request.status >= 200 && request.status < 400) {
                data = request.responseText;
                insert();
                if (isLocalStorage) {
                    localStorage.setItem('inlineSVGdata', data);
                    localStorage.setItem('inlineSVGrev', revision);
                }
            }
        }
        request.send();
    }
    catch (e) {
    }

}(window, document) );


// НОВЫЙ JS

$(document).on('submit', '.js-send-price', function () {
    var form = $(this);

    if (typeof (yaCounter42853119) != 'undefined') {
        yaCounter42853119.reachGoal('zayavka_form');
    }

    if (typeof (ga) != undefined){
        ga('send','event','form','zayavka_form');
    }
    $('form').append('<input type="hidden"  name="tags"  value="получить прайс"/>');
    $.ajax({
        url: '/api/handler.php',
        data: form.serialize(),
        type: "POST",
        success: function (data) {

        }
    });

    $.ajax({
        url: '/sendEmailPrice',
        data: form.serialize(),
        type: "POST",
        success: function (data) {
            form[0].reset();
            open_magnific_popup('.thanks-popup')
        }
    });

    return false;
});

$(document).on('submit', '.js-request-callback__form', function () {
    var form = $(this);

    if (typeof (yaCounter42853119) != 'undefined') {
        yaCounter42853119.reachGoal('zayavka_form');
    }
    if (typeof (ga) != undefined){
        ga('send','event','form','zayavka_form');
    }
    $('form').append('<input type="hidden"  name="tags"  value="заказать обратный звонок"/>');
    $.ajax({
        url: '/api/handler.php',
        data: form.serialize(),
        type: "POST",
        success: function (data) {

        }
    });

    $.ajax({
        url: '/sendEmailCallback',
        data: form.serialize(),
        type: "POST",
        success: function (data) {
            form[0].reset();
            open_magnific_popup('.thanks-popup')
        }
    });

    return false;
});

$(document).on('submit', '.js-request-product-card', function () {
    var form = $(this);

    if (typeof (yaCounter42853119) != 'undefined') {
        yaCounter42853119.reachGoal('zayavka_form');
    }
    if (typeof (ga) != undefined){
        ga('send','event','form','zayavka_form');
    }
    var product =  $('.js-request-product').attr('data-product-name');
    $('form').append('<input type="hidden"  name="tags"  value="Заявка на оборудование"/>');
    $('form').append('<input type="hidden"  name="product"  value="'+product+'"/>');
    $.ajax({
        url: '/api/handler.php',
        data: form.serialize(),
        type: "POST",
        success: function (data) {
        }
    });

    $.ajax({
        url: '/sendEmailRequestCardProduct',
        data: form.serialize(),
        type: "POST",
        success: function (data) {
            form[0].reset();
            open_magnific_popup('.thanks-popup')
        }
    });

    return false;
});

$(document).on('click', '.js-request-product', function () {
    var name = $(this).attr('data-product-name'),
        id = $(this).attr('data-product-id');

    $('.js-name-product-popup_request').text(name);
    $('.js-id-product-popup_request').val(id);
    open_magnific_popup('.request-from-product');
});

$(document).on('click', '.js-zakaz-zvonok', function () {
    open_magnific_popup('.request-callback');
});

$(document).on('click', '.js-btn-price-list', function () {
    open_magnific_popup('.get-price-from-kit');
});


function getCookieValueByArrayFunctions(a, b, c) {
    b = '; ' + document.cookie;
    c = b.split('; ' + a + '=');
    return !!(c.length - 1) ? c.pop().split(';').shift() : '';
};

function setCookie(name, value, expires, path, domain, secure) {
    document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
};

$(document).on('click', '.js-add-list', function () {

    if (typeof (yaCounter42853119) != 'undefined') {
        yaCounter42853119.reachGoal('dobavili_v_moi_spisok');
    }

    setCookieInfo('js-list-products', $(this).attr('data-product-id'), true)
});
getCookieValueByArrayFunctions('js-list-products')

function setCookieInfo(name_cokie, value, is_callback) {
    var today = new Date(),
        inWeek = new Date(),
        listProducts = getCookieValueByArrayFunctions(name_cokie),
        currentId = value;

    if (listProducts.length === 0) {
        listProducts = [];
    } else {
        listProducts = listProducts.split('-');
    }

    if (listProducts.indexOf(currentId) == -1) {
        listProducts.push(currentId);
    } else {

        var idx = listProducts.indexOf(currentId);
        if (idx != -1) {
            listProducts.splice(idx, 1);
        }
    }

    if (is_callback) {
        if (listProducts.length != 0) {
            $('.js-count-basket').text(listProducts.length);
        } else {
            $('.js-count-basket').text(0);
        }
    }


    listProducts = listProducts.join('-');
    inWeek.setDate(today.getDate() + 31);

    setCookie(name_cokie, listProducts, inWeek, '/')
}

$(document).on('click', '.js-uploaded-product__delete', function () {
    var id = $(this).attr('data-product-id');
    setCookieInfo('js-list-products', id, true);

    $('[data-uploaded-row="' + id + '"]').remove();
});

balanceWidthTable();

function balanceWidthTable() {
    var maxWidth = 0;
    $('.specifications-product__value').each(function (index, item) {
        if (item.clientWidth > maxWidth) {
            maxWidth = item.clientWidth;
        }
    });

    $('.specifications-product__value').each(function (index, item) {
        item.style.width = maxWidth + 'px';
        dd(getComputedStyle(item).paddingLeft)
    });
}

$(document).on('click', '.js-sorting-option', function () {
    $('.js-current-sorting__value').text($(this).text());
    toggle_Sorting_Catalog($('.js-current-sorting'));

    var filter_name = $(this).attr('data-sort-name'),
        filter_type = $(this).attr('data-sort-type'),
        today = new Date(),
        inWeek = new Date();
    inWeek.setDate(today.getDate() + 31);

    setCookie('name-sort', filter_name, inWeek, '/');
    setCookie('type-sort', filter_type, inWeek, '/');
    var linkReload = window.activeFilter || location.href;

    location.href = linkReload;
});

if (getCookieValueByArrayFunctions('name-sort') && getCookieValueByArrayFunctions('type-sort')) {
    if (getCookieValueByArrayFunctions('name-sort') == 'actual_price') {
        if (getCookieValueByArrayFunctions('type-sort') == 'asc') {
            $('.js-current-sorting__value').text($('.js-price-asc').text());
        } else {
            $('.js-current-sorting__value').text($('.js-price-desc').text());
        }
    } else {
        $('.js-current-sorting__value').text($('.js-popular').text());
    }
}

$(document).on('click', '.js-show-in-stock', function () {
    var is_vue_filter = window.activeFilter ? true : false,
        activeFilter = window.activeFilter || location.href + '/',
        url = activeFilter,
        regV = /in-stock/g,
        result = url.match(regV);

    dd(is_vue_filter);
    if (result) {
        location.href = activeFilter.replace('in-stock/', '');
    } else {
        location.href = activeFilter + 'in-stock/';
    }
});

if (!window.activeFilter) {
    setInputStock();
}

function setInputStock() {
    var url = location.href + '/',
        regV = /in-stock/g,
        result = url.match(regV);

    if (result) {
        document.querySelector('#show-stock').checked = true;
    }
}


$(document).on('click', '.js-add-request-kit', function () {
    var id_project = $(this).attr('data-id-project'),
        name_project = $(this).attr('data-name-project'),
        popup = $('.request-ready-made-projects');

    popup.find('.js-id-projects').val(id_project);
    popup.find('.js-name-ready-made-projects').text(name_project);
    open_magnific_popup('.request-ready-made-projects');
});


$(document).on('submit', '.js-request-ready-made-projects', function () {
    var form = $(this);

    if (typeof (yaCounter42853119) != 'undefined') {
        yaCounter42853119.reachGoal('zayavka_form');
    }
    if (typeof (ga) != undefined){
        ga('send','event','form','zayavka_form');
    }
    var projects =  $('.js-add-request-kit').attr('data-name-project')+' - id: '
        +$('.js-add-request-kit').attr('data-id-project');
    $('form').append('<input type="hidden"  name="tags"  value="Заявка на комплект"/>');
    $('form').append('<input type="hidden"  name="product"  value="'+projects+'"/>');
    $.ajax({
        url: '/api/handler.php',
        data: form.serialize(),
        type: "POST",
        success: function (data) {
        }
    });

    $.ajax({
        url: '/sendEmailReadyMadeProject',
        data: form.serialize(),
        type: "POST",
        success: function (data) {
            form[0].reset();
            open_magnific_popup('.thanks-popup')
        }
    });

    return false;
});

$(document).on('submit', '.js-send-request-service-and-guarantee', function () {
    var form = $(this);

    if (typeof (yaCounter42853119) != 'undefined') {
        yaCounter42853119.reachGoal('zayavka_form');
    }
    if (typeof (ga) != undefined){
        ga('send','event','form','zayavka_form');
    }
    $.ajax({
        url: '/sendEmailServiceGuarantee',
        data: form.serialize(),
        type: "POST",
        success: function (data) {
            form[0].reset();
            open_magnific_popup('.thanks-popup')
        }
    });

    return false;
});

zapchasti_item_id = 1;

$(document).on('click', '.js-zapchasti-item_add', function () {
    var container = $('.js-zapchasti__container'),
        content = $('.wrap-js-copy-container').html();
    container.append(content.replace(/#id#/g, zapchasti_item_id));
    zapchasti_item_id++;

    toggleBtnZapchasti();
});

function toggleBtnZapchasti() {
    var container = $('.js-zapchasti__container'),
        last_item = container.find('.request-zapchasti__item').last();

    container.find('.js-zapchasti-item_add').css('display', 'none');
    last_item.find('.js-zapchasti-item_add').show();

    if (container.find('.request-zapchasti__item').length > 1) {
        $('.zapchasti-item-0').find('.request-zapchasti__item-buttons').css('display', 'none');
    } else {
        $('.zapchasti-item-0').find('.request-zapchasti__item-buttons').show()
    }
}

$(document).on('click', '.js-zapchasti-item_delete', function () {
    var id = $(this).attr('data-id-zapchasti');

    $('.zapchasti-item-' + id).remove();
    toggleBtnZapchasti();
});

$(document).on('submit', '.js-request-zapchasti', function () {
    var form = $(this);

    if (typeof (yaCounter42853119) != 'undefined') {
        yaCounter42853119.reachGoal('zayavka_form');
    }
    if (typeof (ga) != undefined){
        ga('send','event','form','zayavka_form');
    }

    $('form').append('<input type="hidden"  name="tags"  value="Заявка на запчасти"/>');

    $.ajax({
        url: '/api/handler.php',
        data: form.serialize(),
        type: "POST",
        success: function (data) {
        }
    });

    $.ajax({
        url: '/sendEmailzapchasti',
        data: form.serialize(),
        type: "POST",
        success: function (data) {
            form[0].reset();
            open_magnific_popup('.thanks-popup')
        }
    });

    return false;
});

$(document).on('click', '.js-open-form-share', function () {
    var id_share = $(this).attr('data-id-share'),
        name_share = $(this).attr('data-name-share'),
        popup = $('.request-share');

    popup.find('.js-id-share').val(id_share);
    popup.find('.js-name-share').text(name_share);
    open_magnific_popup('.request-share');
});

$(document).on('submit', '.js-request-share', function () {
    var form = $(this);

    if (typeof (yaCounter42853119) != 'undefined') {
        yaCounter42853119.reachGoal('zayavka_form');
    }
    if (typeof (ga) != undefined){
        ga('send','event','form','zayavka_form');
    }
    $.ajax({
        url: '/sendEmailShare',
        data: form.serialize(),
        type: "POST",
        success: function (data) {
            form[0].reset();
            open_magnific_popup('.thanks-popup')
        }
    });

    return false;
});


$(document).on('submit', '.js-send-raschjot-komplektacii', function () {
    var form = $(this);

    if (typeof (yaCounter42853119) != 'undefined') {
        yaCounter42853119.reachGoal('zayavka_form');
    }
    if (typeof (ga) != undefined){
        ga('send','event','form','zayavka_form');
    }

    $('form').append('<input type="hidden"  name="tags"  value="Заявка на комплект"/>');

    $.ajax({
        url: '/api/handler.php',
        data: form.serialize(),
        type: "POST",
        success: function (data) {
        }
    });

    $.ajax({
        url: '/sendEmailRaschjotKomplektacii',
        data: form.serialize(),
        type: "POST",
        success: function (data) {
            form[0].reset();
            open_magnific_popup('.thanks-popup')
        }
    });

    return false;
});

$(document).on('submit', '.js-send-basket', function () {
    var form = $(this);

    if (typeof (yaCounter42853119) != 'undefined') {
        yaCounter42853119.reachGoal('zayavka_form');
    }
    if (typeof (ga) != undefined){
        ga('send','event','form','zayavka_form');
    }
    function getCookie(name) {
        var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

    $('form').append('<input type="hidden"  name="tags"  value="Заявка на оборудование"/>');
    $('form').append('<input type="hidden"  name="product"  value=""/>');


    $("[name='product']").val(getCookie('js-list-products'));

    $.ajax({
        url: '/api/handler.php',
        data: form.serialize(),
        type: "POST",
        success: function (data) {
        }
    });

    $.ajax({
        url: '/sendEmailBasket',
        data: form.serialize(),
        type: "POST",
        success: function (data) {
            form[0].reset();
            open_magnific_popup('.thanks-popup')
        }
    });

    return false;
});

webestSearchVector = {
    selectCategoryName: 'Все категории',
    selectCategoryUrl: '',
    is_searchPage: false,

    init: function () {
        if (typeof(__STATE_SEARCH__) != "undefined") {
            if (__STATE_SEARCH__.category.name) {
                this.selectCategoryName = __STATE_SEARCH__.category.name;
                this.selectCategoryUrl = __STATE_SEARCH__.category.url;
            }

            if (__STATE_SEARCH__.query) {
                $('.js-input-search').val(__STATE_SEARCH__.query)
            }
        }


        this.render();
        this.setSearchCategory();
        this.eventHandler();
        this.setActiveCategoryItem();
    },

    eventHandler: function () {
        var that = this;

        $(document).on('click', '.js-action-select-search-category', function () {
            that.ActiveSelect = $(this).attr('data-active-select');
            that.showContainerCategory();
        });

        $(document).on('click', '.js-current-search-category', function () {
            that.selectCategoryName = $(this).text();
            that.selectCategoryUrl = $(this).attr('data-url-category');
            that.showContainerCategory();
            that.setActiveCategoryItem();
        });

        $(document).on('submit', '.js-send-search-form', function () {
            if (that.selectCategoryUrl == '') {
                $(this).find('.js-search-category-input').remove();
            }
        })

    },

    setActiveCategoryItem: function () {
        $('.select-category__item').removeClass('select-category__item--active');
        $('[data-url-category="' + this.selectCategoryUrl + '"]').addClass('select-category__item--active');
    },

    showContainerCategory: function () {
        $(this.ActiveSelect).slideToggle(300);
        this.render();
        this.setSearchCategory();
    },

    render: function () {
        $('.js-name-select-category').text(this.selectCategoryName);
    },

    setSearchCategory: function () {
        $('.js-search-category-input').val(this.selectCategoryUrl);
    }

};


webestSearchVector.init();

GreatBalancer('.b-slider__item_news', '.b-news__description')
function GreatBalancer(block) {
    var wrapWidth = $(block).parent().width(),
        blockWidth = $(block).width(),
        wrapDivide = Math.floor(wrapWidth / blockWidth),
        cellArr = $(block);

    for (var arg = 1; arg <= arguments.length; arg++) {

        for (var i = 0; i <= cellArr.length; i = i + wrapDivide) {
            var maxHeight = 0,
                heightArr = [];

            for (j = 0; j < wrapDivide; j++) {
                heightArr.push($(cellArr[i + j]).find(arguments[arg]));

                if (heightArr[j].outerHeight() > maxHeight) {
                    maxHeight = heightArr[j].outerHeight();
                }

            }

            for (var counter = 0; counter < heightArr.length; counter++) {
                $(cellArr[i + counter]).find(arguments[arg]).outerHeight(maxHeight);
            }

        }
    }
}

$(document).on('click', '.js-check-link-basket', function () {
    if (getCookieValueByArrayFunctions('js-list-products') == '') {
        return false;
    }
});


$(document).on('click', '.js-show-map-contacts', function () {
    var id_city = $(this).attr('data-id-contact');

    var elementClick = $('#js-contact-map');
    var destination = $(elementClick).offset().top;
    $('html, body').animate({scrollTop: destination}, 1100);
    geoObjects[geoObjects__search[id_city]].balloon.open();

});


webestEmailsPage = {
    init: function () {
        this.eventHandler();
        this.setInitialState();
    },


    eventHandler: function () {
        var that = this;
        $(document).on('click', '.js-show-type-emails', function () {
            that.activeType = $(this).attr('data-show-type-emails');
            that.showTabContent();
        });
    },


    showTabContent: function () {
        $('.js-container-emails').hide();
        $('[data-type-emails="' + this.activeType + '"]').show();

        $('.js-show-type-emails').removeClass('active');
        $('[data-show-type-emails="' + this.activeType + '"]').addClass('active');
    },

    setInitialState: function () {
        this.activeType = $('.js-show-type-emails').attr('data-show-type-emails');
        this.showTabContent();
    }
};


webestEmailsPage.init();

$(document).on('click', '.js-set-category-by-brand', function () {
    var url = $(this).attr('data-set-url');
    location.href=url;
    dd(url);
});

$(document).on('click', '.js-toggle-menu', function(){
    $('.js-media-menu').toggleClass('show-media-menu');

    if($('.js-media-menu').hasClass('show-media-menu')){
        $('body,html').css('overflow', 'hidden')
    } else {
        $('body,html').css('overflow', 'auto');
        $('.media-menu__sub-categories').removeClass('show-sub-categories');
        $('.media-menu__categories').removeClass('show-categories');
    }
});

$(document).on('click', '.js-show-categories', function(){
    $('.media-menu__categories').toggleClass('show-categories');
});


$(document).on('click', '.js-hide-sub_categories', function(){
    $('.media-menu__sub-categories').removeClass('show-sub-categories');
});


$(document).on('click', '.js-show-sub-category', function(){
    var id = $(this).attr('data-id-sub-categories');
    $('#'+id).addClass('show-sub-categories');
});


custom_select = function(element) {
    var $container = element,
        $btn = $container.find('.js-custom-select-toggle'),
        $list = $container.find('.js-custom-select-list'),
        input_name = $container.attr('data-name'),
        default_value = $container.attr('data-default'),
        select_input,
        $list_variants = $list.find('.js-select-variant'),
        current_value = default_value;

    function init () {
        event_handler();
        create_input();
    }

    function event_handler (){
        $btn.click(function () {
            toggele_list();
        });

        $list_variants.each(function () {
            $(this).on('click', function () {
                $list_variants.removeClass('active');
                current_value = $(this).attr('data-value');
                $(this).addClass('active');
                update_select_state();
                toggele_list();
            })
        })
    }

    function toggele_list() {
        $btn.toggleClass('is_show');
        $list.slideToggle(300);
    }

    function create_input () {
        $container.append('<input type="hidden" name="'+input_name+'" value="'+default_value+'" />');
        select_input = $('[name="'+input_name+'"]');
    }

    function update_select_state () {
        select_input.val(current_value);
        $container.find('.js-custom-select--selected').text(current_value)
    }

    init();
};
new custom_select($('.js-select-vid-nagreva'));

basket = {
    state : [],
    init : function(){
        this.event_handler();
        this.load_products();
    },

    event_handler : function(){
        var self = this;
        $(document).on('click', '.js-add-list--some', function(){
            self.add_product($(this));
        });

        $(document).on('click', '.js-delete-list--some', function(){
            self.delete_product($(this));
        });
    },

    load_products : function(){
        var cookieProducts = getCookieValueByArrayFunctions('js-list-products');
        if (cookieProducts.length === 0) {
            this.state = [];
        } else {
            this.state = cookieProducts.split('-');
        }
    },

    add_product : function(btn){
        var id = btn.attr('data-product-id');
        if(id){
            btn.find('.js-btn-added-text').text('Добавлено');
            btn.addClass('product_added');
            var TimerID = setTimeout(function(){
                btn.find('.js-btn-added-text').text('В корзину');
                btn.removeClass('product_added');
                clearInterval(TimerID);
            }, 500);

            this.state.push(id);
            this.update_state();
        }
    },

    delete_product : function(btn){
        var id = btn.attr('data-product-id'),
            row = $('[data-uploaded-row="'+btn.attr('data-delete-row')+'"]'),
            position = this.state.indexOf(id);

        if(position != -1){
            dd(row);
            this.state.splice(position, 1);
            this.update_state();
            row.remove();

            if(this.state.length == 0){
                location.reload();
            }
        }
    },

    update_state : function(){
        var today = new Date(),
            inWeek = new Date();
        inWeek.setDate(today.getDate() + 1800);

        cookieProducts = this.state.join('-');
        setCookie('js-list-products', cookieProducts, inWeek, '/');
        this.update_header_basket();
    },

    update_header_basket : function(){
        if (this.state.length != 0) {
            $('.js-count-basket').text(this.state.length);
        } else {
            $('.js-count-basket').text(0);
        }
    }
};

basket.init();

handler_location = {
    name: "",
    id: '',

    init: function () {
        this.event_handler();
        this.check_select_city();
    },

    check_select_city: function () {
        if (!this.get_location_cookie()) {
            this.city_finding_api(function (name_city) {
                if( name_city in __CITY_LIST__){
                    handler_location.check_correctly_api_city({'name' : name_city, 'id' : __CITY_LIST__[name_city].ID});
                }
            });
        }
    },

    check_correctly_api_city : function (city) {
        $('.js-api-city').text(city.name);

        if($(window).width() < 768) {
            open_magnific_popup('.city-select__auto--media');
        } else {
            $('.js-api-city-container').show(300);
        }


        this.name = city.name;
        this.id = city.id;
    },

    city_finding_api: function (callback) {
        ymaps.ready(function () {
            ymaps.geolocation.get()
                .then(function (result) {
                    var name_city = result.geoObjects.get(0).properties.getAll().metaDataProperty.GeocoderMetaData.Address.Components[4].name;
                    callback(name_city);
                });
        });
    },

    get_location_cookie: function () {
        return getCookieValueByArrayFunctions('CITY_ID') ? true : false;
    },

    event_handler: function () {
        var self = this;

        $(document).on('click', '.js-show-city-list', function () {
            open_magnific_popup('.city-select__popup');
        });

        $(document).on('click', '.js-fast-select-city', function () {
            self.id = $(this).data('city-id');
            self.name = $(this).data('city-name');
            $('.js-current-city').text(self.name);
            self.set_loction();
        });

        $(document).on('click', '.js-find-select-city', function () {
            self.id = $(this).data('city-id');
            self.name = $(this).data('city-name');
            $('.js-city-variants').html('');
            $('.js-search-city-input').val(self.name);
        });

        $(document).on('click', '.js-city-find-set', function () {
           if(!!self.name) {
               self.set_loction();
           } else {
               alert('Данный город не найден в базе')
           }
        });

        //
        // $(document).on('click', '.js-set-city-cookie', function () {
        //     that.set_loction();
        // });
        //
        // $(document).on('click', '.js-set-city--straight', function () {
        //     that.id = $(this).attr('data-id-city');
        //     that.name = $(this).attr('data-name-city');
        //     that.set_loction();
        // });
        //
        $(document).on('input', '.js-search-city-input', function () {
            self.name = '';
            self.id = '';
            if($(this).val()){
                $('.js-city-variants').css('max-height', '150px');
                self.render_find_list($(this).val());
            } else {
                $('.js-city-variants').css('max-height', '0');
                $('.js-city-variants').html('');
            }
        });


        $(document).on('click', '.js-api-city__good', function () {
            self.set_loction();
            $('.js-api-city-container').hide(300);
        });

        $(document).on('click', '.js-api-city__bad', function () {
            self.name = '';
            self.id = '';
            $('.js-api-city-container').hide(300);
            open_magnific_popup('.city-select__popup');
        });
        //
        // $(document).on('click', '.js-close-api-city', function(){
        //     that.id = 129;
        //     that.name = 'Москва';
        //     that.set_loction();
        // });
    },

    render_find_list : function (reg) {
        var city_container = $('.js-city-variants'),
            city = '',
            city_template = '<button  data-name-from-api="#NAME#"' +
            'data-city-name="#NAME#"' +
            'data-city-id="#ID#"' +
            'class="city-select__find-item js-find-select-city" > ' + '#NAME#' + '</button>';

        if(__CITY_LIST__){
            city_container.html('');

            for(name in __CITY_LIST__){

                if(name.toLowerCase().search(reg.toLowerCase())  !== -1){
                    city = city_template.replace(/#NAME#/g, __CITY_LIST__[name].NAME);
                    city = city.replace(/#ID#/g, __CITY_LIST__[name].ID);
                    city_container.append(city);
                }
            }
        }
    },

    set_loction: function () {
        var today = new Date(),
            inWeek = new Date();
        inWeek.setDate(today.getDate() + 9000);
        setCookie('CITY_ID', this.id, inWeek, '/');
        $.magnificPopup.close();

        $('.js-current-city').text(this.name);
        // $('.js-current-city--header').text(this.name);

        $('.js-search-city-input').val('');
        $('.js-city-variants').html('');
        location.reload();

    }
};

handler_location.init();
