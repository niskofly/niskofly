$(function(){
    var $feedbackButton = $("#feedback_button");
    var feedbackUrl = $feedbackButton.data("url");

    $feedbackButton.fancybox({
        'href': feedbackUrl,
        'type': 'ajax',
        'minWidth': 444
    });

    $('.fancybox').fancybox();
    $('#add-rating').raty({
        score: 5,
        targetScore: '#review-rating',
        starOff: '/images/raty/star-off.png',
        starOn: '/images/raty/star-on.png'
    });
    $(".review-rating").each(function(){
        var $this = $(this),
            value = parseInt($this.data("rating"));
        $this.raty({
            score: value,
            readOnly: true,
            targetScore: '#review-rating',
            starOff: '/images/raty/star-off.png',
            starOn: '/images/raty/star-on.png'
        });
    });

    var maskList = $.masksSort($.masksLoad("/js/phone-codes.json"), ['#'], /[0-9]|#/, "mask");
    var maskOpts = {
        inputmask: {
            definitions: {
                '#': {
                    validator: "[0-9]",
                    cardinality: 1
                }
            },
            //clearIncomplete: true,
            showMaskOnHover: false,
            autoUnmask: true
        },
        match: /[0-9]/,
        replace: '#',
        list: maskList,
        listKey: "mask",
        onMaskChange: function(maskObj, completed) {
            if (completed) {
                var hint = maskObj.name_ru;
                if (maskObj.desc_ru && maskObj.desc_ru != "") {
                    hint += " (" + maskObj.desc_ru + ")";
                }

            }
            $(this).attr("placeholder", $(this).inputmask("getemptymask"));
        }
    };

    $("#register-form-phone").val(971);
    $("#register-form-phone").change(function() {
        $("#register-form-phone").inputmasks(maskOpts);
    });

    $("#register-form-phone").change();


    $("#register-form-phone-main").change(function() {
        $("#register-form-phone-main").inputmasks(maskOpts);
    });



    $("#feedback-phone").val(971);
    $("#feedback-phone").change(function() {
        $("#feedback-phone").inputmasks(maskOpts);
    });
    $("#feedback-phone").change();


    $("#w0 #feedback-phone").val(971);
    $("#w0 #feedback-phone").change(function() {
        $("#w0 #feedback-phone").inputmasks(maskOpts);
    });
    $("#w0 #feedback-phone").change();


    $("#w2 #feedback-phone").val(971);
    $("#w2 #feedback-phone").change(function() {
        $("#w2 #feedback-phone").inputmasks(maskOpts);
    });
    $("#w2 #feedback-phone").change();

    $("#w3 #feedback-phone").val(971);
    $("#w3 #feedback-phone").change(function() {
        $("#w3 #feedback-phone").inputmasks(maskOpts);
    });
    $("#w3 #feedback-phone").change();

    $("#w4 #feedback-phone").val(971);
    $("#w4 #feedback-phone").change(function() {
        $("#w4 #feedback-phone").inputmasks(maskOpts);
    });
    $("#w4 #feedback-phone").change();
});
