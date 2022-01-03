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
<? if (!empty($arResult['RENDER_SECTIONS'])): ?>
    <div class="container">
        <div class="catalog-wrapper">
            <? foreach ($arResult['RENDER_SECTIONS'] as &$arSection) {
                $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
                $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
                $isExistsChildren = isset($arSection['CHILDREN']);
                ?>
                <div class="section-catalog">
                    <a href="<?= $arSection['SECTION_PAGE_URL'] ?>"
                       title="<?= $arSection['NAME'] ?>"
                       class="section-catalog__header">
                        <div class="section-catalog__title">
                            <?= $arSection['NAME'] ?>
                        </div>
                        <? if (isset($arSection['PICTURE']['SRC'])): ?>
                            <img src="<?= $arSection['PICTURE']['SRC'] ?>" alt="<?= $arSection['NAME'] ?>">
                        <? endif ?>
                    </a>
                    <? if ($isExistsChildren): ?>
                        <div class="section-catalog__body js-list-catalog-body">
                            <div class="section-catalog__body-links js-catalog-links">
                                <? foreach ($arSection['CHILDREN'] as $index => $childSection): ?>
                                    <a href="<?= $arSection['SECTION_PAGE_URL'] ?>"
                                       class="section-catalog__body-link"
                                        <? if ($index > 2) { ?> style="display: none" <? } ?>
                                       title="<?= $childSection['NAME'] ?>">
                                        <?= $childSection['NAME'] ?>
                                    </a>
                                <? endforeach; ?>
                            </div>
                            <? if (count($arSection['CHILDREN']) > 3) { ?>
                                <div class="section-catalog__body-btn js-catalog-links-toggle">
                                    Показать все категории
                                </div>
                            <? } ?>
                        </div>
                    <? endif ?>
                </div>
            <? }
            unset($arSection); ?>
        </div>
    </div>
<? endif; ?>
