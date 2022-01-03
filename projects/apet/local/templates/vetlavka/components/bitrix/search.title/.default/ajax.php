<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(!empty($arResult["CATEGORIES"]) && $arResult['CATEGORIES_ITEMS_EXISTS']):?>
	<div class="search-result">
		<? foreach($arResult["CATEGORIES"] as $category_id => $arCategory): ?>
			<? foreach($arCategory["ITEMS"] as $i => $arItem): ?>
      <a href="<?=$arItem["URL"]?>" class="search-result__item"><?=$arItem["NAME"]?></a>
      <? endforeach; ?>
    <? endforeach; ?>
    <div class="title-search-fader"></div>
  </div>
<?endif;
?>
