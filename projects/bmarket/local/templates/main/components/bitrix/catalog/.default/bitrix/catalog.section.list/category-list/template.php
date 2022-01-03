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
<? if (!empty($arResult['SECTIONS'])): ?>
    <div class="catalog-child-categories">
        <? foreach ($arResult['SECTIONS'] as $section):?>
            <a href="<?= $section['SECTION_PAGE_URL'] ?>"
            title="<?= $section['NAME'] ?>"
            class="catalog-child-category">
                <?= $section['NAME'] ?>
            </a>
        <? endforeach ?>
    </div>
<? endif; ?>
