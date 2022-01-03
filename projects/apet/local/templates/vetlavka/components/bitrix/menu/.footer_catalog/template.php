<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="footer-links__column js-footer-column">
  <? foreach ($arResult as $itemId => $itemData): ?>
    <div class="footer-links__column-title js-footer-column-title"><?= $itemData['TEXT'] ?></div>
    <div class="footer-links__column-items js-footer-column-items">
      <? foreach ($itemData['ADDITIONAL_LINKS'] as $urlId => $urlData): ?>
        <a href="<?= $urlData['LINK'] ?>" class="footer-links__column-item"><?= $urlData['TEXT'] ?></a>
      <? endforeach; ?>
    </div>
  <? endforeach; ?>
</div>
