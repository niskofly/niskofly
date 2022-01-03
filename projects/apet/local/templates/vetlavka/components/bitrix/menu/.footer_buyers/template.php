<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="footer-links__column js-footer-column">
  <div class="footer-links__column-title js-footer-column-title">Покупателям</div>
  <div class="footer-links__column-items js-footer-column-items">
    <? foreach ($arResult as $item): ?>
      <a href="<?= $item['LINK'] ?>" class="footer-links__column-item"><?= $item['TEXT'] ?></a>
    <? endforeach; ?>
  </div>
</div>
