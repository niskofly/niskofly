<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\FundamentalSetting;
use App\Models\Part;
use App\Models\Product;
use App\Models\ReadyMadeProject;
use App\Models\Share;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendEmailPrice(Request $request)
    {

        $data['comment'] = '';
        $data['name'] = '';
        $data['email'] = '';

        foreach ($request->all() as $key => $postParameter) {
            $data[$key] = $postParameter;
        }

        $data['type'] = 'price';
        $this->theme = 'Подбор комплекта оборудования';
        $this->saveEmailDB($data);

        Mail::send('emails.getPrice', ['data' => $data], function ($m) use ($data) {
            $senderEmail = FundamentalSetting::GetSetting('email_send_email');
            $from_email = array_key_exists('email', $data) ? $data['email'] : $senderEmail->value;
            $m->from($from_email, $from_email);
            $m->to($senderEmail->value)->subject('Сообщение с формы - Подберем для Вас комплект оборудования и отправим прайс-лист');
        });
    }

    public function sendEmailProductConsultation(Request $request)
    {
        foreach ($request->all() as $key => $postParameter) {
            $data[$key] = $postParameter;
        }
        
        $data['type'] = 'product_consultation';
        $this->theme = 'Нужна консультация';
        $this->saveEmailDB($data);

        Mail::send('emails.product-consultation', ['data' => $data], function ($m) use ($data) {
            $sender_email = FundamentalSetting::GetSetting('email_send_email')->value;
            $m->from($sender_email, $sender_email);
            $m->to($sender_email)->subject('Сообщение с формы - Нужна консультация?');
        });
    }

    public function sendEmailCallback(Request $request)
    {
        $data['comment'] = '';

        foreach ($request->all() as $key => $postParameter) {
            $data[$key] = $postParameter;
        }

        $data['type'] = 'callback';
        $this->theme = 'Заказ обратного звонка';
        $this->saveEmailDB($data);

        Mail::send('emails.callback', ['data' => $data], function ($m) use ($data) {
            $senderEmail = FundamentalSetting::GetSetting('email_send_email');
            $from_email = array_key_exists('email', $data) ? $data['email'] : $senderEmail->value;
            $m->from($from_email, $from_email);
            $m->to($senderEmail->value)->subject('Сообщение с формы - Заказ обратного звонка');
        });
    }


    public function sendEmailRequestCardProduct(Request $request)
    {
        $data['comment'] = '';
        foreach ($request->all() as $key => $postParameter) {
            $data[$key] = $postParameter;
        }
        $data['info_product'] = Product::GetProductToID($data['product-id']);

        $data['type'] = 'product';
        $this->theme = 'Заявка на оборудование';
        $this->saveEmailDB($data);

        Mail::send('emails.productCard', ['data' => $data], function ($m) use ($data) {
            $senderEmail = FundamentalSetting::GetSetting('email_send_email');
            $from_email = array_key_exists('email', $data) ? $data['email'] : $senderEmail->value;
            $m->from($from_email, $from_email);
            $m->to($senderEmail->value)->subject('Сообщение с формы - Заявка на оборудование');
        });
    }

    public function sendEmailRequestCardPart(Request $request)
    {
        $data['comment'] = '';
        foreach ($request->all() as $key => $postParameter) {
            $data[$key] = $postParameter;
        }
        $data['info_product'] = Part::GetPartToID($data['part-id']);

        $data['type'] = 'part';
        $this->theme = 'Заявка на запчасть';
        $this->saveEmailDB($data);
        Mail::send('emails.partCard', ['data' => $data], function ($m) use ($data) {
            $senderEmail = FundamentalSetting::GetSetting('email_send_email');
            $from_email = array_key_exists('email', $data) ? $data['email'] : $senderEmail->value;
            $m->from($from_email, $from_email);
            $m->to($senderEmail->value)->subject('Сообщение с формы - Заявка на запчасть');
        });
    }


    public function sendEmailReadyMadeProject(Request $request)
    {
        $data['comment'] = '';
        foreach ($request->all() as $key => $postParameter) {
            $data[$key] = $postParameter;
        }
        $data['info_project'] = ReadyMadeProject::GetByID($data['id-projects']);

        $data['type'] = 'project';
        $this->theme = 'Заявка на готовый комплект';
        $this->saveEmailDB($data);

        Mail::send('emails.readyMadeProject', ['data' => $data], function ($m) use ($data) {
            $senderEmail = FundamentalSetting::GetSetting('email_send_email');
            $from_email = array_key_exists('email', $data) ? $data['email'] : $senderEmail->value;
            $m->from($from_email, $from_email);
            $m->to($senderEmail->value)->subject('Сообщение с формы - Заявка на готовый комплект');
        });
    }

    public function sendEmailServiceGuarantee(Request $request)
    {
        $data['comment'] = '';
        $data['name'] = '';
        $data['email'] = '';

        foreach ($request->all() as $key => $postParameter) {
            $data[$key] = $postParameter;
        }

        $data['type'] = 'serviceGuarantee';
        $this->theme = 'Сервисное и гарантийное обслуживание';
        $this->saveEmailDB($data);

        Mail::send('emails.getPrice', ['data' => $data], function ($m) use ($data) {
            $senderEmail = FundamentalSetting::GetSetting('email_send_email');
            $from_email = array_key_exists('email', $data) ? $data['email'] : $senderEmail->value;
            $m->from($from_email, $from_email);
            $m->to($senderEmail->value)->subject('Сообщение со страницы - Сервисное и гарантийное обслуживание');
        });
    }

    public function sendEmailzapchasti(Request $request)
    {
        $data['name'] = '';
        $data['email'] = '';
        $data['phone'] = '';
        $data['naimenovanie-zapchasti'] = '';
        $data['nomer-kataloga'] = '';
        $data['comment-zapchasti'] = '';

        foreach ($request->all() as $key => $postParameter) {
            $data[$key] = $postParameter;
        }

        $data['type'] = 'zapchasti';
        $this->theme = 'Заказ запчастей';
        $this->saveEmailDB($data);

        //dd($data);

        Mail::send('emails.zapchasti', ['data' => $data], function ($m) use ($data) {
            $senderEmail = FundamentalSetting::GetSetting('email_send_email');
            $from_email = array_key_exists('email', $data) ? $data['email'] : $senderEmail->value;
            $m->from($from_email, $from_email);
            $m->to($senderEmail->value)->subject('Сообщение со страницы - Заказа запчастей');
        });
    }

    public function sendEmailShare(Request $request)
    {
        $data['comment'] = '';
        foreach ($request->all() as $key => $postParameter) {
            $data[$key] = $postParameter;
        }
        $data['info_share'] = Share::GetShareToID($data['share-id']);

        $data['type'] = 'share';
        $this->theme = 'Заявка на акцию';
        $this->saveEmailDB($data);

        Mail::send('emails.share', ['data' => $data], function ($m) use ($data) {
            $senderEmail = FundamentalSetting::GetSetting('email_send_email');
            $from_email = array_key_exists('email', $data) ? $data['email'] : $senderEmail->value;
            $m->from($from_email, $from_email);
            $m->to($senderEmail->value)->subject('Сообщение с формы - Заявка на акцию');
        });
    }

    public function sendEmailBasket(Request $request)
    {
        $data['comment'] = '';
        $data['phone'] = '';
        $data['email'] = '';

        foreach ($request->all() as $key => $postParameter) {
            $data[$key] = $postParameter;
        }

        $uploadedProductIDs = '';
        $uploadedPartIDs = '';

        if (isset($_COOKIE["js-list-products"])) {
            $uploadedProductIDs = explode('-', $_COOKIE["js-list-products"]);
            $db_products = Product::GetProductsByIDs($uploadedProductIDs);
            $products = [];
            if (!$db_products->isEmpty()) {
                foreach ($uploadedProductIDs as $id) {
                    $product = $db_products->first(function ($item, $key) use ($id) {
                        return $item->id == $id;
                    });
                    $products[] = $product;
                }
            }
            $data['products'] = $products;
        }

        if (isset($_COOKIE["js-list-parts"])) {
            $uploadedPartIDs = explode('-', $_COOKIE["js-list-parts"]);
            $db_products = Part::GetPartsByIDs($uploadedPartIDs);
            $products = [];
            if (!$db_products->isEmpty()) {
                foreach ($uploadedPartIDs as $id) {
                    $product = $db_products->first(function ($item, $key) use ($id) {
                        return $item->id == $id;
                    });
                    $products[] = $product;
                }
            }
            $data['parts'] = $products;
        }

        $data['type'] = 'product';
        $this->theme = 'Заявка на оборудование';
        $this->saveEmailDB($data);


        Mail::send('emails.sendBasket', ['data' => $data], function ($m) use ($data) {
            $senderEmail = FundamentalSetting::GetSetting('email_send_email');
            $from_email = array_key_exists('email', $data) ? $data['email'] : $senderEmail->value;
            $m->from($from_email, $from_email);
            $m->to($senderEmail->value)->subject('Сообщение - Заявка на оборудование');
        });
    }


    public function sendEmailRaschjotKomplektacii(Request $request)
    {

        $data['ves-belja-opredelennyj-period'] = '';
        $data['ves-belja-prjamoe'] = '';
        $data['ves-belja-fasonnoe'] = '';
        $data['ves-belja-mахровое'] = '';
        $data['ves-belja-uteplennaja-specodezhda'] = '';
        $data['ves-belja-drugoe'] = '';
        $data['maksimalnye-razmery-prjamogo'] = '';
        $data['vid-zagrjaznenija'] = '';
        $data['kolichestvo-rabochih-dnej'] = '';
        $data['vid-nagreva'] = '';
        $data['square-laundry'] = '';
        $data['dopolnitelnye-svedenija'] = '';
        $data['planiruemyj-rezhim-raboty'] = '';


        foreach ($request->all() as $key => $postParameter) {
            $data[$key] = $postParameter;
        }

        $data['type'] = 'calculateKit';
        $this->theme = 'Расчёт комплектации оборудования';
        $this->saveEmailDB($data);

        Mail::send('emails.raschjotKomplektacii', ['data' => $data], function ($m) use ($data) {
            $senderEmail = FundamentalSetting::GetSetting('email_send_email');
            $from_email = array_key_exists('email', $data) ? $data['email'] : $senderEmail->value;
            $m->from($from_email, $from_email);
            $m->to($senderEmail->value)->subject('Сообщение с формы - Расчёт комплектации оборудования');
        });
    }


    public function saveEmailDB($data)
    {
        $email = new Email;
        $email->name = isset($data['name']) ? $data['name'] : '';
        $email->comment = isset($data['comment']) ? $data['comment'] : '';
        $email->email = isset($data['email']) ? $data['email'] : '';
        $email->phone = isset($data['phone']) ? $data['phone'] : '';
        $email->type = isset($data['type']) ? $data['type'] : '';
        $email->theme = $this->theme;

        $email->id_product = isset($data['product-id']) ? $data['product-id'] : NULL;

        $email->id_finished_project = isset($data['id-projects']) ? $data['id-projects'] : NULL;

        $email->id_share = isset($data['share-id']) ? $data['share-id'] : NULL;


        if (isset($data['products'])) {
            foreach ($data['products'] as $key => $product) {
                $arIdProducts[$key] = $product->id;
            }
            $email->id_product_list = serialize($arIdProducts);
        }

        if (isset($data['parts'])) {
            foreach ($data['parts'] as $key => $part) {
                $arIdParts[$key] = $part->id;
            }
            $email->id_part_list = serialize($arIdParts);
        }
        
        if (isset($data['naimenovanie-zapchasti']) || isset($data['nomer-kataloga']) || isset($data['comment-zapchasti'])) {

            foreach ($data['naimenovanie-zapchasti'] as $key => $item) {
                $arSpareList[$key]['name'] = $data['naimenovanie-zapchasti'][$key];
                $arSpareList[$key]['number_catalog'] = $data['nomer-kataloga'][$key];
                $arSpareList[$key]['comment'] = $data['comment-zapchasti'][$key];
            }

            $email->spare_part_list = serialize($arSpareList);

        }

        if ($data['type'] == 'calculateKit') {

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

            foreach ($data as $key => $param) {
                if (array_key_exists($key, $nameParams)) {
                    $arParamKit[$nameParams[$key]] = $param;
                }
            }
            $email->calculate_kit_params = serialize($arParamKit);

        }


        $email->save();
    }


}
