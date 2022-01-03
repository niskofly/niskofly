<?
$nameCategory = [];
$categories = CIBlockSection::GetTreeList(
  ['IBLOCK_ID' => CATALOG_ID],
);

while ($category = $categories->GetNext()) {
  if (!$category['IBLOCK_SECTION_ID']) {
    $nameCategory[$category['ID']] = [
      'NAME' => $category['NAME'],
      'URL' => $category['SECTION_PAGE_URL'],
      'IMG' => CFile::GetPath($category['PICTURE'])
    ];
  } elseif ($category['DEPTH_LEVEL'] == 2) {
    $nameCategory[$category['IBLOCK_SECTION_ID']]['SUB_CATEGORY'][] = [
      'NAME' => $category['NAME'],
      'URL' => $category['SECTION_PAGE_URL']
    ];
  }
}
?>

<? if ($nameCategory): ?>
  <div class="home-section">
    <div class="container">
      <div class="home-categories">
        <? foreach ($nameCategory as $nameCategoryElement): ?>
          <div class="home-category">
            <div class="home-category__title"><?= $nameCategoryElement['NAME'] ?></div>
            <div class="home-category__links">
              <? if (!empty($nameCategoryElement['SUB_CATEGORY'])): ?>
                <? $count = 0 ?>
                <? foreach ($nameCategoryElement['SUB_CATEGORY'] as $subCategory): ?>
                  <?
                  $count++;
                  if ($count > 5)
                      continue;
                  ?>
                  <a href="<?= $subCategory['URL'] ?>" class="home-category__link">
                    <div class="home-category__link-icon">
                      <svg class="icon icon-trace ">
                        <use xlink:href="#trace"></use>
                      </svg>
                    </div>
                    <div class="home-category__link-text"><?= $subCategory['NAME'] ?></div>
                  </a>
                <? endforeach; ?>
              <? else: ?>
                <p>Категории отсутствуют</p>
              <? endif; ?>
            </div>
            <a href="<?= $nameCategoryElement['URL'] ?>" class="home-category__more link link--bold">Смотреть больше</a>
            <? if ($nameCategoryElement['IMG']): ?>
              <div class="home-category__img">
                <img src="<?= $nameCategoryElement['IMG'] ?>" alt="<?= $nameCategoryElement['NAME'] ?>">
              </div>
            <? endif; ?>
          </div>
        <? endforeach; ?>
      </div>
    </div>
  </div>
<? endif; ?>
