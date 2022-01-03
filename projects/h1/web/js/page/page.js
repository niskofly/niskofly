$(document).ready(function () {
    $('.callback_button').click(function () {
        $('body').css('overflow', 'hidden');
    });
    $('.close_form, .close_form2').click(function () {
        $('body').css('overflow', 'auto');
        $('.close_form2').css('display', 'none');
    });

    $('.fees_row').click(function () {
        $('body').css('overflow', 'hidden');
    });
    $('.close_form, .close_form2').click(function () {
        $('body').css('overflow', 'auto');
        $('.close_form2').css('display', 'none');
    });
});