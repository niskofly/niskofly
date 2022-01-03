<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutCompanyController extends MainController
{
    public function index(Request $request){

        $this->seoParams['title'] = 'О компании «Вектор»';
        $this->seoParams['description'] = 'Компания ООО «Вектор» является официальным дистрибьютором промышленного оборудования для прачечных торговой марки Lavamac (Бельгия) и прачечного оборудования «Вязьма».';
        parent::index($request);

        return view('pages/o-kompanii', ['title' => 'Страница']);
    }
}
