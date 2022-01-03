<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Восстановление");
$APPLICATION->SetPageProperty("title", "Восстановление");

global $USER;
if ($USER->IsAuthorized())
    LocalRedirect('/personal/');
?>

    <div class="page page--login">
        <div class="container">
            <div class="auth-wrapper js-recovery-form-input">
                <div class="auth">
                    <div class="auth-header">
                        <div class="auth-header__title">Восстановление</div>
                        <div class="auth-header__description">Если вы забыли пароль, введите свой номер телефона. Новый
                            пароль придет смс сообщением.
                        </div>
                    </div>
                    <form class="auth-body js-recovery-profile-user" action="/api/user/auth.php">
                        <?= bitrix_sessid_post() ?>
                        <input type="hidden" name="ACTION" value="USER_RECOVERY">
                        <div class="auth-body__input">
                            <div data-input-group="phone" class="input-group">
                                <input aria-label=""
                                       name="phone"
                                       type="tel"
                                       placeholder="Tелефон"
                                       value=""
                                       class="input input--white js-input-phone">
                                <div class="input-group__error"></div>
                            </div>
                        </div>
                        <div class="auth-body__row">
                            <button type="submit" class="auth-body__submit btn">Восстановить</button>
                        </div>
                    </form>
                </div>
                <a href="/user/authorization" class="auth__action link link--bold">Войти</a>
            </div>

            <div class="auth-wrapper js-form-recovery-info">
                <!-- todo: adding display: none in sass -->
                <div class="auth" style="display: none">
                    <form action="/api/user/auth.php">
                        <?= bitrix_sessid_post() ?>
                        <input type="hidden" name="ACTION" value="USER_RECOVERY">
                        <input aria-label="" type="hidden" name="phone" value="">
                    </form>
                    <div class="auth-header">
                        <div class="auth-header__title">Восстановление пароля</div>
                        <div class="auth-header__description">Мы отправили новый пароль на ваш номер телефона</div>
                        <a class="auth-header__link js-resend-recovery-code">Отправить еще раз</a>
                        <div class="auth-header__login"><a href="/user/authorization/" class="btn">Войти</a></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Подключение блока bullets из parts -->
        <? include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/all-pages/footer-bullets.php") ?>

    </div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>