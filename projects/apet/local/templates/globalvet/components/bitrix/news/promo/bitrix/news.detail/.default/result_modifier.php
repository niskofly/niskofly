<?

$SECTION_PRODUCTS = [];
if ($arResult['PROPERTIES']['SECTIONS']['VALUE']):
  $items = CIBlockElement::GetList(
    false,
    array("IBLOCK_ID" => CATALOG_ID, "SECTION_ID" => $arResult['PROPERTIES']['SECTIONS']['VALUE'], "INCLUDE_SUBSECTIONS" => "Y"),
    false,
    false,
    array("*")
  );
  while ($arItem = $items->GetNext()):
    array_push($SECTION_PRODUCTS, $arItem["ID"]);
  endwhile;
endif;


$cp = $this->__component;
if (is_object($cp)):
  $cp->arResult['SECTIONS_PRODUCTS'] = $SECTION_PRODUCTS;
  $cp->arResult['PRODUCTS'] = $arResult['PROPERTIES']['PRODUCTS']['VALUE'];
  $cp->SetResultCacheKeys(array('SECTIONS_PRODUCTS', 'PRODUCTS'));
endif;

unset($SECTION_PRODUCTS);
