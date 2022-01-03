<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="lk-content__form-wrapper">
  <? if (strlen($arResult["ERROR_MESSAGE"]) <= 0): ?>
    <form action="<?= POST_FORM_ACTION_URI ?>" method="post" class="lk-content__form">
      <input type="hidden" name="CANCEL" value="Y">
      <input type="hidden" name="action" value="<?= GetMessage("SALE_CANCEL_ORDER_BTN") ?>">
      <input type="hidden" name="ID" value="<?= $arResult["ID"] ?>">
      <?= bitrix_sessid_post() ?>
      <div class="lk-content__title lk-content__form-title">
        Отменить заказ № <?= $arResult["ID"] ?>
        от <?= CSaleOrder::GetByID($arResult["ID"])['DATE_INSERT_FORMAT'] ?>
      </div>
      <div class="lk-content__form-textarea">
        <div data-input-group="textarea" class="input-group">
        <textarea name="REASON_CANCELED" placeholder="<?= GetMessage("SALE_CANCEL_ORDER2") ?>"
                  class="input input--white textarea"></textarea>
          <div class="input-group__error"></div>
        </div>
      </div>
      <div class="lk-content__form-submit">
        <button type="submit" class="btn" value="<?= GetMessage("SALE_CANCEL_ORDER_BTN") ?>">Отменить</button>
      </div>
    </form>
  <? else: ?>
    <p><?= ShowError($arResult["ERROR_MESSAGE"]); ?></p>
  <? endif; ?>
</div>

