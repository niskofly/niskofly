<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
global $USER;
if ($USER->IsAuthorized())
    LocalRedirect('/personal/');

$APPLICATION->SetTitle("Авторизация");
$APPLICATION->SetPageProperty("title", "Авторизация");
?>
<div class="page page--auth">
    <div class="section-auth container">
        <form action="/api/personal/auth.php" class="form form--auth js-send-auth-code-form">
            <?= bitrix_sessid_post() ?>
            <input type="hidden"
                   name="AUTH_ACTION"
                   value="SEND_USER_CODE">
            <div class="form__header">
                <div class="title title--small">Войти или создать профиль</div>
            </div>
            <div class="input-groups">
                <div class="input-group js-group-label">
                    <div class="input-group__wrapper">
                        <label class="input-group__label">Контактный телефон*</label>
                        <input name="PHONE"
                               type="tel"
                               class="input js-group-label__input js-input-phone js-auth-main-phone">
                    </div>
                    <div class="input-group__error"></div>
                </div>
                <button type="submit" class="btn form__submit">Получить код</button>
            </div>
            <div class="form__term">
                Нажимая кнопку, вы соглашаетесь на
                <a target="_blank" href="<?= POLICY_LINK ?>">обработку данных</a>
            </div>
        </form>

        <form action="/api/personal/auth.php"
              style="display: none"
              class="form form--auth js-auth-form">
            <?= bitrix_sessid_post() ?>
            <input type="hidden"
                   name="AUTH_ACTION"
                   value="AUTH_BY_CODE">
            <input type="hidden"
                   name="PHONE"
                   class="js-auth-copy-phone">
            <div class="form__header">
                <div class="title title--small">Введите код</div>
                <div class="form__header-text">
                    <p>Код выслан на номер</p>
                    <p class="form__header-phone js-auth-render-phone"></p>
                </div>
            </div>
            <div class="input-groups">
                <div class="input-group form__input-code">
                    <input name="CODE"
                           type="text"
                           class="input js-auth-form-code-input">
                    <div class="input-group__error"></div>
                </div>
                <div class="form__timer js-auth-resend-timer-row">
                    Повторная отправка через 00:<span class="js-auth-resend-timer">60</span>
                </div>
                <button type="button" disabled class="btn form__submit js-auth-resend-code-button">
                    Получить повторно
                </button>
            </div>
        </form>

        <form action="/api/personal/auth.php"
              style="display: none"
              class="form form--auth js-auth-resend-code-form">
            <?= bitrix_sessid_post() ?>
            <input type="hidden"
                   name="AUTH_ACTION"
                   value="RESEND_USER_CODE">
            <input type="hidden"
                   name="PHONE"
                   class="js-auth-copy-phone">
        </form>
    </div>
</div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
