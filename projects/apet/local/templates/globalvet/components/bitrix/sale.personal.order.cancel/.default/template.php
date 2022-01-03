<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="lk-section lk-section--cancel">
  <? if (strlen($arResult["ERROR_MESSAGE"]) <= 0): ?>
    <div class="lk-section__header">
      <a href="/personal/" class="lk-back">
        <span class="lk-back__icon">
          <svg class="icon icon-prev ">
            <use xlink:href="#prev"></use>
          </svg>
        </span>
        <span class="lk-back__text">Вернуться к заказу</span>
      </a>
    </div>

    <form action="<?= POST_FORM_ACTION_URI ?>" method="post" class="form form--order-cancel">
      <input type="hidden" name="CANCEL" value="Y">
      <input type="hidden" name="action" value="<?= GetMessage("SALE_CANCEL_ORDER_BTN") ?>">
      <input type="hidden" name="ID" value="<?= $arResult["ID"] ?>">
      <?= bitrix_sessid_post() ?>
      <div class="form__title">
        Отменить заказ № <?= $arResult["ID"] ?>
        от <?= CSaleOrder::GetByID($arResult["ID"])['DATE_INSERT_FORMAT'] ?></div>
      <div class="input-group">
        <textarea name="REASON_CANCELED" placeholder="<?= GetMessage("SALE_CANCEL_ORDER2") ?>" class="input"></textarea>
        <div class="input-group__error"></div>
      </div>
      <div class="form__actions">
        <button
          type="submit"
          class="btn btn--blue btn--medium form__action"
          value="<?= GetMessage("SALE_CANCEL_ORDER_BTN") ?>"
        >Отменить</button>
      </div>
    </form>
  <? else: ?>
    <p><?= ShowError($arResult["ERROR_MESSAGE"]); ?></p>
  <? endif; ?>
</div>
