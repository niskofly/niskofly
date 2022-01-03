<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class Contacts extends MainController
{
    public function index(Request $request){
        $HeadOffice = Contact::headOffice()->get()->first();
        $Branches = Contact::branches()->get();
        $Pickpoints = Contact::pickpoints()->get();

        $this->seoParams['title'] = 'Контакты | Компания «Вектор» ';
        $this->seoParams['description'] = 'Список филиалов компании «Вектор» в городах России. Контактная информация: адреса филиалов их график работы, телефон 8 (800) 333-58-45 - бесплатный звонок по РФ.';

        parent::index($request);

        return view('pages/contact', [
            'HeadOffice' => $HeadOffice,
            'Branches' =>  $Branches,
            'Pickpoints' => $Pickpoints,
            'title' => 'Контакты',
        ]);
    }
}
