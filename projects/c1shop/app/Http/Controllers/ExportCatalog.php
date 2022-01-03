<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Class ExportCatalog
 *
 * @package App\Http\Controllers
 */
class ExportCatalog extends Controller
{

    /**
     * Экспорт в товаров и каталогов в YML файл.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function yml(Request $request)
    {
        ini_set('memory_limit', '256M');
        set_time_limit(0);

        // категории
        $categories = Categorie::orderBy('created_at', 'asc')->get();

        // товары
        $products = Product::FilterToYml()->get();

        $contents = View::make('pages/yml', [
            'categories' => $categories,
            'products' => $products
        ]);
        $response = Response::make($contents, 200);
        $response->header('Content-Type', 'text/xml');
        return $response;
    }

    /**
     * Экспорт в товаров и каталогов в YML файл (для Турбо-страниц).
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function turboYml(Request $request)
    {
        ini_set('memory_limit', '256M');
        set_time_limit(0);

        // категории
        $categories = Categorie::orderBy('created_at', 'asc')->get();

        // товары
        $products = Product::FilterTurboToYml()->get();

        $contents = View::make('pages/yml', [
            'categories' => $categories,
            'products' => $products
        ]);
        $response = Response::make($contents, 200);
        $response->header('Content-Type', 'text/xml');
        return $response;
    }

    /**
     * Экспорт в XML-файл для Google Merchant.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function google_merchant(Request $request)
    {
        ini_set('memory_limit', '256M');
        set_time_limit(0);

        // категории
        $categories = Categorie::orderBy('created_at', 'asc')->get();

        // товары
        $products = Product::FilterToYml()->get();

        $contents = View::make('pages/google-merchant', [
            'categories' => $categories,
            'products' => $products
        ]);
        $response = Response::make($contents, 200);
        $response->header('Content-Type', 'text/xml');
        return $response;
    }

    /**
     * Импорт новых городов.
     */
    public function importCities()
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/cities.csv';
        $fileData = array_map('str_getcsv', file($path));
        $importData = [];
        foreach ($fileData as $key => $row) {
            if ($key == 0)
                continue;

            $str = iconv("windows-1251", "UTF-8", $row[0]);
            $data = explode(';', $str);

            if (trim($data[0])) {
                $importData[] = [
                    'name' => $data[0],
                    'code' => $data[1],
                    'seo_part' => $data[2],
                ];
            }
        }
        foreach ($importData as $item) {
            DB::table('cities')
                ->updateOrInsert(
                    ['name' => $item['name']],
                    [
                        'name' => $item['name'],
                        'code' => $item['code'],
                        'seo_part' => $item['seo_part'],
                        'published' => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]
                );
        }
    }

    /**
     * Импорт новых контактов.
     */
    public function importContacts()
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/contacts.csv';

        $importData = [];
        foreach (file($path) as $key => $line) {
            if ($key == 0)
                continue;

            $data = explode(';', $line);
            //$coordinate = $this->getCoordinatesAtAddress($data[2]);
            if (trim($data[0])) {
                $importData[] = [
                    'city' => $data[0],
                    'address' => $data[2],
                    'phone_text' => '<span>Тел.: <a href="tel:' . $data[4] . '">' . $data[4] . '</a></span>',
                    'email' => $data[5],
                    'time' => $data[6],
                    //'coordinates' => $coordinate,
                    'transport_company' => $data[3],
                ];
            }
        }
        foreach ($importData as $item) {
            DB::table('contacts')
                ->updateOrInsert(
                    ['city' => $item['city']],
                    [
                        'city' => $item['city'],
                        'address' => $item['address'],
                        'phone_text' => $item['phone_text'],
                        'email' => $item['email'],
                        'time' => $item['time'],
                        //'coordinates' => $item['coordinates'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'transport_company' => $item['transport_company'],
                        'published' => 1,
                    ]
                );
        }
    }

    /**
     * Получение координат по адресу.
     *
     * @param $address
     * @return null|string
     */
    public function getCoordinatesAtAddress($address)
    {
        $coordinate = null;
        $response = json_decode($this->curl_get('https://geocode-maps.yandex.ru/1.x/', [
            'geocode' => $address,
            'apikey' => '48984c1c-84fc-4839-ab7c-21ee923cf9d5',
            'format' => 'json',
            'results' => 1
        ]), true);

        $response = array_key_exists('response', $response) ? $response['response'] : null;

        if ($response && $response['GeoObjectCollection']['metaDataProperty']['GeocoderResponseMetaData']['found'] > 0) {
            $response_coordinate = current($response['GeoObjectCollection']['featureMember']);
            $response_coordinate = $response_coordinate["GeoObject"]["Point"]["pos"];
            if ($response_coordinate) {
                /**
                 * Координаты нужно перевернуть. По стандарту они записаны наоборот
                 */
                $response_coordinate = array_reverse(explode(' ', $response_coordinate));
                if (count($response_coordinate) == 2) {
                    $coordinate = [$response_coordinate[0], $response_coordinate[1]];
                }
            }
        }

        return $coordinate ? implode(', ', $coordinate) : null;
    }

    /**
     * Обработчик GET-запросов на внешние сервисы.
     *
     * @param $url
     * @param array|NULL $get
     * @param array $options
     * @return mixed
     */
    protected function curl_get($url, array $get = NULL, array $options = array())
    {
        try {
            $defaults = array(
                CURLOPT_URL => $url . (strpos($url, "?") === FALSE ? "?" : "") . http_build_query($get),
                CURLOPT_HEADER => 0,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            );
            $ch = curl_init();
            curl_setopt_array($ch, ($options + $defaults));
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            if (!$result = curl_exec($ch)) {
                throw new \Exception(curl_error($ch), curl_errno($ch));
            }
            curl_close($ch);
            return $result;
        } catch (\Exception $e) {
            trigger_error(sprintf(
                'Curl failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),
                E_USER_ERROR);

        }
    }

    /**
     * Экспорт в товаров и каталогов в YML файл только некоторых.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function ymlForCategoriesSeveral(Request $request)
    {
        ini_set('memory_limit', '256M');
        set_time_limit(0);

        // категории
        $categories = Categorie::wherein('id' , [1,2,3])

            ->orderBy('created_at', 'asc')->get();

        // товары
        $products = Product::FilterToYmlForCategoriesSeveral()->get();

        $contents = View::make('pages/yml', [
            'categories' => $categories,
            'products' => $products
        ]);
        $response = Response::make($contents, 200);
        $response->header('Content-Type', 'text/xml');
        return $response;
    }

}
