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

/* Отображение списка категории с на странице /catalog/element (Верхний блок)*/
?>

<? if ($arResult['SECTIONS']): ?>
  <div class="catalog-content-links-wrapper">
    <div class="catalog-content-links">
      <? foreach ($arResult['SECTIONS'] as $arSection): ?>
        <div class="catalog-content-links__item">
          <a href="<?= $arSection['SECTION_PAGE_URL']; ?>" class="link-filled">
            <div class="link-filled__text"><?= $arSection['NAME']; ?></div>
          </a>
        </div>
      <? endforeach; ?>
    </div>
  </div>
<? endif; ?>
