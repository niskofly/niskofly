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

<div class="tab tab--show">
    <div class="blog-list">
        <? foreach ($arResult['BLOG_DATA'] as $blogData): ?>

            <?
            $this->AddEditAction($blogData['ID'], $blogData['EDIT_LINK'], CIBlock::GetArrayByID($blogData["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($blogData['ID'], $blogData['DELETE_LINK'], CIBlock::GetArrayByID($blogData["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>

            <div class="blog-card">
                <a href="<?= $blogData['BLOG_URL'] ?>" class="blog-card-header">
                    <img src="<?= $blogData['URL_IMG'] ? $blogData['URL_IMG'] : NO_IMAGE_SRC_VETLAVKA ?>" alt="<?= $blogData['TITLE'] ?>"
                         class="blog-card-header__img"/>
                </a>
                <div class="blog-card-body">
                    <a href="<?= $blogData['BLOG_URL'] ?>" class="blog-card-body__title"><?= $blogData['TITLE'] ?></a>
                    <div class="blog-card-body__description"><?= $blogData['DESCRIPTION'] ?></div>
                </div>
                <div class="blog-card-footer">
                    <div class="blog-card-footer__tag"><?= $blogData['NAME_CATEGORY'] ?></div>
                    <div class="blog-card-footer__date"><?= $blogData['DATE'] ?></div>
                </div>
            </div>

        <? endforeach; ?>
    </div>
</div>

