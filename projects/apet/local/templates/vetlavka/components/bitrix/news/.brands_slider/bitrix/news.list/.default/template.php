<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<div class="manufacturers-slider">
  <div class="swiper-button-prev-unique">
    <svg class="icon icon-left ">
      <use xlink:href="#left"></use>
    </svg>
  </div>
  <div class="swiper-container js-manufacturers-slider">
    <div class="swiper-wrapper">
      <? foreach ($arResult["ITEMS"] as $arItem): ?>
        <div class="swiper-slide js-syncing-brand" data-brand-name="<?= $arItem["NAME"] ?>">
          <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?: '/img/no-image.png' ?>"
               alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>">
        </div>
      <? endforeach; ?>
    </div>
  </div>
  <div class="swiper-button-next-unique">
    <svg class="icon icon-right ">
      <use xlink:href="#right"></use>
    </svg>
  </div>
</div>
