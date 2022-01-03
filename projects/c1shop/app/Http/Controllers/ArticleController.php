<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends MainController
{
    public function indexArticle(Request $request){
        // $article = Article::where('url',$request->route('url'))->get()->first();
        // $articles = Article::getContentByType($article->type, $request->route('url') )->orderBy('date_view', 'desc')->paginate(5);
        $this->seoParams['title'] =  'Новости и статьи';
        $this->seoParams['description'] ='';

        parent::index($request);

        return view('pages/indexArticle', [
            'title' => 'Новости и статьи',
        ]);
    }

    public function contentArticle(Request $request){
        $article = Article::where('url',$request->route('url'))->get()->first();
        $articles = Article::getContentByType($article->type, $request->route('url') )->orderBy('date_view', 'desc')->paginate(5);
//        $this->seoParams['title'] = $article->seo_title ? $article->seo_title :  $article->name . ' | Компания «Вектор»';
//        $this->seoParams['description'] = $article->seo_description ? $article->seo_description : str_replace(array("\r\n", "\r", "\n"), '', strip_tags($article->full_content));

        $this->seoParams['title'] =  $article->name . ' | Компания «Вектор»';
        $this->seoParams['description'] = str_limit(str_replace(array("\r\n", "\r", "\n"), '', strip_tags($article->full_content)), 170);


        $this->seoParams['key'] = $article->seo_key;
        $this->seoParams['image'] = $article->preview_image;

        parent::index($request);

        return view('pages/contentArticle', [
            'article' => $article,
            'title' => $article->name,
            'articles' => $articles
        ]);
    }
}
