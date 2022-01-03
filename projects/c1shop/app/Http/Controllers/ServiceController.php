<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends MainController
{
    public function index(Request $request){
        $this->seoParams['title'] = 'Сервис | Компания «Вектор»';
        $this->seoParams['description'] = '«Вектор» - это поставка, монтаж, пуско-наладочные работы, обучение персонала, а также обслуживание прачечного оборудования ведущего мирового и отечественного лидера для организации бесперебойной работы прачечных и химчисток.';
        parent::index($request);

        return view('pages/service', ['title' => 'Страница']);
    }
}
