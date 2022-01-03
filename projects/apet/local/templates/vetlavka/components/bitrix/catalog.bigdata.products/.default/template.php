<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */
/** @global CMain $APPLICATION */

$frame = $this->createFrame()->begin("");
$injectId = $arParams['UNIQ_COMPONENT_ID'];


if (isset($arResult['REQUEST_ITEMS'])) {
  CJSCore::Init(array('ajax'));

  $signer = new \Bitrix\Main\Security\Sign\Signer;
  $signedParameters = $signer->sign(
    base64_encode(serialize($arResult['_ORIGINAL_PARAMS'])),
    'bx.bd.products.recommendation'
  );
  $signedTemplate = $signer->sign($arResult['RCM_TEMPLATE'], 'bx.bd.products.recommendation');
  ?>
    <div id="<?= $injectId ?>">
        <div class="product-offer">
            <div class="product-offer__title title title--second">Может понравиться</div>
            <div class="product-offer__slider js-offer-slider">
                <div class="container">
                    <div class="loader-section">
                        <div class="loader">
                            <div class="circle"></div>
                            <div class="circle"></div>
                            <div class="circle"></div>
                        </div>
                        <div class="loader-section__text">
                            Ищем товары
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        BX.ready(function () {
            bx_rcm_get_from_cloud(
                '<?=CUtil::JSEscape($injectId)?>',
              <?=CUtil::PhpToJSObject($arResult['RCM_PARAMS'])?>,
                {
                    'parameters': '<?=CUtil::JSEscape($signedParameters)?>',
                    'template': '<?=CUtil::JSEscape($signedTemplate)?>',
                    'site_id': '<?=CUtil::JSEscape(SITE_ID)?>',
                    'rcm': 'yes'
                }
            );
        });
    </script>
  <?
  $frame->end();
  return;
}

// regular template then
// if customized template, for better js performance don't forget to frame content with <span id="{$injectId}_items">...</span>

if (!empty($arResult['ITEMS'])) {
  ?>
    <div id="<?= $injectId ?>_items">
        <div class="product-offer">
            <div class="product-offer__title title title--second">Может понравиться</div>
            <div class="product-offer__slider js-offer-slider">
              <?
              $filterIdsBD = [];

              foreach ($arResult['ITEMS'] as $item) {
                $filterIdsBD[] = $item['ID'];
              }

              global $arrFilter;
              $arrFilter['=ID'] = $filterIdsBD;

              $intSectionID = $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                ".product_offers",
                [
                  "NO_INIT_SLIDER" => "Y",
                  "SET_TITLE" => "N",
                  "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                  "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                  "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
                  "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
                  "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                  "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                  "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                  "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                  "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                  "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                  "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                  "FILTER_NAME" => "arrFilter",
                  "PAGE_ELEMENT_COUNT" => 10,
                  "LINE_ELEMENT_COUNT" => 10,
                  "PRICE_CODE" => $arParams["PRICE_CODE"],

                  "PRICE_VAT_INCLUDE" => "Y",
                  "USE_PRODUCT_QUANTITY" => "Y",
                  "PRODUCT_PROPERTIES" => [],

                  "OFFERS_CART_PROPERTIES" => [],
                  "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
                  "OFFERS_PROPERTY_CODE" => [],

                  "SECTION_ID" => "",
                  "SHOW_ALL_WO_SECTION" => "Y",
                  "SECTION_CODE" => "",
                  "SECTION_URL" => $arParams["SECTION_URL"],
                  "DETAIL_URL" => $arParams["DETAIL_URL"],

                  "USE_MAIN_ELEMENT_SECTION" => "Y",
                  'CONVERT_CURRENCY' => "Y",
                  'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                  'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                  'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],

                  'PRODUCT_DISPLAY_MODE' => "Y",
                  'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
                  'PRODUCT_ROW_VARIANTS' => $arParams['LIST_PRODUCT_ROW_VARIANTS'],
                  'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],


                  "ADD_SECTIONS_CHAIN" => $arParams['ADD_SECTIONS_CHAIN'],
                  'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
                ],
                false
              );
              ?>
            </div>
        </div>
    </div>
    <script>
        document.dispatchEvent(new CustomEvent('initAjaxSliders'))
        document.dispatchEvent(new CustomEvent('reInitProductCounters'))
        window.initSliders()
    </script>
  <?
}

$frame->end();