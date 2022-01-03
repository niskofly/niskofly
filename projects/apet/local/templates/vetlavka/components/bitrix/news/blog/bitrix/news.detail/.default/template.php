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
<!--
todo: сделать отступ в стилях line33
-->

<div class="page page--news-list">
  <div class="container">
    <div class="page__title title">
      <h1 class="seo-title">
        <?= $arResult["NAME"] ? $arResult["NAME"] : 'Название отсутствует' ?>
      </h1>
    </div>
    <div class="page-sides">
      <div class="page-sides__left">
        <div class="stock__banner">
          <img
            src="<?= $arResult["DETAIL_PICTURE"]["SRC"] ? $arResult["DETAIL_PICTURE"]["SRC"] : NO_IMAGE_SRC_VETLAVKA ?>"
            alt="<?= $arResult["DETAIL_PICTURE"]["ALT"] ?>"
            title="<?= $arResult["DETAIL_PICTURE"]["TITLE"] ?>">
        </div>
        <div class="blog-card-footer">
          <div class="blog-card-footer__tag">
            <?= $arResult['DATA_CATEGORY']['NAME_CATEGORY']
              ? $arResult['DATA_CATEGORY']['NAME_CATEGORY']
              : 'Данные отсутсвует' ?>
          </div>
          <div class="blog-card-footer__date">
            <?= $arResult['DATA_CATEGORY']['DATE_CREATE_BLOG']
              ? $arResult['DATA_CATEGORY']['DATE_CREATE_BLOG']
              : 'Данные отсутсвует' ?>
          </div>
        </div>
        <div class="typography">
          <?= $arResult["DETAIL_TEXT"] ? $arResult["DETAIL_TEXT"] : 'Текст отсутсвует' ?>
        </div>
      </div>
      <div class="page-sides__right">
        <div class="blog-suggestions">
          <? foreach ($arResult['BLOG_RIGHT'] as $blogRigth): ?>
            <div class="blog-suggestions__item">
              <div class="blog-card">
                <a href="<?= $blogRigth['URL_BLOG'] ?>" class="blog-card-header">
                  <img src="<?= $blogRigth['IMG_BLOG'] ? $blogRigth['IMG_BLOG'] : NO_IMAGE_SRC_VETLAVKA ?>"
                       alt="<?= $blogRigth['NAME_BLOG'] ?>"
                       class="blog-card-header__img"/>
                </a>
                <? if ($blogRigth['URL_BLOG']): ?>
                  <div class="blog-card-body">
                    <a href="<?= $blogRigth['URL_BLOG'] ?>" class="blog-card-body__title">
                      <?= $blogRigth['NAME_BLOG'] ?>
                    </a>
                    <div class="blog-card-body__description">
                      <?= $blogRigth['TEXT_BLOG'] ?>
                    </div>
                  </div>
                <? endif; ?>
                <div class="blog-card-footer">
                  <div class="blog-card-footer__tag">
                    <?= $blogRigth['NAME_CATEGORY']
                      ? $blogRigth['NAME_CATEGORY']
                      : 'Данные отсутсвует' ?>
                  </div>
                  <div class="blog-card-footer__date"><?= $blogRigth['DATE_BLOG']
                      ? $blogRigth['DATE_BLOG']
                      : 'Дата отсутсвует' ?>
                  </div>
                </div>
              </div>
            </div>
          <? endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>
