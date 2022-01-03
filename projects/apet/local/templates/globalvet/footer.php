<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
  die();

/* Получение брендов */
$brands = [];
$obBrands = CIBlockElement::GetList(
  ['SORT' => 'ASC'],
  ['IBLOCK_ID' => BRANDS_ID, 'ACTIVE' => 'Y', 'ACTIVE_DATA' => 'Y'],
  false,
  ['nTopCount' => 15],
  ['*']
);

while ($obBrand = $obBrands->GetNext()) {
  /* Вывод брендов при наличии картинкой */
  if ($obBrand['PREVIEW_PICTURE'])
    $brands[] = [
      'IMG' => CFile::GetPath($obBrand['PREVIEW_PICTURE']),
      'NAME' => $obBrand['NAME'],
    ];
}
?>

<footer class="footer">
  <div class="footer__top">
    <div class="container footer__slider">
      <div data-slider-id="brands" class="swiper-container footer__slider-container js-slider">
        <div class="swiper-wrapper footer__slider-wrapper">
          <? foreach ($brands as $brand): ?>
            <div class="swiper-slide">
              <a href="/brands" class="footer__slider-image">
                <img src="<?= $brand['IMG'] ?>" alt="<?= $brand['NAME'] ?>"/>
              </a>
            </div>
          <? endforeach; ?>
        </div>
      </div>
    </div>
    <div class="container footer__wrapper">
      <div class="footer-nav">
        <div class="footer-nav__column">
          <div class="footer-nav__title">Каталог</div>
          <?
          $APPLICATION->IncludeComponent(
            "bitrix:menu",
            "footer",
            array(
              "COMPONENT_TEMPLATE" => ".default",
              "ROOT_MENU_TYPE" => "footer_catalog",
              "MENU_CACHE_TYPE" => "N",
              "MENU_CACHE_TIME" => "3600",
              "MENU_CACHE_USE_GROUPS" => "Y",
              "MENU_CACHE_GET_VARS" => "",
              "MAX_LEVEL" => "1",
              "CHILD_MENU_TYPE" => "left",
              "USE_EXT" => "Y",
              "DELAY" => "N",
              "ALLOW_MULTI_SELECT" => "N",
            ),
            false
          );
          ?>
        </div>
        <div class="footer-nav__column">
          <div class="footer-nav__title">Покупателям</div>
          <?
          $APPLICATION->IncludeComponent(
            "bitrix:menu",
            "footer",
            array(
              "COMPONENT_TEMPLATE" => "footer",
              "ROOT_MENU_TYPE" => "footer_client",
              "MENU_CACHE_TYPE" => "N",
              "MENU_CACHE_TIME" => "3600",
              "MENU_CACHE_USE_GROUPS" => "Y",
              "MENU_CACHE_GET_VARS" => array(),
              "MAX_LEVEL" => "1",
              "CHILD_MENU_TYPE" => "left",
              "USE_EXT" => "N",
              "DELAY" => "N",
              "ALLOW_MULTI_SELECT" => "N"
            ),
            false
          );
          ?>
        </div>
        <div class="footer-nav__column">
          <div class="footer-nav__title">Компания</div>
          <?
          $APPLICATION->IncludeComponent(
            "bitrix:menu",
            "footer",
            array(
              "COMPONENT_TEMPLATE" => ".default",
              "ROOT_MENU_TYPE" => "footer_company",
              "MENU_CACHE_TYPE" => "N",
              "MENU_CACHE_TIME" => "3600",
              "MENU_CACHE_USE_GROUPS" => "Y",
              "MENU_CACHE_GET_VARS" => "",
              "MAX_LEVEL" => "1",
              "CHILD_MENU_TYPE" => "left",
              "USE_EXT" => "N",
              "DELAY" => "N",
              "ALLOW_MULTI_SELECT" => "N",
            ),
            false
          );
          ?>
        </div>
      </div>
      <div class="footer__info">
        <div class="footer__title">Наши контакты</div>
        <ul class="footer__info-list">
          <li class="footer__info-item">
            <a href="tel: <?= SiteInfo::getItem('globalVet', 'phone') ?>">
              <?= SiteInfo::getItem('globalVet', 'phone') ?>
            </a>
          </li>
          <li class="footer__info-item">
            <a
              href="mailto: <?= SiteInfo::getItem('globalVet', 'email') ?>"><?= SiteInfo::getItem('globalVet', 'email') ?></a>
          </li>
          <li class="footer__info-item"><?= SiteInfo::getItem('globalVet', 'address') ?></li>
          <li class="footer__info-item"><?= SiteInfo::getItem('globalVet', 'warehouse') ?></li>
        </ul>
      </div>
      <div class="footer__contacts">
        <div class="footer__title">Подписывайтесь на обновления</div>
        <form action="/api/user/subscribe.php" class="form-subscribe footer__form-subscribe js-form-sender">
          <?= bitrix_sessid_post() ?>
          <input type="hidden"
                 name="ACTION"
                 value="CREATE_UPDATES">
          <input type="email" name="EMAIL" placeholder="Ваш email" class="form-subscribe__input"/>
          <button type="submit" class="form-subscribe__submit">
            <svg class="icon icon-go ">
              <use xlink:href="#go"></use>
            </svg>
          </button>
        </form>
        <div class="footer__social">
          <div class="footer__subtitle">Мы в соцсетях</div>
          <div class="footer__social-links">
            <a href="<?= SiteInfo::getItem('globalVet', 'vk') ?>" class="footer__social-link">
              <svg class="icon icon-vk ">
                <use xlink:href="#vk"></use>
              </svg>
            </a>
            <a href="<?= SiteInfo::getItem('globalVet', 'facebook') ?>" class="footer__social-link">
              <svg class="icon icon-facebook ">
                <use xlink:href="#facebook"></use>
              </svg>
            </a>
            <a href="<?= SiteInfo::getItem('globalVet', 'instagram') ?>" class="footer__social-link">
              <svg class="icon icon-instagram ">
                <use xlink:href="#instagram"></use>
              </svg>
            </a>
            <a href="<?= SiteInfo::getItem('globalVet', 'youtube') ?>" class="footer__social-link">
              <svg class="icon icon-youtube ">
                <use xlink:href="#youtube"></use>
              </svg>
            </a>
            <a href="<?= SiteInfo::getItem('globalVet', 'twitter') ?>" class="footer__social-link">
              <svg class="icon icon-twitter ">
                <use xlink:href="#twitter"></use>
              </svg>
            </a>
          </div>
        </div>
        <div class="footer__pay">
          <div class="footer__subtitle">Способ оплаты</div>
          <div class="footer__pay-links">
            <img src="/img/icons/visa.svg" alt="visa" class="footer__pay-logo"/>
            <img src="/img/icons/mastercard.svg" alt="mastercard" class="footer__pay-logo"/>
            <img src="/img/icons/maest-2.svg" alt="maestro" class="footer__pay-logo"/>
            <img src="/img/icons/mir.svg" alt="mir" class="footer__pay-logo"/></div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer__bottom">
    <div class="container footer__wrapper">
      <div class="footer__text">© <?= date('Y') ?> ООО "АВК"</div>
      <a href="/politic" class="footer__text">Пользовательское соглашение</a>
      <a href="https://wbest.ru/" class="footer__dev">
        <span class="footer__dev-label">Разработано</span>
        <img src="/img/icons/webest.svg" alt="" class="footer__dev-logo"/>
      </a>
    </div>
  </div>
</footer>
</div>

<?
global $ASSETS_VERSION;

/* Modal window include */
include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/modals.php");

/* Lazy load images include */
include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/lazy-load-script.php");

/* Подключение метрик сайта */
include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/metrics.php");
?>

<!-- Подключение яндекс карт-->
<script src="<?= YANDEX_MAP_SRC ?>"></script>

<!-- Подключение яндекс карт-->
<script src="<?= SITE_TEMPLATE_PATH . '/js/app.min.js?ver=' . $ASSETS_VERSION; ?>"></script>

</body>
</html>
