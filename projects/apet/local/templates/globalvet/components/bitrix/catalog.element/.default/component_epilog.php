<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

/**
 * Добавление товара в список просмотренных
 */
use \Bitrix\Catalog\CatalogViewedProductTable as CatalogViewedProductTable;
CatalogViewedProductTable::refresh($arResult['ID'], CSaleBasket::GetBasketUserID());

/**
 * @var array $templateData
 * @var array $arParams
 * @var string $templateFolder
 * @global CMain $APPLICATION
 */

global $APPLICATION;

if ($arResult['OPENGRAF_IMAGE']) {
    $fileName = end(explode('/', $arResult['OPENGRAF_IMAGE']));
    $extension = (new SplFileInfo($fileName))->getExtension();
    $extension = $extension ? "image/{$extension}" : 'image/png';

    $APPLICATION->SetPageProperty("og:image", $arResult['OPENGRAF_IMAGE']);
    $APPLICATION->SetPageProperty("og:image:type", $extension);
}