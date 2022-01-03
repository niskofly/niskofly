<?php
$arUrlRewrite=array (
  2 => 
  array (
    'CONDITION' => '#^/personal/order/detail/([\\.\\-0-_9a-zA-Z]+)/#',
    'RULE' => 'ORDER_ID=$1',
    'ID' => 'bitrix:sale.personal.order.detail',
    'PATH' => '/personal/order/detail/index.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^/personal/order/cancel/([\\.\\-0-_9a-zA-Z]+)/#',
    'RULE' => 'ORDER_ID=$1',
    'ID' => 'bitrix:sale.personal.order.cancel',
    'PATH' => '/personal/order/cancel/index.php',
    'SORT' => 100,
  ),
  8 => 
  array (
    'CONDITION' => '#^/selections/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/selections/index.php',
    'SORT' => 100,
  ),
  5 => 
  array (
    'CONDITION' => '#^/catalog/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/catalog/index.php',
    'SORT' => 100,
  ),
  7 => 
  array (
    'CONDITION' => '#^/promo/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/promo/index.php',
    'SORT' => 100,
  ),
);
