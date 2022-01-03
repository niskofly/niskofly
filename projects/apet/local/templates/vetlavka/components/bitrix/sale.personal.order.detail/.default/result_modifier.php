<?php

$renderProps = [
  'FIO' => null,
  'EMAIL' => null,
  'PHONE' => null,
  'ADDRESS' => null
];

foreach ($arResult['ORDER_PROPS'] as $key => $prop) {
  $arResult['ORDER_PROPS'][$prop['CODE']] = $prop;

  if (array_key_exists($prop['CODE'], $renderProps) && $prop['VALUE']) {
    $arRenderProps[$prop['CODE']] = [
      'NAME' => $prop['NAME'],
      'VALUE' => $prop['VALUE']
    ];
  }
  unset($arResult['ORDER_PROPS'][$key]);
}
$arResult['RENDER_PROPS'] = array_filter($renderProps);
