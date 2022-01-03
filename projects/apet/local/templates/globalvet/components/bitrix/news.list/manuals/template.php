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
#dd($arResult["MANUALS"]);
?>


<div class="section-sort container">
  <div class="sort-alphabet">
    <div class="sort-alphabet__langs">
      <button
        type="button"
        class="btn btn--small sort-alphabet__lang js-alphabet-btn active" data-lang="ru">Рус
      </button>
      <button
        type="button"
        class="btn btn--small sort-alphabet__lang js-alphabet-btn" data-lang="en">En
      </button>
    </div>
    <?
    $arAlphabets = [
      "RU" => ['А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я'],
      "EN" => ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'],
    ];

    foreach ($arAlphabets as $lang => $arAlphabet):
      $hideClass = ($lang != array_key_first($arAlphabets)) ? ' hide' : '';
      ?>
      <div class="sort-alphabet__letters js-alphabet-list<?= $hideClass ?>" data-lang="<?= mb_strtolower($lang) ?>">
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
        endforeach;
        ?>
      </div>
    <? endforeach; ?>
  </div>
</div>

<div class="section-instructions container">
  <?
  foreach ($arResult["MANUALS"] as $lang => $arManuals):
    $hideClass = ($lang != array_key_first($arResult["MANUALS"])) ? ' hide' : '';
    ?>
    <div
      class="card-instructions js-alphabet-list<?= $hideClass; ?>"
      data-lang="<?= mb_strtolower($lang) ?>">
      <? foreach ($arManuals as $arManual): ?>
        <a
          href="<?= $arManual["FILE"] ?>"
          class="card-instruction js-alphabet-card"
          data-letter="<?= $arManual["LETTER"] ?>"
          data-lang="<?= mb_strtolower($lang) ?>">
          <span class="card-instruction__preview">
            <img
              src="<?= $arManual["IMAGE"] ?>"
              alt="<?= $arManual["NAME"] ?>">
          </span>
          <span class="card-instruction__detail">
            <span class="title title--small card-instruction__title"><?= $arManual["NAME"]; ?></span>
          </span>
        </a>
      <? endforeach; ?>
    </div>
  <? endforeach; ?>
</div>
