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
$this->setFrameMode(true); ?>
<?
$INPUT_ID = trim($arParams["~INPUT_ID"]);
if ($INPUT_ID == '')
  $INPUT_ID = "title-search-input";
$INPUT_ID = CUtil::JSEscape($INPUT_ID);

$CONTAINER_ID = trim($arParams["~CONTAINER_ID"]);
if ($CONTAINER_ID == '')
  $CONTAINER_ID = "title-search";
$CONTAINER_ID = CUtil::JSEscape($CONTAINER_ID);
?>

<form id="<?= $CONTAINER_ID ?>"
      class="form-search header__search"
      action="<?= $arResult["FORM_ACTION"] ?>">

  <div class="form-search__icon">
    <svg class="icon icon-search ">
      <use xlink:href="#search"></use>
    </svg>
  </div>

  <input id="<?= $INPUT_ID ?>"
         type="text"
         name="q"
         placeholder="Что вы ищите?"
         class="form-search__input"
         autocomplete="off">

  <?
  /* Получение списка категорий и вывод их */
  $category = CIBlockSection::GetList(
    ['SORT' => 'DESC'],
    ['IBLOCK_ID' => CATALOG_ID, 'ACTIVE' => 'Y', 'GLOBAL_ACTIVE' => 'Y'],
    true,
    ['ID', 'NAME', 'IBLOCK_SECTION_ID']
  );
  $categoriesData = [];
  while ($obCategory = $category->GetNext()) {
    if (!$obCategory['IBLOCK_SECTION_ID'])
      $categoriesData[$obCategory['ID']] = [
        'NAME' => $obCategory['NAME'],
      ];
  }
  /* Получение названия первого элемента в зависимости от страницы */
  $categoriesData[$_GET['section_id']]['NAME']
    ? $nameCategoryTab = $categoriesData[$_GET['section_id']]['NAME']
    : $nameCategoryTab = 'Везде'
  ?>
  <div class="custom-select form-search__select js-custom-select">
    <button type="button" class="custom-select__header js-custom-select-toggle">
      <span class="custom-select__selected js-custom-select-render">
        <?= $nameCategoryTab ?>
      </span>
      <span class="custom-select__arrow">
          <svg class="icon icon-down ">
            <use xlink:href="#down"></use>
          </svg>
        </span>
    </button>
    <div class="custom-select__body js-custom-select-list js-select-search-sections">
      <? foreach ($categoriesData as $categoryId => $categoryData): ?>
        <label class="custom-select__option">
          <input name="section_id"
                 class="js-select-category-id"
                 type="checkbox"
                 value="<?= $categoryId ?>"/>
          <span class="custom-select__label"><?= $categoryData['NAME'] ?></span>
        </label>
      <? endforeach; ?>
    </div>
  </div>

  <input name="s"
         type="submit"
         class="form-search__submit"
         value="<?= GetMessage("CT_BST_SEARCH_BUTTON"); ?>"/>
</form>

<script>
  BX.ready(function () {
    new JCTitleSearch({
      'AJAX_PAGE': '<?= CUtil::JSEscape(POST_FORM_ACTION_URI)?>',
      'CONTAINER_ID': '<?= $CONTAINER_ID?>',
      'INPUT_ID': '<?= $INPUT_ID?>',
      'MIN_QUERY_LEN': 2
    });
  });
</script>
