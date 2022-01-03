<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Авторизация");
$APPLICATION->SetPageProperty("title", "Авторизация");

global $USER;
if ($USER->IsAuthorized())
    LocalRedirect('/personal/');
?>

    <div class="page page--login">
        <div class="container">
            <div class="auth-wrapper">
                <div class="auth">
                    <div class="auth-header">
                        <div class="auth-header__title">Авторизация</div>
                        <div class="auth-header__description">Укажите последний код из sms</div>
                    </div>
                    <form class="auth-body js-auth-profile-user" action="/api/user/auth.php">
                        <?= bitrix_sessid_post() ?>
                        <input type="hidden" name="ACTION" value="USER_AUTH">
                        <div class="auth-body__input">
                            <div data-input-group="phone" class="input-group">
                                <input name="phone"
                                       type="tel"
                                       placeholder="Ваш телефон"
                                       aria-label=""
                                       class="input input--white js-input-phone">
                                <div class="input-group__error"></div>
                            </div>
                        </div>
                        <div class="auth-body__input">
                            <div data-input-group="password" class="input-group">
                                <input name="code"
                                       type="password"
                                       placeholder="Код"
                                       aria-label=""
                                       class="input input--white">
                                <div class="input-group__error"></div>
                            </div>
                        </div>
                        <div class="auth-body__row">
                            <div class="auth-body__checkbox">
                                <label class="checkbox checkbox--outline">
                                    <input class="js-checkbox-auth" name="remember" type="checkbox" value="true" checked>
                                    <span class="checkbox__indicator">
                                      <svg class="icon icon-check ">
                                        <use xlink:href="#check"></use>
                                      </svg>
                                    </span>
                                    <span class="checkbox__description">Запомнить меня</span>
                                </label>
                            </div>
                            <div class="auth-body__link">
                                <a href="/user/recovery/" class="link link--bold">Забыли пароль?</a>
                            </div>
                        </div>
                        <div class="auth-body__row">
                            <button type="submit" class="auth-body__submit btn">Войти</button>
                        </div>
                    </form>

                    <!-- info: Временно скрыто
                    <div class="auth-footer">
                        <div class="auth-footer__text">Или войдите через</div>
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
                    -->
                </div>
                <div class="auth-registration">
                  <div class="">Если у вас нет учетной записи зарегестрирутесь</div>
                  <a href="/user/registration" class="auth-registration__btn btn">Регистрация</a>
                </div>

            </div>
        </div>

        <!-- Подключение блока bullets из parts -->
        <? include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/all-pages/footer-bullets.php") ?>

    </div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
