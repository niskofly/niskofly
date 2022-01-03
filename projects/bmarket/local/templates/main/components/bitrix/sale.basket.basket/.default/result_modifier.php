<? $count = 0;

use Bitrix\Sale;

$basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
foreach ($arResult["BASKET_ITEM_RENDER_DATA"] as $arItem) {
    if ($arItem['AVAILABLE_QUANTITY'] == 0) {
        $basket->getItemById($arItem["ID"])->delete();
        $basket->save();
        $arResult["TOTAL_RENDER_DATA"]['PRICE'] = $arResult["TOTAL_RENDER_DATA"]['PRICE'] - $arItem['SUM_PRICE'];
        unset($arResult["BASKET_ITEM_RENDER_DATA"][$count]);
    } elseif ($arItem['QUANTITY'] > $arItem['AVAILABLE_QUANTITY']) {
        $basketItems = $basket->getBasketItems();
        foreach ($basketItems as $basketItem) {
            if ($basketItem->getId() == $arItem['ID']) {
                $basketItem->setField('QUANTITY', $arItem['AVAILABLE_QUANTITY']);
                $arResult["BASKET_ITEM_RENDER_DATA"][$count]['QUANTITY'] = $arItem['AVAILABLE_QUANTITY'];
            }
        }
    }
    $count++;
}

