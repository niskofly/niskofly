<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

/* info: Временно скрыто */
LocalRedirect('/personal/');

$APPLICATION->SetTitle("Мои подписки");
$APPLICATION->SetPageProperty("title", "Мои подписки");

global $USER;
if (!$USER->IsAuthorized())
  LocalRedirect('/user/authorization/');
?>

<div class="page page--lk-orders">
  <div class="container">

    <!-- Add breadcrumb -->
    <? $APPLICATION->IncludeComponent(
      "bitrix:breadcrumb",
      ".default",
      array()
    ); ?>

    <div class="page__title title">
      <h1 class="seo-title">
        <? $APPLICATION->ShowTitle(false); ?>
      </h1>
    </div>

    <div class="lk-sides">

      <!-- include left side bar -->
      <? include($_SERVER["DOCUMENT_ROOT"] . "/personal/parts/lk-links.php"); ?>

      <div class="lk-content">
        <div class="lk-subscription__wrapper">
          <div class="lk-subscription">

            <div class="lk-subscription__title lk-content__title">подписка на рассылку</div>

            <div class="lk-subscription__subtitle js-form-subtitle"></div>

            <form action="/api/user/controller-subscribe.php"
                  class="lk-subscription__form form-default js-form-subscribe">
              <?= bitrix_sessid_post() ?>
              <input type="hidden"
                     name="ACTION"
                     value="CREATE_MAILING">
              <input type="hidden"
                     name="USER_RESPONSE"
                     value="Подписка на рассылку выполнена">

              <div data-input-group="name" class="input-group">
                <input name="EMAIL" type="text" placeholder="Email"
                       class="input input--white">
                <div class="input-group__error"></div>
              </div>
              <button type="submit" class="btn">Подписаться</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Подключение блока bullets из parts -->
  <? include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/all-pages/footer-bullets.php") ?>

</div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
