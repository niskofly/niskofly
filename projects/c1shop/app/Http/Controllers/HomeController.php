<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends MainController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->seoParams['title'] = 'Прачечное оборудование для прачечных и химчисток — «Вектор»';
        $this->seoParams['description'] = 'Продажа автоматических стирально-отжимных и сушильных машин, гладильного и финишного оборудования, машин химчистки; снабжение запасными частями. Технические характеристики продукции. Заказ онлайн.';

        parent::index($request);

        return view('pages/home');
    }
}
