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
?>

<div class="section-search container">
  <form action="/search/" class="form-search">
    <div class="form-search__icon">
      <svg class="icon icon-search ">
        <use xlink:href="#search"></use>
      </svg>
    </div>
    <input type="text"
           name="q"
           required
           placeholder="Что вы ищите?"
           class="form-search__input"
           value="<?= $arResult["REQUEST"]["QUERY"] ?>">
  </form>
</div>
