<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Интерактивная карта с пунктами выдачи товаров купленных в зоомагазине — «Ветлавка».");
$APPLICATION->SetPageProperty("keywords", "Пункты выдачи товаров,");
$APPLICATION->SetTitle("Пункты выдачи товаров");
$APPLICATION->SetPageProperty("title", "Пункты выдачи товаров зоомагазина — «Ветлавка»");
?>

<div class="page page--text-page">
  <div class="container">
    <!-- Add breadcrumb -->
    <? $APPLICATION->IncludeComponent(
      "bitrix:breadcrumb",
      ".default",
      array()
    );
    ?>

    <div class="page__title title">
      <h1 class="seo-title">
        <? $APPLICATION->ShowTitle(false) ?>
      </h1>
    </div>

    <?
    /*$points = [];
    $pointsData = CIBlockElement::GetList(
      ['SORT' => 'ASC'],
      ['IBLOCK_ID' => POINTS_OF_DELIVERY_IBLOCK_ID, 'ACTIVE' => 'Y'],
      false,
      false,
      ['ID', 'NAME', 'PREVIEW_TEXT', 'PROPERTY_COORDINATES', 'PROPERTY_POINT_OF_DELIVERY', 'PROPERTY_STORAGE_PERIOD_ORDER', 'PROPERTY_POINT_COLOR']
    );
    while ($element = $pointsData->GetNext())
      $points[] = [
        'ID' => $element['ID'],
        'NAME' => $element['NAME'],
        'PREVIEW_TEXT' => $element['~PREVIEW_TEXT'],
        'COORDINATES' => $element['PROPERTY_COORDINATES_VALUE'],
        'POINT_OF_DELIVERY' => $element['PROPERTY_POINT_OF_DELIVERY_VALUE'],
        'STORAGE_PERIOD_ORDER' => $element['PROPERTY_STORAGE_PERIOD_ORDER_VALUE'],
        'POINT_COLOR' => $element['PROPERTY_POINT_COLOR_VALUE'],
      ];*/
    ?>

    <?
    $pointStores = [];
    $pointMap = [];

    $stores = \Bitrix\Catalog\StoreTable::getList(['filter' => ['ACTIVE' => 'Y']]);
    while ($store = $stores->fetch()) {
      /* info: Для отображения списка */
      $pointStores[] = [
        'ID' => $store['ID'],
        'NAME' => $store['TITLE'],
        'COORDINATES' => $store['GPS_N'] . ',' . $store['GPS_S'],
        'ADDRESS' => $store['ADDRESS'],
        'PHONE' => $store['PHONE'],
        'EMAIL' => $store['EMAIL']
      ];

      /* info: Данные для яндекс карты */
      if ($store['GPS_N'] || $store['GPS_S'])
        $pointMap[] = [
          'name' => $store['TITLE'],
          'address' => $store['ADDRESS'],
          'phone' => $store['PHONE'],
          'email' => $store['EMAIL'],
          'COORDINATE' => [$store['GPS_N'] . ',' . $store['GPS_S']],
        ];
    }
    ?>

    <div class="map-sections">
      <div class="map-section map-section--selector">
        <!--<div class="map__title">Населенный пункт</div>
        <div class="map__selector">
          <div class="custom-select custom-select--white js-custom-select">
            <button class="custom-select__header js-custom-select-toggle"><span
                class="custom-select__selected js-custom-select-render">Москва</span><span
                class="custom-select__arrow">
                    <svg class="icon icon-hesrts-active ">
                      <use xlink:href="#hesrts-active"></use>
                    </svg></span></button>
            <div class="custom-select__body js-custom-select-list">
              <label class="custom-select__option">
                <input name="test" type="checkbox" value="1"><span class="custom-select__label">Пункт 1</span>
              </label>
              <label class="custom-select__option">
                <input name="test" type="checkbox" value="2"><span class="custom-select__label">Пункт 2</span>
              </label>
              <label class="custom-select__option">
                <input name="test" type="checkbox" value="3"><span class="custom-select__label">Пункт 3</span>
              </label>
            </div>
          </div>
        </div>-->
        <div class="map-points">
          <? foreach ($pointStores as $point): ?>
            <div class="map-point js-map-point" data-coordinates="<?= $point['COORDINATES'] ?>"
                 data-coord-id="<?= (int)$point['ID'] ?>">
              <div class="map-point__station">
                <div class="map-point__color" style="background-color: <?= $point['POINT_COLOR'] ?>;"></div>
                <?= $point['NAME'] ?>
              </div>
              <? if ($point['ADDRESS']): ?>
                <div class="map-point__address">
                  <?= $point['ADDRESS'] ?>
                </div>
              <? endif; ?>
              <div class="map-point__row">
                <div class="map-point__info">
                  Пункт выдачи
                  <?= $point['POINT_OF_DELIVERY'] ?></div>
                <!-- info: Временно скрыто -->
                <div class="map-point__dot" style="display: none"></div>
                <div class="map-point__info" style="display: none">
                  Срок хранения заказа
                  <?= $point['STORAGE_PERIOD_ORDER'] ?></div>
              </div>
            </div>
          <? endforeach; ?>
        </div>
      </div>
      <div class="map-section map-section--map">
        <div id="js-map-render" class="map-cities"></div>
      </div>
    </div>
  </div>

  <!-- Подключение блока bullets из parts -->
  <? include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/all-pages/footer-bullets.php") ?>

  <script>
    window.$addresses = <?= json_encode($pointMap) ?>
  </script>
</div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
