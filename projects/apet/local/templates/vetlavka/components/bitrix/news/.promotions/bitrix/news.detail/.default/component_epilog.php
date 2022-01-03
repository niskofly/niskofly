<?php

/** @var array $arResult */

/**
 * Собираем массив ID товаров для выборки акционных товаров
 */
if ($arResult['BINDING_CATEGORY'] || $arResult['BIND_PRODUCTS']) {
  global $SHARE_PRODUCTS;
  $SHARE_PRODUCTS = [];

  foreach ($arResult['BINDING_CATEGORY'] as $section_id) {
    $items = CIBlockElement::GetList(
      ['SORT' => 'ASC'],
      ["IBLOCK_ID" => CATALOG_ID, "SECTION_CODE" => $section_id, 'ACTIVE' => 'Y'],
      false,
      false,
      ['ID']
    );

    while ($arItem = $items->GetNext())
      $SHARE_PRODUCTS[] = $arItem['ID'];
  }

  foreach ($arResult['BIND_PRODUCTS'] as $product_id)
    $SHARE_PRODUCTS[] = $product_id;
}

if ($arResult['OPENGRAF_IMAGE']) {
  $fileName = end(explode('/', $arResult['OPENGRAF_IMAGE']));
  $extension = (new SplFileInfo($fileName))->getExtension();
  $extension = $extension ? "image/{$extension}" : 'image/png';

  $APPLICATION->SetPageProperty("og:image", $arResult['OPENGRAF_IMAGE']);
  $APPLICATION->SetPageProperty("og:image:type", $extension);
}

