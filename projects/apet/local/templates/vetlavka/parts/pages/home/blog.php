<?
/* Получение названий категорий публикаций */
$nameCategory = [];
$categories = CIBlockSection::GetTreeList(
  ['IBLOCK_ID' => BLOG_ID]
);
while ($category = $categories->GetNext()) {
  $nameCategory[$category['ID']] = $category['NAME'];
}

/* Получение публикации */
$blogs = [];
$obBlogs = CIBlockElement::GetList(
  ['SORT' => 'RAND'],
  ['IBLOCK_ID' => BLOG_ID, 'ACTIVE' => 'Y', 'ACTIVE_DATA' => 'Y'],
  false,
  false,
  ['*']
);
while ($obBlog = $obBlogs->GetNextElement()) {
  $fieldsBlog = $obBlog->GetFields();
  $blogs[] = [
    'NAME' => $fieldsBlog['NAME'],
    'PREVIEW_TEXT' => $fieldsBlog['PREVIEW_TEXT'],
    'IMG' => CFile::GetPath($fieldsBlog['PREVIEW_PICTURE']),
    'DETAIL_PAGE_URL' => $fieldsBlog['DETAIL_PAGE_URL'],
    'NAME_CATEGORY' => $nameCategory[$fieldsBlog['IBLOCK_SECTION_ID']],
    'DATA_CREATE' => ConvertDateTime($fieldsBlog["DATE_CREATE"], "DD.MM.YYYY"),
  ];
}
?>

<? if ($blogs): ?>
  <div class="home-section">
    <div class="container">
      <div class="home-title title-row">
        <div class="title">Блог</div>
        <a href="/blog" class="link">Перейти в раздел</a>
      </div>
      <div class="home-blog-wrapper">
        <div class="home-blog">
          <? foreach ($blogs as $blog): ?>
            <div class="blog-card">
              <a href="<?= $blog['DETAIL_PAGE_URL'] ?>" class="blog-card-header">
                <img src="<?= $blog['IMG'] ?: NO_IMAGE_SRC_VETLAVKA?>"
                    alt="<?= $blog['NAME'] ?>"
                    class="blog-card-header__img"/></a>
              <div class="blog-card-body">
                <a href="<?= $blog['DETAIL_PAGE_URL'] ?>" class="blog-card-body__title"><?= $blog['NAME'] ?></a>
                <div class="blog-card-body__description"><?= $blog['PREVIEW_TEXT'] ?></div>
              </div>
              <div class="blog-card-footer">
                <div class="blog-card-footer__tag"><?= $blog['NAME_CATEGORY'] ?></div>
                <div class="blog-card-footer__date"><?= $blog['DATA_CREATE'] ?></div>
              </div>
            </div>
          <? endforeach; ?>
        </div>
      </div>
    </div>
  </div>
<? endif; ?>
