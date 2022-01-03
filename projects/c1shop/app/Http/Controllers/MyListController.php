<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\Product;
use Illuminate\Http\Request;

class MyListController extends MainController
{
    protected $uploadedProducts = [];
    protected $uploadedParts = [];
    protected $uploadedProductIDs = false;
    protected $uploadedPartIDs = false;

    public function index(Request $request){

        $this->seoParams['title'] = 'Моя корзина товаров и оборудования | Компания «Вектор»';
        $this->seoParams['description'] = 'Отобранные товары и оборудование для покупки в компании «Вектор»';

        parent::index($request);

        if (isset($_COOKIE["js-list-products"])){
            $this->uploadedProductIDs = explode('-', $_COOKIE["js-list-products"]);
        }
        if (isset($_COOKIE["js-list-parts"])){
            $this->uploadedPartIDs = explode('-', $_COOKIE["js-list-parts"]);
        }
        $renderProducts = [];

        if ($this->uploadedProductIDs || $this->uploadedPartIDs) {
            $this->GetUploadedProducts();
        }

        if (!empty($this->uploadedProducts)) {
            foreach($this->uploadedProductIDs as $id){
                $product = $this->uploadedProducts->first(function ($item, $key) use($id) {
                    return $item->id == $id;
                });
                $renderProducts[] = $product ;
            }
        }
        $renderParts = [];
        if (!empty($this->uploadedParts)) {
            foreach($this->uploadedPartIDs as $id){
                $product = $this->uploadedParts->first(function ($item, $key) use($id) {
                    return $item->id == $id;
                });
                $renderParts[] = $product ;
            }
        }

        return view('pages/my-list', [
            'Products' => $renderProducts,
            'Parts' => $renderParts,
        ]);
    }

    public function GetUploadedProducts(){
        if ($this->uploadedProductIDs){
            $this->uploadedProducts = Product::GetProductsByIDs($this->uploadedProductIDs);
        }

        if ($this->uploadedPartIDs){
            $this->uploadedParts = Part::GetPartsByIDs($this->uploadedPartIDs);
        }
    }
}
