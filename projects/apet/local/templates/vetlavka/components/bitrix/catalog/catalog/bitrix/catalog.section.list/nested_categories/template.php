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

/* Отображение списка категории с под категориями на странице /catalog/ (Нижний блок)*/
?>

<? if ($arResult['GATEGORY_SECTIONS']): ?>
  <div class="catalog-categories">
    <? foreach ($arResult['GATEGORY_SECTIONS'] as $categoryElement): ?>
      <div class="catalog-category">
        <div class="catalog-category__text">
          <div class="catalog-category__title title title--second"><?= $categoryElement['NAME'] ?></div>
          <a href="<?= $categoryElement['URL'] ?>" class="catalog-category__link link link--bold">Перейти в раздел</a>
        </div>

        <div class="catalog-category-links">
          <? foreach ($categoryElement['ITEMS'] as $elementItem): ?>
            <a href="<?= $elementItem['URL']; ?>" class="catalog-category-links__item">
              <?= $elementItem['NAME']; ?>
            </a>
          <? endforeach; ?>
        </div>

        <? if ($categoryElement['IMG']): ?>
          <div class="catalog-category__img">
            <img src="<?= $categoryElement['IMG'] ?>" alt="<?= $categoryElement['NAME'] ?>">
          </div>
        <? endif; ?>
      </div>
    <? endforeach; ?>
  </div>
<? endif; ?>



