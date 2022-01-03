<?
include_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404", "Y");
define("HIDE_SIDEBAR", true);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("Страница не найдена");
?>
    <div class="page page--404">
        <div class="section-message container">
            <div class="alert-message alert-message--404">
                <img src="/img/icons/404.svg" class="alert-message__logo">
                <div class="alert-message__title-404">404</div>
                <div class="title title--medium">
                    Страница не найдена
                </div>
                <div class="alert-message__text">
                    Возможно она удалена, перемещена или никогда не существовала —
                    проверьте правильность написания адреса или перейдите на главную.
                </div>
                <div class="alert-message__actions">
                    <a href="/" class="btn">
                        На главную
                    </a>
                </div>
            </div>
        </div>
    </div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
