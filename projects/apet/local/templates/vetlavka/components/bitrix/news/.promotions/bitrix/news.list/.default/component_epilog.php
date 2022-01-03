<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $templateData
 * @var string $templateFolder
 * @var CatalogSectionComponent $component
 */

global $APPLICATION;

$request = \Bitrix\Main\Context::getCurrent()->getRequest();
if ($request->isAjaxRequest() && ($request->get('ACTION') === 'AJAX_LAZY')) {
  $content = ob_get_contents();
  ob_end_clean();

  list(, $itemsContainer) = explode('<!-- items-container -->', $content);
  list(, $paginationContainer) = explode('<!-- pagination-container -->', $content);

  if ($arParams['AJAX_MODE'] === 'Y') {
    $component->prepareLinks($paginationContainer);
  }

  die(json_encode(['content' => $itemsContainer, 'pagination' => $paginationContainer]));
}
