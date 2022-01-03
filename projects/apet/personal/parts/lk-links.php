<?
global $APPLICATION;
?>
<div class="lk-links">
    <a href="/personal/" class="lk-links__item <?= setActiveClassByLink('/personal/', 'lk-links__item--active') ?>">Мои заказы</a>
    <a href="/personal/edit/" class="lk-links__item <?= setActiveClassByLink('/personal/edit/', 'lk-links__item--active') ?>">Личные данные</a>
    <a href="/personal/favorites/" class="lk-links__item <?= setActiveClassByLink('/personal/favorites/', 'lk-links__item--active') ?>">Избранное</a>
    <a href="/personal/profiles-order/" class="lk-links__item <?= setActiveClassByLink('/personal/profiles-order/', 'lk-links__item--active') ?>">Профили заказа</a>
    <!-- info: Временно скрыто
    <a href="/personal/subscription/" class="lk-links__item <?/*= setActiveClassByLink('/personal/subscription/', 'lk-links__item--active') */?>">Мои подписки</a>
    -->
    <a href="/personal/subscription-arrival/" class="lk-links__item <?= setActiveClassByLink('/personal/subscription-arrival/', 'lk-links__item--active') ?>">Подписки на поступления</a>
    <a href="/user/logout" class="lk-links__item">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
             class="icon icon-exit">
            <path d="M9.16667 13.3333L5.83333 9.99992M5.83333 9.99992L9.16667 6.66658M5.83333 9.99992H17.5M13.3333 13.3333V14.1666C13.3333 14.8296 13.0699 15.4655 12.6011 15.9344C12.1323 16.4032 11.4964 16.6666 10.8333 16.6666H5C4.33696 16.6666 3.70107 16.4032 3.23223 15.9344C2.76339 15.4655 2.5 14.8296 2.5 14.1666V5.83325C2.5 5.17021 2.76339 4.53433 3.23223 4.06549C3.70107 3.59664 4.33696 3.33325 5 3.33325H10.8333C11.4964 3.33325 12.1323 3.59664 12.6011 4.06549C13.0699 4.53433 13.3333 5.17021 13.3333 5.83325V6.66658"
                  stroke="#92887B" stroke-width="1.3" stroke-linecap="round"
                  stroke-linejoin="round">
            </path>
        </svg>
        Выход
    </a>
</div>
