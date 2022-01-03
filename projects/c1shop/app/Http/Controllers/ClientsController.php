<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientsController extends MainController
{
    public function index(Request $request){
        $this->seoParams['title'] = 'Наши клиенты | Компания «Вектор»';
        $this->seoParams['description'] = 'Нашими клиентами стали более 800 компаний по всей России. Ознакомиться с полным списком клинтов можно на сайте.';
        parent::index($request);

        return view('pages/clients', ['title' => 'Клиенты']);
    }
}
