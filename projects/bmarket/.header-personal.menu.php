<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$aMenuLinks = Array(
	Array(
		"Мои данные",
		"/personal/",
		Array(),
		Array(),
		""
	),
	Array(
		"Мои заказы",
		"/personal/order/",
		Array(),
		Array(),
		""
	),
	Array(
		"Выйти",
		"/auth/logout/",
		Array(),
        Array('CLASS' => 'nav__link--logout'),
		""
	),
);
?>
