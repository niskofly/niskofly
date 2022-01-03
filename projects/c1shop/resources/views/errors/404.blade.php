<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" media="all" href="/css/app.css">
</head>
<body>
<div id="SVG_container"></div>
<div class="page-404">
    <div class="wrap-404-content">
        <div class="page-404__icon">
            @php(icon(19))
        </div>
        <div class="page-404__text">
            ОШИБКА
            <div class="page-404__text-color">
                404
            </div>
        </div>
        <div class="page-404__descriprion">
            Такой страницы не существует.
        </div>
        <a href="/" class="page-404__link" title="Вернуться на главную">Вернуться на главную</a>
    </div>
</div>
<script src="/js/libs/jquery/dist/jquery.min.js"></script>
<script src="/js/all.js"></script>
{{--<script src="/js/main--update.js"></script>--}}
</body>
</html>
