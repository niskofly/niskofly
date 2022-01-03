<?php

namespace App\Widgets;

use App\Models\Review;
use App\Widgets\Contract\ContractWidget;

class ReviewsWidget implements ContractWidget
{
    protected $reviews = null;

    public function __construct($data = []){
        $this->reviews = Review::activeSort()->get();
    }

    public function execute()
    {
        if(!$this->reviews->isEmpty()) {
            return view('Widgets::reviews-slider', ['reviews' => $this->reviews]);
        }
    }
}