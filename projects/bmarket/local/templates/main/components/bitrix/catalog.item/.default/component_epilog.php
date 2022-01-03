<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();


if (UserFavoriteProducts::checkInFavorite($arResult["ITEM"]['ID'])) { ?>
    <script>
        document.querySelector('[data-favorite-btn="<?=$arResult["ITEM"]['ID']?>"]')
            .classList
            .add('product-in-favorite')
    </script>
<?
}
