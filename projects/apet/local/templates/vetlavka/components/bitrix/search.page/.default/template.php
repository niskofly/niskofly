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

<div class="page__title title">
  <h1 class="seo-title">
    <? $APPLICATION->ShowTitle(false); ?>
  </h1>
</div>

<div class="search-results__wrapper">
  <div class="search">
    <div class="search__icon">
      <svg class="icon icon-search ">
        <use xlink:href="#search"></use>
      </svg>
    </div>
    <form action="/search/" class="form-search">
      <input name="q"
             type="text"
             required
             placeholder="Поиск по каталогу"
             value="<?= $arResult["REQUEST"]["QUERY"] ?>"
             class="input input--white search__input">
    </form>
  </div>
</div>
