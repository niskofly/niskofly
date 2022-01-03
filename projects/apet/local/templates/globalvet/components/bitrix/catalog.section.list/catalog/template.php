<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$arViewModeList = $arResult['VIEW_MODE_LIST'];
$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

if ($arResult["SECTIONS_COUNT"]):

  switch ($arParams['VIEW_MODE']):
    case 'LINE':
      # РАЗДЕЛЫ СО СЛАЙДЕРАМИ
      $APPLICATION->SetTitle($arResult["SECTION"]["NAME"]);

      foreach ($arResult['FORMATED_SECTIONS'] as $arSection):
        $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
        $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
        ?>
        <div class="catalog-section container" id="<? echo $this->GetEditAreaId($arSection['ID']); ?>">
          <div class="section-header section-header--subsection">
            <div class="title"><?= $arSection['NAME']; ?></div>
            <a href="<?= $arSection['SECTION_PAGE_URL']; ?>" class="section-header__link">Перейти в раздел</a>
          </div>
          <?
          if ($arSection["SUB_SECTIONS"]):
            ?>
            <div data-slider-id="catalog-sections" class="swiper-container js-slider">
              <div class="swiper-wrapper">
                <?
                foreach ($arSection["SUB_SECTIONS"] as $arSubSect):
                  ?>
                  <div class="swiper-slide">
                    <a href="<?= $arSubSect['SECTION_PAGE_URL']; ?>"
                       class="catalog-category catalog-category--subsection">
                  <span class="catalog-category__preview">
                    <img src="<?= CFile::GetPath($arSubSect['PICTURE']); ?>" alt="<?= $arSubSect["NAME"]; ?>">
                  </span>
                      <span class="catalog-category__title"><?= $arSubSect["NAME"]; ?></span>
                    </a>
                  </div>
                <?
                endforeach;
                ?>
              </div>
            </div>
          <?
          endif;
          ?>
        </div>
      <?
      endforeach;
      unset($arSection);
      break;
    case 'TEXT':
      # СРЕДНИЕ КАРТОЧКИ С ИЗОБРАЖЕНИЕМ И ССЫЛКОЙ НА РАЗДЕЛ
      ?>
      <div class="section-categories container">
        <div class="catalog-categories">
          <?
          foreach ($arResult['SECTIONS'] as &$arSection):
            $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
            $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
            ?>
            <a
              href="<?= $arSection['SECTION_PAGE_URL']; ?>"
              class="catalog-category catalog-category--medium"
              id="<? echo $this->GetEditAreaId($arSection['ID']); ?>">
              <span class="catalog-category__title"><?= $arSection['NAME']; ?></span>
              <span class="catalog-category__preview">
                <img
                  src="<?= $arSection['PICTURE']['SRC'] ? $arSection['PICTURE']['SRC'] : NO_IMAGE_SRC_GLOBALVET; ?>"
                  alt="<?= $arSection['NAME']; ?>"
                  title="<?= $arSection['NAME']; ?>"/>
              </span>
              <span class="btn btn--white btn--medium catalog-category__link">
                <span>подробнее</span>
                <span class="btn__icon-round">
                  <svg class="icon icon-next ">
                    <use xlink:href="#next"></use>
                  </svg>
                </span>
              </span>
            </a>
          <?
          endforeach;
          ?>
        </div>
      </div>
      <?
      unset($arSection);
      break;
    case 'TILE':
      # МАЛЕНЬКИЕ КАРТОЧКИ С ИЗОБРАЖЕНИЕМ И ССЫЛКОЙ НА РАЗДЕЛ
      ?>
      <div class="section-categories container">
        <div class="catalog-categories js-fixed-section" data-extra-height>
          <?
          foreach ($arResult['SECTIONS'] as &$arSection):
            $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
            $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
            ?>
            <a href="<?= $arSection['SECTION_PAGE_URL']; ?>" class="catalog-category"
               id="<? echo $this->GetEditAreaId($arSection['ID']); ?>">
              <? if ($arSection['PICTURE']['SRC']): ?>
                <span class="catalog-category__preview">
                  <img src="<?= $arSection['PICTURE']['SRC']; ?>" alt="<?= $arSection['NAME']; ?>">
                </span>
              <? endif; ?>
              <span class="catalog-category__title"><?= $arSection['NAME']; ?></span>
            </a>
          <?
          endforeach;
          ?>
        </div>
      </div>
      <?
      unset($arSection);
      break;
    case 'LIST':
      # БОЛЬШИЕ КАРТОЧКИ СО СПИСКОМ ПОДРАЗДЕЛОВ
      ?>
      <div class="section-subcategories container">
        <div class="catalog-categories">
          <?
          foreach ($arResult['FORMATED_SECTIONS'] as $arSection):
            $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
            $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
            ?>
            <div class="catalog-category catalog-category--big">
              <div class="catalog-category__main">
                <div class="catalog-category__header">
                  <div class="catalog-category__title"><?= $arSection["NAME"]; ?></div>
                  <a href="<?= $arSection["SECTION_PAGE_URL"]; ?>" class="catalog-category__link">Перейти в раздел</a>
                </div>
                <ul class="catalog-category__list">
                  <?
                  foreach ($arSection["SUB_SECTIONS"] as $arSubSection):
                    ?>
                    <li class="catalog-category__list-item">
                      <a href="<?= $arSubSection["SECTION_PAGE_URL"]; ?>"
                         class="catalog-category__list-link"><?= $arSubSection["NAME"]; ?></a>
                    </li>
                  <?
                  endforeach;
                  ?>
                </ul>
              </div>
              <? if ($arSection["PICTURE"]["SRC"]): ?>
                <div class="catalog-category__preview">
                  <img src="<?= $arSection["PICTURE"]["SRC"]; ?>">
                </div>
              <? endif; ?>
            </div>
          <?
          endforeach;
          unset($arSection);
          ?>
        </div>
      </div>
      <?
      break;
  endswitch;
endif;
?>
