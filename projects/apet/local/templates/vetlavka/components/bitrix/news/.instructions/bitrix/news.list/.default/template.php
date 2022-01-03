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

<div class="instruction-select">
  <div class="letters-select">
    <div class="letters-switch">

      <label class="letters-switch__btn">
        <input
          name="switch-btn-lang"
          class="js-instruction-switch-btn-lang"
          type="radio"
          value="ru">
        <span class="letters-switch__btn-view">Рус</span>
      </label>

      <label class="letters-switch__btn">
          <input
            name="switch-btn-lang"
            class="js-instruction-switch-btn-lang"
            type="radio"
            value="en">
          <span class="letters-switch__btn-view">Анг</span>
        </label>
    </div>

    <div class="letters-list js-switch-letter-container-ru">
      <? foreach ($alphabets['ru'] as $letter): ?>
        <button class="letters-list__item js-instruction-letter"
                data-letter-line="<?= $letter ?>"
          <?= array_key_exists($letter, $arResult['INSTRUCTIONS']['ru']) ? '' : 'disabled' ?>
        >
          <?= $letter ?>
        </button>
      <? endforeach; ?>
    </div>

    <div class="letters-list js-switch-letter-container-en" style="display: none">
      <? foreach ($alphabets['en'] as $letter): ?>
        <button class="letters-list__item js-instruction-letter"
                data-letter-line="<?= $letter ?>"
          <?= array_key_exists($letter, $arResult['INSTRUCTIONS']['en']) ? '' : 'disabled' ?>
        >
          <?= $letter ?>
        </button>
      <? endforeach; ?>
    </div>
  </div>
</div>

<div class="instruction-cards js-switch-product-container-ru">
  <? foreach ($arResult['INSTRUCTIONS']['ru'] as $instructionFirstLetter => $instructionData): ?>
    <? foreach ($instructionData as $instructionId => $instructionContent): ?>
      <a href="<?= $instructionContent['INSTRUCTION_FILE'] ?>"
         class="instruction-card js-instruction-card"
         target="_blank"
         data-instruction-letter="<?= $instructionFirstLetter ?>"
      >
        <div class="instruction-card__img">
          <img src="<?= $instructionContent['IMG'] ?>"
               alt="<?= $instructionContent['NAME'] ?>">
        </div>
        <p class="instruction-card__title"><?= $instructionContent['NAME'] ?></p>
      </a>
    <? endforeach; ?>
  <? endforeach; ?>
</div>

<div class="instruction-cards js-switch-product-container-ru">
  <? foreach ($arResult['INSTRUCTIONS']['en'] as $instructionFirstLetter => $instructionData): ?>
    <? foreach ($instructionData as $instructionId => $instructionContent): ?>
      <a href="<?= $instructionContent['INSTRUCTION_FILE'] ?>"
         class="instruction-card js-instruction-card"
         target="_blank"
         data-instruction-letter="<?= $instructionFirstLetter ?>"
      >
        <div class="instruction-card__img">
          <img src="<?= $instructionContent['IMG'] ?>"
               alt="<?= $instructionContent['NAME'] ?>">
        </div>
        <p class="instruction-card__title"><?= $instructionContent['NAME'] ?></p>
      </a>
    <? endforeach; ?>
  <? endforeach; ?>
</div>
