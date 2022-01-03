<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Product;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Illuminate\Http\Request;

class MainController extends Controller
{
    use SEOToolsTrait;

    public function index(Request $request)
    {
        $currentURL = \URL::current();

        $seoParams = $this->seoParams;
        $domainParent = 'https://www.laundrypro.ru/';
        
        if (isset($seoParams['title'])) {
            $this->seo()->setTitle(Helper::escapingQuotes($seoParams['title']));
        }
        if (isset($seoParams['description'])) {
            $this->seo()->setDescription(Helper::escapingQuotes($seoParams['description']));
        }

        if (isset($seoParams['image'])) {
            $this->seo()->opengraph()->addImage($domainParent . $seoParams['image']);
            $this->seo()->twitter()->addImage($domainParent . $seoParams['image']);
        } else {
            $this->seo()->opengraph()->addImage('https://www.laundrypro.ru/img/logo.png');
        }

        if (isset($seoParams['canonical'])) {
            $this->seo()->setCanonical($seoParams['canonical']);
        } else {
            $this->seo()->setCanonical($currentURL);
        }

        $this->seo()->opengraph()->setUrl($currentURL);
        $this->seo()->twitter()->setUrl($currentURL);

    }

    protected $seoParams = [
        'title' => "TITLE"
    ];

    public function privacy_policy_page()
    {
        $currentURL = \URL::current();

        $seoParams['title'] = "Политика конфиденциальности | Вектор";
        $seoParams['description'] = "Политика конфиденциальности персональных данных действует в отношении всей информации, которую Интернет-магазин «Вектор», расположенный на доменном имени www.laundrypro.ru, может получить о Пользователе.";
        $domainParent = 'https://www.laundrypro.ru/';

        if (isset($seoParams['title'])) {
            $this->seo()->setTitle(Helper::escapingQuotes($seoParams['title']));
        }

        if (isset($seoParams['description'])) {
            $this->seo()->setDescription(Helper::escapingQuotes($seoParams['description']));
        }

        if (isset($seoParams['image'])) {
            $this->seo()->opengraph()->addImage($domainParent . $seoParams['image']);
            $this->seo()->twitter()->addImage($domainParent . $seoParams['image']);
        }

        $this->seo()->opengraph()->setUrl($currentURL);
        $this->seo()->twitter()->setUrl($currentURL);

        return view('pages.privacy-policy');
    }

    public function payment_delivery_page()
    {
        $currentURL = \URL::current();

        $seoParams['title'] = "Оплата и доставка прачечного оборудования  | Вектор";
        $seoParams['description'] = "Оплата и доставка прачечного оборудования. Товар отгружается в течение 7 рабочих дней при наличие на складе. Способы оплаты: безналичный расчет (по счету, Договору поставки).";
        $domainParent = 'https://www.laundrypro.ru/';

        if (isset($seoParams['title'])) {
            $this->seo()->setTitle(Helper::escapingQuotes($seoParams['title']));
        }

        if (isset($seoParams['description'])) {
            $this->seo()->setDescription(Helper::escapingQuotes($seoParams['description']));
        }

        if (isset($seoParams['image'])) {
            $this->seo()->opengraph()->addImage($domainParent . $seoParams['image']);
            $this->seo()->twitter()->addImage($domainParent . $seoParams['image']);
        }

        $this->seo()->opengraph()->setUrl($currentURL);
        $this->seo()->twitter()->setUrl($currentURL);

        return view('pages.payment_delivery');
    }

    public function vozvrat_tovara_page()
    {
        $currentURL = \URL::current();

        $seoParams['title'] = " Правила обмена, возврата товара | Вектор";
        $seoParams['description'] = "Возврат товара надлежащего и ненадлежащего качества или денежных средств осуществляется в рамках заключенного двустороннего договора. | Вектор";
        $domainParent = 'https://www.laundrypro.ru/';

        if (isset($seoParams['title'])) {
            $this->seo()->setTitle(Helper::escapingQuotes($seoParams['title']));
        }

        if (isset($seoParams['description'])) {
            $this->seo()->setDescription(Helper::escapingQuotes($seoParams['description']));
        }

        if (isset($seoParams['image'])) {
            $this->seo()->opengraph()->addImage($domainParent . $seoParams['image']);
            $this->seo()->twitter()->addImage($domainParent . $seoParams['image']);
        }

        $this->seo()->opengraph()->setUrl($currentURL);
        $this->seo()->twitter()->setUrl($currentURL);

        return view('pages.vozvrat-tovara');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return bool|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function getFile(Request $request)
    {
        $product = new Product();
        $file = $product->parseFilename($request->path());
        return $product->downloadFile($file);
    }
}
