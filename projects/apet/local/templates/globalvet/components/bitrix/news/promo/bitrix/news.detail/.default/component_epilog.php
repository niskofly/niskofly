<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if ($arResult['SECTIONS_PRODUCTS'] || $arResult['PRODUCTS']):
  global $arPromoProducts;
  $arPromoProducts = [];

  foreach ($arResult['SECTIONS_PRODUCTS'] as $PRODUCT_ID):
    array_push($arPromoProducts, $PRODUCT_ID);
  endforeach;

  foreach ($arResult['PRODUCTS'] as $PRODUCT_ID):
    array_push($arPromoProducts, $PRODUCT_ID);
  endforeach;

  $arPromoProducts = array_unique($arPromoProducts);
endif;
