<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if (!empty($arResult)): ?>
  <ul class="header-nav-info">
    <? foreach ($arResult as $item): ?>
      <li class="header-nav-info__item">
        <a href="<?= $item['LINK'] ?>" class="header-nav-info__link">
          <?= $item['TEXT'] ?>
        </a>
      </li>
    <? endforeach; ?>
  </ul>
<? endif ?>
