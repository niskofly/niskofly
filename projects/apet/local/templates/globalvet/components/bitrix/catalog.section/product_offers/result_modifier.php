<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();


/**
 * ------------------------
 * БРЕНД ПРОДУКЦИИ - начало
 * ------------------------
 * $arBrand
 * * IBLOCK_ID - id инфоблока с брендами
 * * ITEMS - array id брендов с ключом id-продукт
 * ----------------------------------------------
*/
$arBrand = [];
$brandSection = ($arResult["ID"]) ? array("SECTION_ID" => $arResult["ID"]) : [];
$productBrandsFilter = Array("IBLOCK_ID" => $arResult["IBLOCK_ID"], "ACTIVE" => "Y", $brandSection);
$queryProductBrands = CIBlockElement::GetList(Array(), $productBrandsFilter, false, false, Array("*", "PROPERTY_*"));
while($ob = $queryProductBrands->GetNextElement()):
  $arBrand["IBLOCK_ID"] = $ob->GetProperties()["BRAND"]["LINK_IBLOCK_ID"];
  $arBrand["ITEMS"][$ob->GetFields()["ID"]] = [
    "ID" => $ob->GetProperties()["BRAND"]["VALUE"]
  ];
endwhile;
unset($queryProductBrands);

/**
 * $arBrandName - array описания бренда
*/
$arBrandName = [];
$arFilter = Array("IBLOCK_ID" => $arBrand["IBLOCK_ID"], "ACTIVE" => "Y");
$queryBrandInfo = CIBlockElement::GetList(Array(), $arFilter, false, false, Array("ID", "NAME"));
while($ob = $queryBrandInfo->GetNextElement()):
  $arBrandName[] = $ob->GetFields();
endwhile;
unset($queryBrandInfo);

/**
 * Добавляются название в $arBrand["ITEMS"]
 */
array_map(function ($field) use (&$arBrand) {
  foreach ($arBrand["ITEMS"] as &$brand):
    if ($brand["ID"] == $field["ID"]):
      $brand["NAME"] = $field["NAME"];
    endif;
  endforeach;
}, $arBrandName);
unset($arBrandName);

/**
 * Добавляются название в $arResult["ITEMS"]
 */
foreach ($arResult["ITEMS"] as &$arItem):
  $arItem["BRAND_NAME"] = array_filter($arBrand["ITEMS"], function ($k) use($arItem) {
    return $k == $arItem["ID"];
  }, ARRAY_FILTER_USE_KEY )[$arItem["ID"]]["NAME"];
endforeach;
unset($arBrand);
/**
 * -----------------------
 * БРЕНД ПРОДУКЦИИ - Конец
 * -----------------------
*/


/**
 * Добавление open graph изображения
 */
if ($arParams['NOT_SET_OPENGRAF_IMAGE'] != 'Y') {
    $arResult["OPENGRAF_IMAGE"] = $arResult["PICTURE"]["SRC"];
    $cp = $this->__component;
    if (is_object($cp))
        $cp->SetResultCacheKeys(array('OPENGRAF_IMAGE'));
}
