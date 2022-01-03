<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Регистрация");
$APPLICATION->SetPageProperty("title", "Регистрация");

global $USER;
if ($USER->IsAuthorized())
    LocalRedirect('/personal/');
?>

    <div class="page page--login">
        <div class="container">
            <div class="auth-wrapper">
                <div class="auth">

                    <div class="auth-header">
                        <div class="auth-header__title">Регистрация</div>
                        <div class="auth-header__description js-auth-title"></div>
                    </div>

                    <!-- Форма отправки телефона -->
                    <form class="auth-body js-auth-form-phone" action="/api/user/auth.php">
                        <?= bitrix_sessid_post() ?>
                        <input type="hidden" name="ACTION" value="USER_CREATE">
                        <div class="auth-body__input">
                            <div data-input-group="phone" class="input-group">
                                <input aria-label=""
                                       name="phone"
                                       type="tel"
                                       placeholder="Телефон"
                                       class="input input--white js-auth-form-phone-input js-input-phone">
                                <div class="input-group__error"></div>
                            </div>
                        </div>

                        <div class="auth-body__row js-recovery-password-in-regist" style="display: none">
                            <div class="auth-body__link">
                                <a href="/user/recovery/" class="link link--bold">Забыли пароль?</a>
                            </div>
                        </div>

                        <div class="auth-body__row">
                            <button class="auth-body__submit btn">Зарегистрироваться</button>
                        </div>

                        <div class="auth-body__row" style="font-size: 11px">
                          Нажимая кнопку зарегистрироваться Вы соглашаетесь с пользовательским соглашением
                        </div>
                    </form>

                    <!-- Форма ввода кода из сообщения и полная регистрация -->
                    <form class="auth-body auth-body--code js-auth-form-code" action="/api/user/auth.php">
                        <?= bitrix_sessid_post() ?>
                        <input type="hidden" name="phone" value="">
                        <input type="hidden" name="ACTION" value="USER_AUTH">
                        <div class="auth-body__input">
                            <div data-input-group="code" class="input-group">
                                <input name="code"
                                       type="tel"
                                       placeholder="Введите код"
                                       aria-label=""
                                       class="input input--white js-auth-form-code-input">
                                <div class="input-group__error"></div>
                            </div>
                        </div>

                        <div class="auth-body__row">
                            <div class="auth-header__link js-reg-form-resend-code">Отправить код еще раз</div>
                            <button type="submit" class="auth-body__submit btn">Продолжить</button>
                        </div>
                    </form>
                    <!-- info: Временно скрыто
                    <div class="auth-footer">
                        <div class="auth-footer__text">Или Зарегистрируйтесь через</div>
                        <div class="auth-footer__socials">
                            <a href="#" class="auth-footer__social auth-footer__social--google">
                                <svg class="icon icon-google ">
                                    <use xlink:href="#google"></use>
                                </svg>
                            </a>
                            <a href="#" class="auth-footer__social auth-footer__social--vk">
                                <svg class="icon icon-vk ">
                                    <use xlink:href="#vk"></use>
                                </svg>
                            </a>
                            <a href="#" class="auth-footer__social auth-footer__social--fb">
                                <svg class="icon icon-fb ">
                                    <use xlink:href="#fb"></use>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                -->

            </div>
            <a href="/user/authorization/" class="auth__action link link--bold">Вход</a>
        </div>

        <!-- Подключение блока bullets из parts -->
        <? include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/all-pages/footer-bullets.php") ?>

    </div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
