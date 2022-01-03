<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 */

$this->setFrameMode(true);
?>
<? if (!empty($arResult['ITEMS']) && !empty($arResult['ITEM_ROWS'])) : ?>
    <div data-slider-id="default" class="container swiper-container slider-products js-slider">
        <div class="slider-products__header">
            <div class="slider-products__header-info">
                <div class="title">
                    Вы недавно смотрели
                </div>
            </div>
        </div>
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

                foreach ($rowItems as $item):
                    ?>
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
                            ),
                            $component,
                            array('HIDE_ICONS' => 'Y')
                        ); ?>
                    </div>
                <?
                endforeach;
            }
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
    </div>
    <?
    unset($generalParams, $rowItems);
endif; ?>
