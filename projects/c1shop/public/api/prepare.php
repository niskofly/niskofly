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
		die('Ошибка: '.$E->getMessage().PHP_EOL.'Код ошибки: '.$E->getCode());
	}
}



$nameParams = [
    'ves-belja-opredelennyj-period' => ' Вес белья обрабатываемого за определенный период',
    'ves-belja-prjamoe' => 'Прямое (простыни, пододеяльники, наволочки)',
    'ves-belja-fasonnoe' => 'Фасонное (спецодежда, халаты, рубашки и т.д.)',
    'ves-belja-mахровое' => 'Махровое (полотенца, халаты)',
    'ves-belja-uteplennaja-specodezhda' => 'Утепленная спецодежда',
    'maksimalnye-razmery-prjamogo' => ' Максимальные размеры прямого белья (ширина, длина)',
    'vid-zagrjaznenija' => 'Вид загрязнения',
    'planiruemyj-rezhim-raboty' => 'Планируемый режим работы прачечной',
    'kolichestvo-rabochih-dnej' => 'Количество рабочих дней в месяце',
    'vid-nagreva' => 'Вид нагрева',
    'square-laundry' => 'Площадь в прачечной',
    'dopolnitelnye-svedenija' => 'Дополнительные сведения или пожелания',
];

$dataParams['ves-belja-opredelennyj-period'] = '';
$dataParams['ves-belja-prjamoe'] = '';
$dataParams['ves-belja-fasonnoe'] = '';
$dataParams['ves-belja-mахровое'] = '';
$dataParams['ves-belja-uteplennaja-specodezhda'] = '';
$dataParams['ves-belja-drugoe'] = '';
$dataParams['maksimalnye-razmery-prjamogo'] = '';
$dataParams['vid-zagrjaznenija'] = '';
$dataParams['kolichestvo-rabochih-dnej'] = '';
$dataParams['vid-nagreva'] = '';
$dataParams['square-laundry'] = '';
$dataParams['dopolnitelnye-svedenija'] = '';
$dataParams['planiruemyj-rezhim-raboty'] = '';

$ParamsRezult = '';
foreach ($_POST as $key => $postParameter){
    $dataParams[$key] = $postParameter;
}

foreach ($nameParams as $key => $name){
	foreach ($dataParams as $keyData => $value){
		if($key == $keyData){
            $ParamsRezult .= $name . ':' . $value.', '.chr(13).chr(10);
		}
	}
}


if( isset($_POST['naimenovanie-zapchasti']) || isset($_POST['nomer-kataloga']) || isset($_POST['comment-zapchasti']) ) {

    $spareList = 'Запчасти: '.chr(13).chr(10);
    foreach ($_POST['naimenovanie-zapchasti'] as $key => $item) {
        $arSpareList[$key]['name'] = $_POST['naimenovanie-zapchasti'][$key];
        $arSpareList[$key]['number_catalog'] = $_POST['nomer-kataloga'][$key];
        $arSpareList[$key]['comment'] = $_POST['comment-zapchasti'][$key];

        $spareList .= 'Наименование: ' .$arSpareList[$key]['name'].chr(13).chr(10)
			.' номер в каталоге: '.$arSpareList[$key]['number_catalog'].chr(13).chr(10)
            .' коментарий: '.$arSpareList[$key]['comment'].chr(13).chr(10);

    }
}

$data=array(
	/*'name'=>isset($_POST['name']) ? $_POST['name'] : 'Не указан',
	'company'=>isset($_POST['company']) ? $_POST['company'] : '',
	'position'=>isset($_POST['position']) ? $_POST['position'] : '',*/
	'name'=>isset($_POST['name']) ? $_POST['name'] : (isset($_POST['email']) ? $_POST['email'] : 'Не указан'),
	'phone'=>isset($_POST['phone']) ? $_POST['phone'] : '',
	'email'=>isset($_POST['email']) ? $_POST['email'] : 'Не указан',
    'message'=>isset($_POST['comment']) ? $_POST['comment'] : 'Не указан',
    'city'=>isset($_POST['city']) ? $_POST['city'] : 'Не указан',
    'tags'=>isset($_POST['tags']) ? $_POST['tags'] : '',

	'product' =>isset($_POST['product']) ? $_POST['product'] : '',
	'part' =>isset($_POST['part']) ? $_POST['part'] : '',

    'utm_source'=>isset($_POST['utm_source']) ? $_POST['utm_source'] : '',
    'utm_campaign'=>isset($_POST['utm_campaign']) ? $_POST['utm_campaign'] : '',
    'utm_content'=>isset($_POST['utm_content']) ? $_POST['utm_content'] : '',
    'utm_term'=>isset($_POST['utm_term']) ? $_POST['utm_term'] : '',


	/*'web'=>isset($_POST['web']) ? $_POST['web'] : '',*/
	/*'jabber'=>isset($_POST['jabber']) ? $_POST['jabber'] : '',*/

	/*'country'=>isset($_POST['country']) ? $_POST['country'] : '',
    'USD'=>isset($_POST['USD']) ? $_POST['USD'] : '0',*/
);
/*
if(isset($_POST['tags']) && $_POST['tags'] == 'Заявка на комплект'){
    $data['message'] = $data['message'] . ' Данные из формы:' . $ParamsRezult;
}

if(isset($_POST['tags']) && $_POST['tags'] == 'Заявка на запчасти'){
    $data['message'] = $data['message'] . ' Данные из формы:' . $spareList;
}*/


#Если не указано имя или e-mail контакта - уведомляем
/*if(empty($data['name']))
	die('Не заполнено имя контакта');
if(empty($data['email']))
	die('Не заполнен E-mail контакта');*/
?>
