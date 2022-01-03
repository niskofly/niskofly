<?
$handler = new UserFavoriteProducts();
$favoriteCount = $handler->getCountFavorites();
?>
<li class="nav__item">
    <a href="/personal/favorites/"
       class="nav__link nav__link--user-menu js-favorites-link">
        <svg class="icon icon-like ">
            <use xlink:href="#like"></use>
        </svg>
        <span>Избранное</span>
        <span class="nav__link-counter js-favorites-counter"><?= $favoriteCount ?></span>
    </a>
</li>
