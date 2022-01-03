<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class ZapchastiController extends MainController
{
    public function index(Request $request)
    {
        $id = 10; // id категории "Запчасти"
        $model = Categorie::where('id', $id)->first();

        $this->seoParams['title'] = $model->seo_title;
        $this->seoParams['description'] = $model->seo_description;

        parent::index($request);

        return view('pages/zapchasti', [
            'title' => $this->seoParams['title'],
            'category' => $model,
        ]);
    }
}
