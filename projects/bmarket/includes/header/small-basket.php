<?$frame = new \Bitrix\Main\Page\FrameBuffered("header_small_basket");
$frame->begin();

$cntBasketItems = ItemsBitrixCart::getCountBasketItems();
$cntBasketItems = $cntBasketItems ?: null;
?>
<li class="nav__item">
    <a href="<? echo $cntBasketItems ? '/personal/cart/' : '#' ?>"
       data-url="/personal/cart/"
       class="nav__link nav__link--user-menu js-small-basket-link">
        <svg class="icon icon-basket ">
            <use xlink:href="#basket"></use>
        </svg>
        <span class="nav__link-title">Корзина</span>
        <span class="nav__link-counter js-small-basket-count"><?= $cntBasketItems ?></span>
    </a>
</li>
<?$frame->beginStub();?>
<li class="nav__item">
    <a href="<? echo $cntBasketItems ? '/personal/cart/' : '#' ?>"
       data-url="/personal/cart/"
       class="nav__link nav__link--user-menu js-small-basket-link">
        <svg class="icon icon-basket ">
            <use xlink:href="#basket"></use>
        </svg>
        <span class="nav__link-title">Корзина</span>
        <span class="nav__link-counter js-small-basket-count"><?= $cntBasketItems ?></span>
    </a>
</li>
<?$frame->end();?>
