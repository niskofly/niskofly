<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

/* info: Временно скрыто */
LocalRedirect('/');

$APPLICATION->SetTitle("Помощь");
$APPLICATION->SetPageProperty("title", "Помощь");
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

    <!-- Add content for page help -->
    <div class="page__title title">
      <h1 class="seo-title">
        <? $APPLICATION->ShowTitle(false); ?>
      </h1>
    </div>

    <!-- Output helpers data -->
    <?
    $helpers = [];
    $qrHelpers = CIBlockElement::GetList(
      ['SORT' => 'ASC'],
      ['IBLOCK_ID' => HELP_IBLOCK_ID, 'ACTIVE' => 'Y'],
      false, false,
      ['ID', '*']
    );
    while ($element = $qrHelpers->GetNext())
      $helpers[] = [
        'NAME' => $element['NAME'],
        'PREVIEW_TEXT' => $element['PREVIEW_TEXT']
      ];
    ?>

    <div class="page-sides">
      <div class="page-sides__left">
        <div class="help-collapses">
          <? foreach ($helpers as $helpId => $help): ?>
            <div class="help-collapse">
              <div class="collapse js-toggle-element <?= $helpId == 0 ? 'toggle-element--open' : '' ?>">
                <button class="collapse-header js-toggle-element-action">
                  <div class="collapse-header__title"><?= $help['NAME'] ?></div>
                  <div class="collapse-header__icon"></div>
                </button>
                <div class="collapse-body js-toggle-element-body">
                  <div class="collapse-body__text"><?= $help['PREVIEW_TEXT'] ?></div>
                </div>
              </div>
            </div>
          <? endforeach; ?>
        </div>

        <div class="typography">
          <?= CIBlock::GetArrayByID(HELP_IBLOCK_ID, "DESCRIPTION"); ?>
        </div>
      </div>

      <div class="page-sides__right">
        <div class="help-aside">
          <span class="help-aside__title">
              <?= SiteInfo::getItem('vetLavka', 'phone') ?></span>
          <div class="help-aside__description">Мы рады помочь вам 24/7</div>
          <div class="help-aside__button">
            <a href="tel: <?= SiteInfo::getItem('vetLavka', 'phone') ?>" class="btn">Связаться с нами</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Подключение блока bullets из parts -->
  <? include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/all-pages/footer-bullets.php") ?>
</div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
