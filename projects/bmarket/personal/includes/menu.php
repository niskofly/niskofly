<?
$handler = new UserFavoriteProducts();
$favoriteCount = $handler->getCountFavorites();
$isOrderDetailPage = stristr($APPLICATION->GetCurPage(), '/personal/order/') !== false;
?>
<div class="section-nav container">
    <ul class="nav nav--lk">
        <li class="nav__item">
            <a href="/personal/" class="nav__link <?= setActiveClassByLink('/personal/') ?>">
                Мои данные
            </a>
        </li>
        <li class="nav__item">
            <a href="/personal/order/" class="nav__link <?= $isOrderDetailPage ? 'active' : '' ?>">
                Мои заказы
            </a>
        </li>
        <li class="nav__item">
            <a href="/personal/favorites/" class="nav__link <?= setActiveClassByLink('/personal/favorites/') ?>">
                Избранные товары
                <span class="js-favorites-counter-page" style="margin-left: 5px">
                    <? echo $favoriteCount ? "($favoriteCount)" : '' ?>
                </span>
            </a>
        </li>
    </ul>
</div>
