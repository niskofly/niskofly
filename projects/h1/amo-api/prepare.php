<?php
function CheckCurlResponse($code)
{
	$code=(int)$code;
	$errors=array(
		301=>'Moved permanently',
		400=>'Bad request',
		401=>'Unauthorized',
		403=>'Forbidden',
		404=>'Not found',
		500=>'Internal server error',
		502=>'Bad gateway',
		503=>'Service unavailable'
	);
	try
	{
		#Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
		if($code!=200 && $code!=204)
			throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error',$code);
	}
	catch(Exception $E)
	{
		//die('Ошибка: '.$E->getMessage().PHP_EOL.'Код ошибки: '.$E->getCode());
	}
}






/*if( isset($_POST['order_data'])){

    $spareList = 'Заказ : '.chr(13).chr(10);
    foreach ($_POST['order_data'] as $key => $item) {
        $arSpareList[$key]['name'] = $item['name'];
        $arSpareList[$key]['sum'] = $item['sum'];
        $arSpareList[$key]['count'] = $item['count'];

        $spareList .= 'Наименование: ' .$arSpareList[$key]['name'].chr(13).chr(10)
			.' цена: '.$arSpareList[$key]['sum'].chr(13).chr(10)
            .' количество: '.$arSpareList[$key]['count'].chr(13).chr(10).chr(13).chr(10);

    }
}*/


if (isset($model->course)){
	$course = $model->course;
}else{
	$course = 'Не указан';
}
if (isset($model->group) && isset($model->course)){
	$course = $model->course.' | '. $model->group;
}

$data=array(
	'name'=>isset($model->name) ? $model->name : (isset($model->name) ? $model->name : 'Не указан'),
	'phone'=>isset($model->phone) ? preg_replace("/[^+0-9]/", '', $model->phone) : 'Не указан',
	'email'=>isset($model->email) ? $model->email : 'Не указан',
    'message'=>isset($model->message) ? $model->message : 'Не указан',
	'course'=>$course,
	'promocode'=>$model->promocode,
    /*'order_data' => isset($_POST['order_data']) ? $_POST['order_data'] : '',*/
);



#Если не указано имя или e-mail контакта - уведомляем
if(empty($data['name']))
	die('Не заполнено имя контакта');
if(empty($data['email']))
	die('Не заполнен E-mail контакта');
?>
