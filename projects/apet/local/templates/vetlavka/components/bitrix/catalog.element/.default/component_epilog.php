<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use \Bitrix\Catalog\CatalogViewedProductTable as CatalogViewedProductTable;

global $APPLICATION;

/**
 * @var array $arResult
 * @var array $templateData
 * @var array $arParams
 * @var string $templateFolder
 * @global CMain $APPLICATION
 */

/**
 * Добавление товара в список просмотренных
 */

CatalogViewedProductTable::refresh($arResult['ID'], CSaleBasket::GetBasketUserID());

if ($arResult['OPENGRAF_IMAGE']) {
  $fileName = end(explode('/', $arResult['OPENGRAF_IMAGE']));
  $extension = (new SplFileInfo($fileName))->getExtension();
  $extension = $extension ? "image/{$extension}" : 'image/png';

  $APPLICATION->SetPageProperty("og:image", $arResult['OPENGRAF_IMAGE']);
  $APPLICATION->SetPageProperty("og:image:type", $extension);
}
