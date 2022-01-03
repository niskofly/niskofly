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

<? if ($arResult["ITEMS"]): ?>
  <div class="stock-cards">
    <? foreach ($arResult["ITEMS"] as $item): ?>
      <div class="stock-card__wrapper">
        <div class="stock-card">
          <a href="<?= $item['DETAIL_PAGE_URL'] ?>"
             class="stock-card__img"
             title="<?= $item['NAME'] ?>">
            <img src="<?= $item["PREVIEW_PICTURE"]["SRC"] ?>" alt="<?= $item['NAME'] ?>"/>
          </a>
          <div class="stock-card__time">
            c <?= $item['DISPLAY_ACTIVE_FROM'] ?>
            до <?= FormatDate(
              'd F Y',
              MakeTimeStamp($item['DATE_ACTIVE_TO'], CSite::GetDateFormat())
            ); ?>
          </div>
          <a href="<?= $item['DETAIL_PAGE_URL'] ?>" class="stock-card__title"><?= $item["NAME"] ?></a>
        </div>
      </div>
    <? endforeach; ?>
  </div>
<? else: ?>
  <p>Нету акций</p>
<? endif; ?>
