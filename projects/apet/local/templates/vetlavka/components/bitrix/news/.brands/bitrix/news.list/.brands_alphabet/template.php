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

$alphabets = getAlphabets();
?>

<div class="letters-selects">
  <div class="letters-select letters-selects__row">
    <div class="letters-switch">
      <label class="letters-switch__btn js-switch-btn-lang letters-switch__btn--active" data-switch-btn-lang="ru">
        <input type="hidden">
        <span class="letters-switch__btn-view">Рус</span>
      </label>
    </div>
    <!-- active class: letters-list__item--active -->
    <div class="letters-list">
      <? foreach ($alphabets['ru'] as $letter): ?>
        <button class="letters-list__item js-switch-letter"
                data-letter-line="<?= $letter ?>"
          <?= array_key_exists($letter, $arResult['BRANDS']['ru']) ? '' : 'disabled' ?>
        >
          <?= $letter ?>
        </button>
      <? endforeach; ?>
    </div>
  </div>

  <div class="letters-select letters-selects__row">
    <div class="letters-switch">
      <label class="letters-switch__btn js-switch-btn-lang letters-switch__btn--active" data-switch-btn-lang="en">
        <input type="hidden">
        <span class="letters-switch__btn-view">Анг</span>
      </label>
    </div>

    <div class="letters-list js-switch-container-en">
      <? foreach ($alphabets['en'] as $letter): ?>
        <button class="letters-list__item js-switch-letter"
                data-letter-line="<?= $letter ?>"
          <?= array_key_exists($letter, $arResult['BRANDS']['en']) ? '' : 'disabled' ?>
        >
          <?= $letter ?>
        </button>
      <? endforeach; ?>
    </div>
  </div>
</div>

<div class="brands">
  <div class="brands-row" data-lang-container="ru">
    <? foreach ($arResult['BRANDS']['ru'] as $symbol => $brands): ?>
      <div class="brands__letter"
           data-letter="<?= $symbol ?>">
        <?= $symbol ?>
      </div>
      <div class="brands__list">
        <? foreach ($brands as $brand): ?>
          <div class="popular-brand">
            <div class="popular-brand__logo">
              <img src="<?= $brand["SRC"] ?>" alt="">
            </div>
            <div class="popular-brand__name">
              <a href="<?= $brand["DETAIL_PAGE_URL"] ?>">
                <?= $brand["NAME"] ?>
              </a>
            </div>
          </div>
        <? endforeach; ?>
      </div>
    <? endforeach; ?>
  </div>

  <div class="brands-row" data-lang-container="en">
    <? foreach ($arResult['BRANDS']['en'] as $symbol => $brands): ?>
      <div class="brands__letter"
           data-letter="<?= $symbol ?>">
        <?= $symbol ?>
      </div>
      <div class="brands__list">
        <? foreach ($brands as $brand): ?>
          <div class="popular-brand">
            <div class="popular-brand__logo">
              <img src="<?= $brand["SRC"] ?>" alt="">
            </div>
            <div class="popular-brand__name">
              <a href="<?= $brand["DETAIL_PAGE_URL"] ?>">
                <?= $brand["NAME"] ?>
              </a>
            </div>
          </div>
        <? endforeach; ?>
      </div>
    <? endforeach; ?>
  </div>
</div>
