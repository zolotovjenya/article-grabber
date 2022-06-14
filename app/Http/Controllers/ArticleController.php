<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;

class ArticleController extends Controller
{
    /*
    * get all articles for home page
    */
    public function articles(){
        $data = Article::sortable()->orderBy('article_author', 'asc')->paginate(10);

        return view('welcome', ['articles' => $data]);
    }
}
