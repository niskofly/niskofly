<?php
/**
 * Вырезать системные скрипты Bitrix
 *
 * Отключено для композита
 */
//AddEventHandler("main", "OnEndBufferContent", "deleteKernelJs");
function deleteKernelJs(&$content)
{
    global $USER, $APPLICATION;
    if ($USER->IsAdmin() || (is_object($USER) && $USER->IsAuthorized()) || strpos($APPLICATION->GetCurDir(), "/bitrix/") !== false) return;
    if ($APPLICATION->GetProperty("save_kernel") == "Y") return;

    $arPatternsToRemove = array(
        '/<script.+?src=".+?kernel_main\/kernel_main_v1\.js\?\d+"><\/script\>/',
        '/<script.+?src=".+?loadext\/loadext.min\.js\?\d+"><\/script\>/',
        '/<script.+?src=".+?kernel_main_polyfill_promise\/kernel_main_polyfill_promise_v1\.js\?\d+"><\/script\>/',
        '/<script.+?src=".+?loadext\/extension.min\.js\?\d+"><\/script\>/',
        '/<script.+?src=".+?bitrix\/js\/main\/core\/core[^"]+"><\/script\>/',
        '/<script.+?>BX\.(setCSSList|setJSList)\(\[.+?\]\).*?<\/script>/',
        '/<script.+?>if\(\!window\.BX\)window\.BX.+?<\/script>/',
        '/<script[^>]+?>\(window\.BX\|\|top\.BX\)\.message[^<]+<\/script>/',
    );

    $content = preg_replace($arPatternsToRemove, "", $content);
    $content = preg_replace("/\n{2,}/", "\n\n", $content);
}

/**
 * Вырезать системные стили Bitrix
 */
AddEventHandler("main", "OnEndBufferContent", "deleteKernelCss");
function deleteKernelCss(&$content)
{
    global $USER, $APPLICATION;
    if ((is_object($USER) && $USER->IsAuthorized()) || strpos($APPLICATION->GetCurDir(), "/bitrix/") !== false) return;
    if ($APPLICATION->GetProperty("save_kernel") == "Y") return;

    $arPatternsToRemove = array(
        '/<link.+?href=".+?kernel_main\/kernel_main_v1\.css\?\d+"[^>]+>/',
        '/<link.+?href=".+?bitrix\/js\/main\/core\/css\/core[^"]+"[^>]+>/',
        '/<link.+?href=".+?bitrix\/templates\/[\w\d_-]+\/styles.css[^"]+"[^>]+>/',
        '/<link.+?href=".+?bitrix\/templates\/[\w\d_-]+\/template_styles.css[^"]+"[^>]+>/',
    );

    $content = preg_replace($arPatternsToRemove, "", $content);
    $content = preg_replace("/\n{2,}/", "\n\n", $content);
}

/**
 * Запись первой буквы бренда
 */
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "addFirstLetter");
function addFirstLetter($arFields)
{
    $property = CIBlockElement::GetByID($arFields['ID'])->GetNextElement()->GetProperties();
    $firstLetter = getFirstLetter(getNameElementById($property['BRAND']['VALUE']));
    CIBlockElement::SetPropertyValuesEx($arFields['ID'], CATALOG_ID, ['FIRST_LETTER' => $firstLetter]);
}


/**
 * Рейтинг товара на основании отзывов
 */
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", ["RatingUpdateHandler", "updateProductRatings"]);

class RatingUpdateHandler
{
    public static function updateProductRatings($arFields)
    {
        /**
         * Обновить рейтинг товара на основании отзывов
         */
        $productProperty = CIBlockElement::GetProperty($arFields['IBLOCK_ID'], $arFields['ID'], ["sort" => "asc"], ["CODE" => "BIND_PRODUCT"]);
        $productId = $productProperty->Fetch()['VALUE'];
        self::recalculateReviewRating($productId);
    }

    /**
     * Пересчитать рейтинг товара на основании отзывов
     * @param $productId
     */
    public static function recalculateReviewRating($productId)
    {
        $reviewsQuery = CIBlockElement::GetList(
            ['PROPERTY_DATE' => 'desc', 'SORT' => 'asc'],
            [
                'IBLOCK_ID' => REVIEW_IBLOCK_ID,
                'ACTIVE' => 'Y',
                '=PROPERTY_BIND_PRODUCT' => $productId
            ],
            false,
            false,
            ['*']
        );

        $reviewRating = 0;
        $countReviews = 0;
        while ($review = $reviewsQuery->GetNextElement()) {
            $props = $review->GetProperties();
            $reviewRating += (int)$props['COUNT_STAR']['VALUE'];
            $countReviews++;
        }

        $reviewRating = round($reviewRating / $countReviews);
        CIBlockElement::SetPropertyValuesEx($productId, CATALOG_ID, ['RATING_REVIEW' => $reviewRating > 0 ? $reviewRating : NULL]);
    }
}

/**
 * Запись избранных товаров из cookie
 */
AddEventHandler("main", "OnAfterUserAuthorize", "addFavoritesUser");
/**
 * @throws Exception
 */
function addFavoritesUser($arUser)
{
  /* info: Получаем элементы из cookie */
  $favoriteCookieHandler = new CookieFieldHandler('favorite_no_auth');
  $elements = $favoriteCookieHandler->getElements();

  /* info: Сохраняем полученные элементы у пользователя */
  $favoriteUserHandler = new UserFavoriteProducts();
  foreach ($elements as $element){
    $favoriteUserHandler->addOrRemoveProduct($element);
  }

  /* info: Чистим cookie */
  $favoriteCookieHandler->deleteAllElements();
}
