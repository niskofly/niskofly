<?php

namespace App\Http\Controllers;

use App\Models\Share;
use Illuminate\Http\Request;

class ShareController extends MainController
{
    public function index(Request $request) {
        $shares = Share::active()->orderBy('sort', 'asc')->get();

        $this->seoParams['title'] = 'Акции и скидки на прачечное оборудование | Компания «Вектор» ';
        $this->seoParams['description'] = 'Действующие акции на оборудование для прачечной и химчистки, купить оборудование со скидкой в компании «Вектор».';
        parent::index($request);
        
        return view('pages/shares', [
            'shares' => $shares
        ]);
    }
    
    
    public function contentShare(Request $request)
    {
        $share = Share::where('url', $request->route('url'))->get()->first();
        $shares = Share::where('url', '!=', $request->route('url'))->active()->orderBy('sort', 'asc')->get();

        if (!$share || !$share) {
            abort(404);
        }

        function getArFirstString($workText){
            $text = str_replace(array("\r\n", "\r", "\n"), '', strip_tags($workText));
            // omg! кодирую текст, чтобы исключить сокращения с точками, чтобы позже работало рег.выр.
            $search = array(
                "т.к.",
                "т. к.",
                "т.е.",
                "т. е.",
                "г.",
                "ул.",
                "кв.",
                "д.",
                "тел.",
                "моб.",
                "дом."
            );
            $replace = array(
                "{[$%#tk1]}",
                "{[$%#tk2]}",
                "{[$%#te1]}",
                "{[$%#te2]}",
                "{[$%#g]}",
                "{[$%#ul]}",
                "{[$%#kv]}",
                "{[$%#d]}",
                "{[$%#tel]}",
                "{[$%#mob]}",
                "{[$%#dom]}"
            );
            $text = str_replace($search, $replace, $text);

            // чтобы рег.выр.-у соответстовали первое и последнее предложение в тексте
            $text = ' ' . $text . ' ';

            // сам рег.выр.
            $reg = '/([A-ZА-Я]+.+)[.!?]+[\s]+/sU';
            preg_match_all($reg, $text, $strings, PREG_PATTERN_ORDER);
            // это массив с предложениями, без знака препинания вконце, но ниче
            $strings = $strings[1];

            // декодируем предложения в нормальный вид
            foreach ($strings as $i => $string) $strings[$i] = str_replace($replace, $search, $string);

            return $strings;
        }


        $this->seoParams['title'] = $share->seo_title ? $share->seo_title : 'Акция ' . $share->name . ' | Компания «Вектор»';
        $this->seoParams['description'] = $share->seo_description ? $share->seo_description : str_limit(str_replace(array("\r\n", "\r", "\n"), '', strip_tags($share->full_content)), 170);

        $this->seoParams['image'] = $share->preview_image;

        parent::index($request);
        return view('pages/share', [
            'share' => $share,
            'title' => $share->name,
            'shares' => $shares
        ]);
    }
}
