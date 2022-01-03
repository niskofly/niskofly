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

/* Отображение списка категории с на странице /catalog/ (Верхний блок)*/
?>

<? if ($arResult['SECTIONS']): ?>
  <div class="catalog-links">
    <? foreach ($arResult['SECTIONS'] as $section): ?>
      <div class="catalog-link">
        <a href="<?= $section['URL']; ?>" class="link-filled link-filled--icon">
          <div class="link-filled__icon">
            <svg class="icon icon-first-aid ">
              <use xlink:href="<?= $section['SVG']; ?>"></use>
            </svg>
          </div>
          <div class="link-filled__text"><?= $section['NAME']; ?></div>
        </a>
      </div>
    <? endforeach; ?>
  </div>
<? endif; ?>



