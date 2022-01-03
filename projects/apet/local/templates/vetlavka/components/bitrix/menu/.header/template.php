<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if (!empty($arResult)): ?>
  <? if($arParams['IS_MOBILE']):?>
    <div class="header-mobile__links">
      <? foreach ($arResult as $item): ?>
        <a href="<?= $item['LINK'] ?>" class="header-mobile__links-item">
          <?= $item['TEXT'] ?>
        </a>
      <? endforeach; ?>
    </div>
  <? else: ?>
    <div class="header-about__links">
      <? foreach ($arResult as $item): ?>
        <a href="<?= $item['LINK'] ?>" class="header-about__links-item">
          <?= $item['TEXT'] ?>
        </a>
      <? endforeach; ?>
    </div>
  <? endif; ?>
<? endif ?>
