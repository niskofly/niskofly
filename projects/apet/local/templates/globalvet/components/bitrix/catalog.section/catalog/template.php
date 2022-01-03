<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 */
$this->setFrameMode(true);
$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = array('CONFIRM' => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));

$generalParams = array(
    'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
    'PROPERTY_CODE' => $arParams['PROPERTY_CODE'],
    'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
    'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
    'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
    'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
    'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
    'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
    'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
    'ADD_PROPERTIES_TO_BASKET' => $arParams['ADD_PROPERTIES_TO_BASKET'],
    'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
    'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
    'PRODUCT_BLOCKS_ORDER' => $arParams['PRODUCT_BLOCKS_ORDER'],
    'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
    'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
    'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY'],
);
?>
<div class="js-lazy-load-catalog">
    <div class="js-lazy-load-content card-products<?= ($GLOBALS["CLASS_FAVORITE_LIST_PRODUCT"]) ? $GLOBALS["CLASS_FAVORITE_LIST_PRODUCT"] : ' catalog__main-products';?>">
        <!-- items-container -->
        <?
        if (!empty($arResult['ITEMS']) && !empty($arResult['ITEM_ROWS'])) {

            $areaIds = array();
            foreach ($arResult['ITEMS'] as $item) {
                $uniqueId = $item['ID'] . '_' . md5($this->randString() . $component->getAction());
                $areaIds[$item['ID']] = $this->GetEditAreaId($uniqueId);
                $this->AddEditAction($uniqueId, $item['EDIT_LINK'], $elementEdit);
                $this->AddDeleteAction($uniqueId, $item['DELETE_LINK'], $elementDelete, $elementDeleteParams);
            }
            foreach ($arResult['ITEM_ROWS'] as $serialNumber => $rowData) {
                $rowItems = array_splice($arResult['ITEMS'], 0, $rowData['COUNT']);

                /**
                 * Вычисление шаблона карточки товара

                $cardTemplate = ($serialNumber === 0 || $serialNumber === 11) ? 'big' : 'default';
                if ($arParams['ONLY_SMALL_CARD'] == 'Y')
                    $cardTemplate = 'default';
                 */
                $cardTemplate = 'default';

                foreach ($rowItems as $item):
                    $APPLICATION->IncludeComponent(
                        'bitrix:catalog.item',
                        '',
                        array(
                            'RESULT' => array(
                                'ITEM' => $item,
                                'AREA_ID' => $areaIds[$item['ID']],
                                'TYPE' => $cardTemplate,
                                'BIG_LABEL' => 'N',
                                'BIG_DISCOUNT_PERCENT' => 'N',
                                'BIG_BUTTONS' => 'N',
                                'SCALABLE' => 'N'
                            ),
                            'PARAMS' => $generalParams
                                + array('SKU_PROPS' => $arResult['SKU_PROPS'][$item['IBLOCK_ID']])
                        ),
                        $component,
                        array('HIDE_ICONS' => 'Y')
                    );
                endforeach;
            }
            unset($generalParams, $rowItems);

        } else { ?>
            <p>Товары отсутствуют</p>
            <?
        }
        ?>
        <!-- items-container -->
    </div>
    <? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
        <div class="js-lazy-load-more-pagination">
            <!-- pagination-container -->
            <?= $arResult["NAV_STRING"] ?>
            <!-- pagination-container -->
        </div>
    <? endif; ?>
</div>

<? if (is_object($arResult["NAV_RESULT"]) && is_subclass_of($arResult["NAV_RESULT"], "CAllDBResult")):
    global $COUNT_CATALOG_ITEMS;
    $COUNT_CATALOG_ITEMS = $arResult["NAV_RESULT"]->NavRecordCount;
    ?>
    <script>
        window.COUNT_CATALOG_ITEMS = <?=$arResult["NAV_RESULT"]->NavRecordCount?>
    </script>
<? endif; ?>

