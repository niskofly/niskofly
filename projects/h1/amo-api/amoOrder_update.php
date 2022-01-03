<?php
//die(var_dump('TEST'));
$subdomain = 'headin';

/* Следующий запрос вернёт список сделок, у которых есть $id */
$link = 'https://' . $subdomain . '.amocrm.ru/api/v2/leads?query=' . $id;

/* Нам необходимо инициировать запрос к серверу. Воспользуемся библиотекой cURL (поставляется в составе PHP). Подробнее о
работе с этой
библиотекой Вы можете прочитать в мануале. */
$curl = curl_init();

/* Устанавливаем необходимые опции для сеанса cURL */
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
curl_setopt($curl, CURLOPT_URL, $link);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

/* Выполняем запрос к серверу. */
$out = curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
$result = json_decode($out, true);
//var_dump($result);

/*var_dump($result);
var_dump($id);
die;*/

foreach ($result['_embedded']['items'] as $item) {
    foreach ($item['custom_fields'] as $fld) {
        if ($fld['id'] == 486297) {
            foreach ($fld['values'] as $v) {
                if ($v['value'] == $id) {
                    if ($id) {
                        $order['id'] = $item['id'];
                    } else {
                        echo('Ошибка');
                        die();
                    }
                }
            }
        }
    }
}

$code = (int)$code;
$errors = array(
    301 => 'Moved permanently',
    400 => 'Bad request',
    401 => 'Unauthorized',
    403 => 'Forbidden',
    404 => 'Not found',
    500 => 'Internal server error',
    502 => 'Bad gateway',
    503 => 'Service unavailable',
);

try {
    /* Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке */
    if ($code != 200 && $code != 204) {
        throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error', $code);
    }
} catch (Exception $E) {
    die('Ошибка: ' . $E->getMessage() . PHP_EOL . 'Код ошибки: ' . $E->getCode());
}

/* Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
/*
Данные получаем в формате JSON, поэтому, для получения читаемых данных,
нам придётся перевести ответ в формат, понятный PHP
*/
$Response = json_decode($out, true);
//die(var_dump($Response));
$Response = $Response['_embedded']['items'];