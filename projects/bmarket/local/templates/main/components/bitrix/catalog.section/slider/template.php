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
<? if (!empty($arResult['ITEMS']) && !empty($arResult['ITEM_ROWS'])) : ?>
    <? if ($arParams['NO_INIT_SLIDER'] != 'Y') { ?>
        <div data-slider-id="default" class="container swiper-container slider-products js-slider">
        <? if ($arParams['TITLE']): ?>
            <div class="slider-products__header">
                <div class="slider-products__header-info">
                    <? if ($arParams['TITLE']) : ?>
                        <div class="title"><?= $arParams['TITLE'] ?></div>
                    <? endif; ?>
                </div>
            </div>
        <? endif ?>
    <? } ?>

    <div class="swiper-wrapper">
        <?
        $areaIds = [];
        $countItems = count($arResult['ITEMS']);

        foreach ($arResult['ITEMS'] as $item) {
            $uniqueId = $item['ID'] . '_' . md5($this->randString() . $component->getAction());
            $areaIds[$item['ID']] = $this->GetEditAreaId($uniqueId);
            $this->AddEditAction($uniqueId, $item['EDIT_LINK'], $elementEdit);
            $this->AddDeleteAction($uniqueId, $item['DELETE_LINK'], $elementDelete, $elementDeleteParams);
        }

        foreach ($arResult['ITEM_ROWS'] as $rowData) {
            $rowItems = array_splice($arResult['ITEMS'], 0, $rowData['COUNT']);
            foreach ($rowItems as $item): ?>
                <div class="swiper-slide slider-products__slide">
                    <? $APPLICATION->IncludeComponent(
                        'bitrix:catalog.item',
                        '',
                        array(
                            'RESULT' => array(
                                'ITEM' => $item,
                                'AREA_ID' => $areaIds[$item['ID']],
                                'TYPE' => '.default',
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
                    ); ?>
                </div>
            <? endforeach;
        }
        unset($generalParams, $rowItems);
        ?>
    </div>

    <div class="slider-controls" <? echo $countItems < 4 ? 'style="display: none"' : '' ?>>
        <button type="button" class="slider-control slider-control--prev js-slider-prev">
            <svg class="icon icon-arrow-l ">
                <use xlink:href="#arrow-l"></use>
            </svg>
        </button>
        <button type="button" class="slider-control slider-control--next js-slider-next">
            <svg class="icon icon-arrow-r ">
                <use xlink:href="#arrow-r"></use>
            </svg>
        </button>
    </div>
    <? if ($arParams['NO_INIT_SLIDER'] != 'Y') { ?>
        </div>
    <? } ?>
<? endif; ?>

