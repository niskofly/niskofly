<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
  die();
?>

<footer class="footer">
  <div class="footer-top">
    <div class="container footer-wrapper">
      <div class="footer-links">
        <?
        $APPLICATION->IncludeComponent(
          "bitrix:menu",
          ".footer_catalog",
          array(
            "COMPONENT_TEMPLATE" => ".footer_catalog",
            "MAX_LEVEL" => "1",
            "ROOT_MENU_TYPE" => "footer_catalog",
            "MENU_CACHE_TYPE" => "N",
            "MENU_CACHE_TIME" => "3600",
            "MENU_CACHE_USE_GROUPS" => "Y",
            "MENU_CACHE_GET_VARS" => "",
            "USE_EXT" => "Y",
            "DELAY" => "N",
            "ALLOW_MULTI_SELECT" => "N",
            "CHILD_MENU_TYPE" => "left",
          ),
          false
        );
        ?>

        <?
        $APPLICATION->IncludeComponent(
          "bitrix:menu",
          ".footer_buyers",
          array(
            "COMPONENT_TEMPLATE" => ".footer_buyers",
            "MAX_LEVEL" => "1",
            "ROOT_MENU_TYPE" => "footer_buyers",
            "MENU_CACHE_TYPE" => "N",
            "MENU_CACHE_TIME" => "3600",
            "MENU_CACHE_USE_GROUPS" => "Y",
            "MENU_CACHE_GET_VARS" => "",
            "USE_EXT" => "Y",
            "DELAY" => "N",
            "ALLOW_MULTI_SELECT" => "N",
            "CHILD_MENU_TYPE" => "left",
          ),
          false
        );
        ?>

        <?
        $APPLICATION->IncludeComponent(
          "bitrix:menu",
          ".footer_company",
          array(
            "COMPONENT_TEMPLATE" => ".footer_company",
            "MAX_LEVEL" => "1",
            "ROOT_MENU_TYPE" => "footer_company",
            "MENU_CACHE_TYPE" => "N",
            "MENU_CACHE_TIME" => "3600",
            "MENU_CACHE_USE_GROUPS" => "Y",
            "MENU_CACHE_GET_VARS" => "",
            "USE_EXT" => "Y",
            "DELAY" => "N",
            "ALLOW_MULTI_SELECT" => "N",
            "CHILD_MENU_TYPE" => "left",
          ),
          false
        );
        ?>


        <div class="footer-links__column">
          <div class="footer-links__column-title ">Наши контакты</div>
          <a href="tel: <?= SiteInfo::getItem('vetLavka', 'phone') ?>"
             class="footer-links__column-item footer-links__column-item_phone">
            <?= SiteInfo::getItem('vetLavka', 'phone') ?></a>
          <a href="mailto: <?= SiteInfo::getItem('vetLavka', 'email') ?>"
             class="footer-links__column-item footer-links__column-item_mail">
            <?= SiteInfo::getItem('vetLavka', 'email') ?></a>
          <a href="/contacts/" class="footer-links__column-item footer-links__column-item_location">
            <?= SiteInfo::getItem('vetLavka', 'addressDetailed') ?></a>
        </div>
      </div>
      <div class="footer-actions">
        <!-- info: Временно скрыто
        <div class="footer-actions__subscription">
          <div class="footer-actions__subscription-title">Подписывайтесь на обновления</div>
          <form action="/api/user/controller-subscribe.php" class="js-form-send">
            <?/*= bitrix_sessid_post() */?>
            <input type="hidden"
                   name="ACTION"
                   value="CREATE_UPDATES">
            <input type="hidden"
                   name="THEME"
                   value="Подписка на обновления">
            <input type="hidden"
                   name="USER_RESPONSE"
                   value="Подписка на рассылку выполнена">
            <div class="footer-actions__subscription-input">
              <input aria-label="" type="text" name="EMAIL" placeholder="Ваш email"/>
              <button type="submit">Подписаться</button>
            </div>
          </form>
        </div>
        -->

        <div class="footer-actions__row">
          <div class="footer-actions__socials">
            <div class="footer-actions__socials-title">Мы в соцсетях</div>
            <div class="footer-actions__socials-links">
              <a style=" display: none; " href="<?= SiteInfo::getItem('vetLavka', 'vk') ?>" target="_blank" class="footer-actions__socials-links_item">
                <svg class="icon icon-vk ">
                  <use xlink:href="#vk"></use>
                </svg>
              </a>
              <a style=" display: none; " href="<?= SiteInfo::getItem('vetLavka', 'fb') ?>" target="_blank" class="footer-actions__socials-links_item">
                <svg class="icon icon-fb ">
                  <use xlink:href="#fb"></use>
                </svg>
              </a>
              <a href="<?= SiteInfo::getItem('vetLavka', 'instagram') ?>" target="_blank" class="footer-actions__socials-links_item">
                <svg class="icon icon-insta ">
                  <use xlink:href="#insta"></use>
                </svg>
              </a>
            </div>
          </div>
          <div class="footer-actions__socials">
            <div class="footer-actions__socials-title">Способ оплаты</div>
            <div class="footer-actions__socials-links">
              <div class="footer-actions__socials-links_item">
                <svg class="icon icon-visa ">
                  <use xlink:href="#visa"></use>
                </svg>
              </div>
              <div class="footer-actions__socials-links_item">
                <svg class="icon icon-mastercard ">
                  <use xlink:href="#mastercard"></use>
                </svg>
              </div>
              <div class="footer-actions__socials-links_item">
                <svg class="icon icon-maestro ">
                  <use xlink:href="#maestro"></use>
                </svg>
              </div>
              <div class="footer-actions__socials-links_item">
                <svg class="icon icon-mir ">
                  <use xlink:href="#mir"></use>
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container footer-wrapper">
      <div class="footer-copyright">
        <div class="footer-copyright__text">
          © Зоомагазин «Ветлавка» - компания группы Globalvet
          <?= date('Y') ?>
        </div>
      </div>
      <div class="footer-policy">
        <a href="/politic/" class="footer-policy__link">Политика конфиденциальности</a>
        <a href="/agreement/" class="footer-policy__link">Пользовательское соглашение</a>
      </div>
      <div class="footer-developer-wrapper">
        <a href="https://wbest.ru/" target="_blank" class="footer-developer">
          <div class="footer-developer__span">Разработано</div>
          <div class="footer-developer__logo">
            <svg class="icon icon-webest ">
              <use xlink:href="#webest" target="_blank"></use>
            </svg>
          </div>
        </a>
      </div>
    </div>
  </div>
</footer>

<?
global $ASSETS_VERSION;

/**
 * Modal window include
 */
include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/modals.php");

/**
 * Lazy load images include
 */
include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/lazy-load-script.php");

/**
 * Подключение метрик сайта
 */
include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/metrics.php");
?>

<!-- Подключение Yandex Map -->
<script src="<?= YANDEX_MAP_SRC ?>"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/js/app.min.js?ver=<?= $ASSETS_VERSION ?>"></script>

</body>
</html>
