<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceGarantController extends MainController
{
    public function index(Request $request){

        $this->seoParams['title'] = 'Сервисная служба: гарантийное обслуживание и ремонт прачечного оборудования';
        $this->seoParams['description'] = '«Вектор» осуществляет техническое обслуживание, сервис и ремонт промышленного прачечного оборудования и профессиональных стиральных машин торговых марок Lavamac, Primus, MayTag, Вязьма. ';
        parent::index($request);

        return view('pages/servisnoe-garant', ['title' => 'Страница']);
    }
}
