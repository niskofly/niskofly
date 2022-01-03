<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends MainController
{
    private $arSearchProduct = [];
    private $SearchCategory;
    private $SearchQuery;

    public function index(Request $request)
    {
        $this->seoParams['title'] = 'Поиск | Компания «Вектор» ';
        $this->seoParams['description'] = 'Поиск | Компания «Вектор» ';

        parent::index($request);

        $categoris = Categorie::GetSearchCategory();
        $arParameterSearch['query'] = '';
        $arParameterSearch = $request->all();

        if(isset($arParameterSearch['category'])){
            $this->SearchCategory = Categorie::GetCategoryToUrl($arParameterSearch['category']);
        } else {
            $this->SearchCategory = 'Все категории';
        }

        $this->SearchQuery = urldecode($arParameterSearch['query']);

        $this->searchProduct();

        //dd($request->all() );
        return view('pages/search',
            [
                'Products' => $this->arSearchProduct,
                'categoris' => $categoris,
                'selectCategory' =>  $this->SearchCategory,
                'query' => urldecode($arParameterSearch['query'])
            ]);
    }

    private function searchProduct()
    {
        if(isset($this->SearchCategory->id)){
            $this->arSearchProduct = Product::GetAllToIdCategory($this->SearchCategory->id);
        } else {
            $this->arSearchProduct = Product::GetAllToIdCategory(4);
        }
        //$this->arSearchProduct = Product::SearchProduct($this->SearchQuery, $this->SearchCategory);
        $this->arSearchProduct = Product::LikeSearchProduct($this->SearchQuery, $this->SearchCategory);

    }
}
