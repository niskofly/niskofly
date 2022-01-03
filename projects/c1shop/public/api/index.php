<?php header('Content-type: text/html; charset="utf-8"'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Добавление контакта</title>
</head>
<body>
<form name="sendForm" id="sendForm" action="handler.php" method="post">
    <input type="hidden" name="theme" value="Сообщение с сайта.">
    <input type="hidden" name="reply" value="Ваше сообщение успешно отправлено.">

    <input type="hidden" name="tags" value="Получить прайс">

    <input type="hidden" name="utm_source" value="1">
    <input type="hidden" name="utm_campaign" value="2">
    <input type="hidden" name="utm_content" value="3">
    <input type="hidden" name="utm_term" value="4">


    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon">Имя*</span>
            <input type="text" name="name" placeholder="" autocomplete="on" class="form-control" required="required" />
        </div>
    </div>

    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon">Телефон*</span>
            <input type="tel" name="tel" placeholder="" autocomplete="on" class="form-control" required="required" />
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon" style="vertical-align: top;">Сообщение</span>
            <textarea name="message" placeholder="" class="form-control" required="required" ></textarea>
        </div>
    </div>
    <div class="form-group text-right">* обязательные для заполнения поля</div>
    <div class="form-group text-right">
        <button type="submit" class="btn btn-main"><span>Получить прайс-лист</span></button>
    </div>
</form>
</body>
</html>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>


<script>
    $(document).ready(function() {

        function $_GET(key) {
            var s = window.location.search;
            s = s.match(new RegExp(key + '=([^&=]+)'));
            return s ? s[1] : false;
        }

        function getCookie(name) {
            var matches = document.cookie.match(new RegExp(
                "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));
            return matches ? decodeURIComponent(matches[1]) : undefined;
        }

        //alert( $_GET('utm_source') );
        if($_GET('utm_source') && $_GET('utm_campaign') && $_GET('utm_content') && $_GET('utm_term')){
            console.log('запись в куки при переходе с поиска');
            $("[name='utm_source']").val($_GET('utm_source'));
            $("[name='utm_campaign']").val($_GET('utm_campaign'));
            $("[name='utm_content']").val($_GET('utm_content'));
            $("[name='utm_term']").val(decodeURI($_GET('utm_term')));

            document.cookie = "utm_source="+$_GET('utm_source');
            document.cookie = "utm_campaign="+$_GET('utm_campaign');
            document.cookie = "utm_content="+$_GET('utm_content');
            document.cookie = "utm_term="+decodeURI ($_GET('utm_term'));
        }else {
            if(getCookie('utm_source') != undefined && getCookie('utm_campaign') != undefined && getCookie('utm_content') != undefined && getCookie('utm_term') != undefined){
                console.log('берем из куки значения');
                $("[name='utm_source']").val(getCookie('utm_source'));
                $("[name='utm_campaign']").val(getCookie('utm_campaign'));
                $("[name='utm_content']").val(getCookie('utm_content'));
                $("[name='utm_term']").val(getCookie('utm_term'));
            }else {
                console.log('нет в куки значений');
                $("[name='utm_source']").val('');
                $("[name='utm_campaign']").val('');
                $("[name='utm_content']").val('');
                $("[name='utm_term']").val('');
            }
        }


    });
</script>