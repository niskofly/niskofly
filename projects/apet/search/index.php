<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Результаты поиска");
$APPLICATION->SetPageProperty("title", "Результаты поиска");
?>
<div class="page page--search">
  <div class="container">

    <!-- Add breadcrumb -->
    <? $APPLICATION->IncludeComponent(
      "bitrix:breadcrumb",
      ".default",
      []
    );
    ?>

    <?
    $APPLICATION->IncludeComponent(
      "bitrix:search.page",
      ".default",
      [
        "RESTART" => "Y",
        "CHECK_DATES" => "Y",
        "USE_TITLE_RANK" => "Y",
        "DEFAULT_SORT" => "rank",
        "arrFILTER_main" => "",
        "SHOW_WHERE" => "N",
        "SHOW_WHEN" => "N",
        "PAGE_RESULT_COUNT" => "999999999",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_SHADOW" => "Y",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "N",
        "AJAX_OPTION_HISTORY" => "N",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "PAGER_TITLE" => "Результаты поиска",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => "test",
        "USE_SUGGEST" => "N",
        "SHOW_ITEM_TAGS" => "N",
        "SHOW_ITEM_DATE_CHANGE" => "N",
        "SHOW_ORDER_BY" => "N",
        "SHOW_TAGS_CLOUD" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "COMPONENT_TEMPLATE" => ".default",
        "NO_WORD_LOGIC" => "Y",
        "FILTER_NAME" => "",
        "USE_LANGUAGE_GUESS" => "Y",
        "SHOW_RATING" => "",
        "RATING_TYPE" => "",
        "PATH_TO_USER_PROFILE" => "",
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO",
        "arrFILTER" => [
          0 => "iblock_1c_catalog",
        ],
        "arrFILTER_iblock_1c_catalog" => [
          0 => CATALOG_ID,
        ],
      ],
      false
    );

    /* Include settings sorting catalog */
    include($_SERVER["DOCUMENT_ROOT"] . "/catalog/parts/sorting.php");

    $arParams = [
      "ELEMENT_SORT_FIELD" => $actualSorting['ELEMENT_SORT_FIELD'],
      "ELEMENT_SORT_ORDER" => $actualSorting['ELEMENT_SORT_ORDER'],
      "ELEMENT_SORT_FIELD2" => "id",
      "ELEMENT_SORT_ORDER2" => "desc",
      "ACTION_VARIABLE" => "action",
      "PRODUCT_ID_VARIABLE" => "id",
      "SECTION_ID_VARIABLE" => "SECTION_ID",
      "PRODUCT_QUANTITY_VARIABLE" => "quantity",
      "PRODUCT_PROPS_VARIABLE" => "prop",
      "PAGE_ELEMENT_COUNT" => "99999",
      "LINE_ELEMENT_COUNT" => "3",
      "LIST_PRODUCT_ROW_VARIANTS" => [],
      "PRICE_CODE" => ['Битрикс VetLavka.ru'],
      "FILTER_PRICE_CODE" => ['Битрикс VetLavka.ru'],
      "LIST_OFFERS_FIELD_CODE" => ['NAME'],
      "DETAIL_URL" => "/catalog/#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
      "CURRENCY_ID" => "RUB",
      "HIDE_NOT_AVAILABLE" => "Y",
      "HIDE_NOT_AVAILABLE_OFFERS" => "Y",
      "LIST_PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
      "ADD_TO_BASKET_ACTION" => "ADD",
      "IBLOCK_TYPE" => 'catalog',
      "SEF_MODE" => 'N',
      "IBLOCK_ID" => CATALOG_ID,
      "FILTER_NAME" => 'arrFilter'
    ];

    /**
     * Настройки для работы смарт фильтра
     */
    if (empty($arResult["VARIABLES"]["SMART_FILTER_PATH"])) {
      $re = '/^\/.*\/filter\/(.*)\/apply\//';
      $str = Bitrix\Main\Context::getCurrent()->getRequest()->getRequestedPage();
      preg_match($re, $str, $matches);
      $arResult["VARIABLES"]["SMART_FILTER_PATH"] = $matches[1];
    }

    global $searchId;
    global $PRE_FILTER;
    global $arrFilter;

    $PRE_FILTER['=ID'] = $searchId
    ?>

    <div class="catalog-sides js-catalog-sidebar">
      <?
      $APPLICATION->IncludeComponent(
        "bitrix:catalog.smart.filter",
        ".default",
        [
          "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
          "IBLOCK_ID" => $arParams["IBLOCK_ID"],
          "SECTION_ID" => 0,
          "PREFILTER_NAME" => 'PRE_FILTER',
          "FILTER_NAME" => $arParams["FILTER_NAME"],
          "PRICE_CODE" => $arParams["PRICE_CODE_FILTER"],
          "CACHE_TYPE" => $arParams["CACHE_TYPE"],
          "CACHE_TIME" => $arParams["CACHE_TIME"],
          "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
          "SAVE_IN_SESSION" => "N",
          "FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
          "XML_EXPORT" => "N",
          "SECTION_TITLE" => "NAME",
          "SECTION_DESCRIPTION" => "DESCRIPTION",
          'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
          "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
          'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
          'CURRENCY_ID' => $arParams['CURRENCY_ID'],
          "SEF_MODE" => "Y",
          "SEF_RULE" => "/search/filter/#SMART_FILTER_PATH#/apply/",
          "SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
          "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
          "INSTANT_RELOAD" => $arParams["INSTANT_RELOAD"],
        ],
        false,
        ['HIDE_ICONS' => 'Y']
      );
      ?>

      <div class="catalog-content">
        <? $APPLICATION->IncludeComponent(
          "bitrix:news",
          ".brands_slider",
          [
            "COMPONENT_TEMPLATE" => ".brands_slider",
            "IBLOCK_TYPE" => "catalog",
            "IBLOCK_ID" => BRANDS_IBLOCK_ID,
            "NEWS_COUNT" => "19",
            "SET_TITLE" => "N",
            "PAGER_TITLE" => "N",
            "USE_SEARCH" => "N",
            "USE_RSS" => "N",
            "USE_RATING" => "N",
            "USE_CATEGORIES" => "N",
            "USE_REVIEW" => "N",
            "USE_FILTER" => "N",
            "SORT_BY1" => "ACTIVE_FROM",
            "SORT_ORDER1" => "DESC",
            "SORT_BY2" => "SORT",
            "SORT_ORDER2" => "ASC",
            "CHECK_DATES" => "Y",
            "SEF_MODE" => "N",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "36000000",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "SET_LAST_MODIFIED" => "N",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "ADD_SECTIONS_CHAIN" => "N",
            "ADD_ELEMENT_CHAIN" => "N",
            "USE_PERMISSIONS" => "N",
            "STRICT_SECTION_CHECK" => "N",
            "DISPLAY_DATE" => "Y",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "Y",
            "USE_SHARE" => "N",
            "PREVIEW_TRUNCATE_LEN" => "",
            "LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
            "LIST_FIELD_CODE" => [
              0 => "",
              1 => "",
            ],
            "LIST_PROPERTY_CODE" => [
              0 => "",
              1 => "",
            ],
            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
            "DISPLAY_NAME" => "Y",
            "META_KEYWORDS" => "-",
            "META_DESCRIPTION" => "-",
            "BROWSER_TITLE" => "-",
            "DETAIL_SET_CANONICAL_URL" => "N",
            "DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
            "DETAIL_FIELD_CODE" => [
              0 => "",
              1 => "",
            ],
            "DETAIL_PROPERTY_CODE" => [
              0 => "",
              1 => "",
            ],
            "DETAIL_DISPLAY_TOP_PAGER" => "N",
            "DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
            "DETAIL_PAGER_TITLE" => "Страница",
            "DETAIL_PAGER_TEMPLATE" => "",
            "DETAIL_PAGER_SHOW_ALL" => "Y",
            "PAGER_TEMPLATE" => ".default",
            "DISPLAY_TOP_PAGER" => "N",
            "DISPLAY_BOTTOM_PAGER" => "Y",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "PAGER_BASE_LINK_ENABLE" => "N",
            "SET_STATUS_404" => "N",
            "SHOW_404" => "N",
            "MESSAGE_404" => "",
            "VARIABLE_ALIASES" => [
              "SECTION_ID" => "SECTION_ID",
              "ELEMENT_ID" => "ELEMENT_ID",
            ]
          ],
          false
        ); ?>

        <?
        $alphabets = getAlphabets();
        global $latterFilter;
        ?>
        <div class="letters-select">
          <div class="letters-switch">
            <!-- todo: Пересмотреть нейминг -->
            <label>
              <input name="filter-btn-switch"
                     class="letters-switch__btn js-filter-btn-switch"
                     type="radio"
                     value="ru">
              <span>Рус</span>
            </label>

            <label>
              <input name="filter-btn-switch"
                     class="letters-switch__btn js-filter-btn-switch"
                     type="radio"
                     value="en">
              <span>Анг</span>
            </label>
          </div>
          <div class="letters-list js-filter-letter-container-ru">
            <? foreach ($alphabets['ru'] as $letter): ?>
              <button class="letters-list__item  js-filter-letter"
                      data-filter-letter="<?= $letter ?>"
                <?= array_key_exists($letter, $latterFilter) ? '' : 'disabled' ?>
              >
                <?= $letter ?>
              </button>
            <? endforeach; ?>
          </div>
          <!-- todo: Добавить display: none в sass -->
          <div class="letters-list js-filter-letter-container-en" style="display: none">
            <? foreach ($alphabets['en'] as $letter): ?>
              <button class="letters-list__item js-filter-letter"
                      data-filter-letter="<?= $letter ?>"
                <?= array_key_exists($letter, $latterFilter) ? '' : 'disabled' ?>
              >
                <?= $letter ?>
              </button>
            <? endforeach; ?>
          </div>
        </div>

        <div class="catalog-options">
          <div class="catalog-tabs js-category-tabs">
            <button class="catalog-tabs__item js-category-tab" data-category="Новинки">Новинки</button>
            <button class="catalog-tabs__item js-category-tab" data-category="Хит продаж">Хит продаж
            </button>
            <button class="catalog-tabs__item js-category-tab" data-category="Советуем">Советуем
            </button>
            <button class="catalog-tabs__item js-category-tab-stock">Акции</button>
          </div>

          <div class="catalog-sorting">
            <div class="dropdown">
              <div class="dropdown__description">Сортировать по:</div>
              <?
              global $sortSetting;

              if (isset($sortSetting) && !empty($sortSetting)):
                ?>
                <div class="custom-select js-custom-select">
                  <button class="custom-select__header js-custom-select-toggle">
                    <span class="custom-select__selected js-custom-select-render">Популярности</span>
                    <span class="custom-select__arrow">
                                        <svg class="icon icon-hesrts-active ">
                                          <use xlink:href="#hesrts-active"></use>
                                        </svg></span>
                  </button>
                  <div class="custom-select__body js-custom-select-list">
                    <? foreach ($sortSetting as $key => $option) : ?>
                      <label class="custom-select__option">
                        <input name="test"
                               type="checkbox"
                               class="js-catalog-sorting"
                               value="<?= $key ?>"
                          <? if ($_COOKIE["SORT_SETTING"] == $key) { ?> checked <? } ?>>
                        <span class="custom-select__label"><?= $option['NAME'] ?></span>
                      </label>
                    <? endforeach; ?>
                  </div>
                </div>
              <? endif; ?>
            </div>
          </div>
        </div>

        <?
        global $arrFilter;

        $APPLICATION->IncludeComponent(
          "bitrix:catalog.section",
          ".default",
          [
            "HIDE_SECTION_DESCRIPTION" => "Y",
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
            "FILTER_NAME" => $arParams["FILTER_NAME"],
            "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
            "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
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

  <!-- Подключение блока bullets из parts -->
  <? include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/all-pages/footer-bullets.php") ?>

</div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
