<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $templateData
 * @var string $templateFolder
 * @var CatalogSectionComponent $component
 */

global $APPLICATION;

$request = \Bitrix\Main\Context::getCurrent()->getRequest();
if ($request->isAjaxRequest() && ($request->get('IS_AJAX_RELOAD') === 'Y')) {
    $content = ob_get_contents();
    ob_end_clean();
    list(, $itemsContainer) = explode('<!-- items-container -->', $content);
    list(, $totalContainer) = explode('<!-- total-container -->', $content);

    $component::sendJsonAnswer([
        'products' => $itemsContainer,
        'total' => $totalContainer,
        'countBasketItems' => $arResult['BASKET_ITEMS_COUNT'],
    ]);
}
