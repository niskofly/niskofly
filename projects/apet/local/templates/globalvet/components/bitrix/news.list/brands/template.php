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

<div class="section-sort container">
  <div class="sort-alphabet sort-alphabet--double">
    <?
    $arAlphabets = [
      "RU" => ['А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я'],
      "EN" => ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'],
    ];

    foreach ($arAlphabets as $lang => $arAlphabet):
      $btnClass = ($lang != array_key_first($arAlphabets)) ? '' : ' active';
      ?>
      <div class="sort-alphabet__row" data-lang="<?= mb_strtolower($lang) ?>">
        <div class="sort-alphabet__langs">
          <button
            type="button"
            class="btn btn--small sort-alphabet__lang sort-alphabet__lang--ice<?= $btnClass; ?> js-alphabet-btn"
            data-lang="<?= mb_strtolower($lang); ?>"><?= ($lang == 'RU') ? 'Рус' : $lang; ?></button>
        </div>

        <div class="sort-alphabet__letters">
          <?
          foreach ($arAlphabet as $letter):
            if (array_filter($arResult["LETTERS"][$lang], function ($el) use ($letter) {
              return $el === $letter;
            })):
              ?>
              <label class="sort-alphabet__letter">
                <input
                  type="checkbox"
                  name="letters"
                  class="js-alphabet-letter"
                  value="<?= $letter; ?>"><span><?= $letter; ?></span>
              </label>
            <?
            else:
              ?>
              <div class="sort-alphabet__letter sort-alphabet__letter--disabled">
                <span><?= $letter; ?></span>
              </div>
            <?
            endif;
          endforeach; ?>
        </div>
      </div>
    <? endforeach; ?>
  </div>
</div>

<?
foreach ($arResult["BRANDS"] as $lang => $arLetters):
  $hideClass = ($lang != array_key_first($arResult["BRANDS"])) ? ' hide' : '';
  ?>
  <div
    class="section-brands container js-alphabet-list<?= $hideClass; ?>"
    data-lang="<?= mb_strtolower($lang) ?>">
    <? foreach ($arLetters as $letter => $arBrands): ?>
      <div
        class="section-brand js-alphabet-card"
        data-letter="<?= $letter ?>"
        data-lang="<?= mb_strtolower($lang) ?>">
        <div class="section-brand__header">
          <div class="title title--medium"><?= $letter; ?></div>
        </div>
        <div class="card-brands">
          <? foreach ($arBrands["ITEMS"] as $arBrand): ?>
            <div class="card-brand">
              <img src="<?= $arBrand["IMAGE"]; ?>" alt="<?= $arBrand["NAME"]; ?>" class="card-brand__image">
              <span class="card-brand__title"><?= $arBrand["NAME"]; ?></span>
            </div>
          <? endforeach; ?>
        </div>
      </div>
    <? endforeach; ?>
  </div>
<? endforeach; ?>
