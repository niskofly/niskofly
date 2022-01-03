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

<div class="page page--news">
  <div class="container">

    <div class="page__title title">
      <h1 class="seo-title">
        <?= $arResult["NAME"] ?>
      </h1>
    </div>

    <!-- Основная новость -->
    <div class="page-sides">
      <div class="page-sides__left">
        <? if ($arResult["DETAIL_PICTURE"]["SRC"]): ?>
          <div class="stock__banner">
            <img src="<?= $arResult["DETAIL_PICTURE"]["SRC"] ?>"
                 alt="<?= $arResult["DETAIL_PICTURE"]["ALT"] ?>">
          </div>
        <? endif; ?>

        <? if ($arResult['DETAIL_TEXT']): ?>
          <div class="typography">
            <?= $arResult['DETAIL_TEXT'] ?>
          </div>
        <? endif; ?>
      </div>

      <!-- Дополнительные новость с право -->
      <div class="page-sides__right">
        <div class="news-suggestions">
          <? foreach ($arResult['NEWS_RIGHT'] as $newsRight): ?>
            <div class="news-suggestions__item">
              <div class="news-card">
                <a href="<?= $newsRight['URL_NEWS'] ?>" class="news-card__img">
                  <img src="<?= $newsRight['IMG_NEWS'] ?>" alt="<?= $newsRight['NAME_NEWS'] ?>"/>
                </a>
                <a href="<?= $newsRight['URL_NEWS'] ?>"
                   class="news-card__title"><?= $newsRight['NAME_NEWS'] ?></a>
                <div class="news-card__date"><?= $newsRight['DATE_NEWS'] ?></div>
              </div>
            </div>
          <? endforeach; ?>
        </div>
      </div>

    </div>
  </div>
</div>

