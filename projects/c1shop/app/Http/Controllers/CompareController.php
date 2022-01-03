<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Part;
use App\Models\Product;
use Illuminate\Http\Request;

class CompareController extends MainController
{
    protected $uploadedCompare = [];
    protected $uploadedCompareIDs = false;

    public function index(Request $request){

        $this->seoParams['title'] = 'Сравнение товаров | Компания «Вектор»';
        $this->seoParams['description'] = 'Отобранные товары и оборудование для покупки в компании «Вектор»';

        parent::index($request);

        if (isset($_COOKIE["js-list-compare"])){
            $this->uploadedCompareIDs = explode('-', $_COOKIE["js-list-compare"]);
        }

        $renderProducts = [];

        if ($this->uploadedCompareIDs) {
            $this->GetUploadedProducts();
        }

        $categories = Categorie::select('id', 'name')->get()->toArray();

        if (!empty($this->uploadedCompare)) {
            foreach($this->uploadedCompareIDs as $id){
                $product = $this->uploadedCompare->first(function ($item, $key) use($id) {
                    return $item->id == $id;
                });
                $product->description = '';
                $product->params = unserialize( $product->params);
                $renderProducts[] = $product ;
            }
        }


        $renderCategories = [];
        foreach ($categories as $category){
            foreach ($renderProducts as $product){
                if ($category['id'] == $product['category']){
                    $isset_category = array_search($category['id'], array_column($renderCategories, 'id'));
                    if (false === $isset_category){
                        $renderCategories[] = $category;
                        $isset_category = array_search($category['id'], array_column($renderCategories, 'id'));
                        $renderCategories[$isset_category]['active'] = false;
                    }
                    $isset_category = array_search($category['id'], array_column($renderCategories, 'id'));
                    $renderCategories[$isset_category]['products'][] = $product;
                }
            }
        }
        return view('pages/compare', [
            'Categories' => json_encode($renderCategories,true),
        ]);
    }

    public function GetUploadedProducts(){

        if ($this->uploadedCompareIDs){
            $this->uploadedCompare = Product::GetProductsByIDs($this->uploadedCompareIDs);
        }
    }
}
