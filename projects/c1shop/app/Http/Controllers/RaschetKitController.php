<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RaschetKitController extends MainController
{
    public function index(Request $request){

        $this->seoParams['title'] = 'Расчёт комплектации прачечного оборудования | Компания «Вектор»';
        $this->seoParams['description'] = 'Специалисты нашей компании подготовят рабочий технологический проект прачечной и химчистки, произведут компьютерную расстановку оборудования на плане помещений Вашего предприятия.';
        parent::index($request);


        return view('pages/raschjot-komplektacii', ['title' => 'Страница']);
    }
}
