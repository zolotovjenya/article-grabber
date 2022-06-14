<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class ArticleController extends Controller
{
    public function setArticle(){
        $crawler = Goutte::request('GET', 'https://laravel-news.com/category/news');

        $crawler->filter('main ul li')->each(function ($node) {
            dump($node);
            
        });
    }
}
