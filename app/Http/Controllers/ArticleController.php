<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    /*
    * get all articles for home page
    * article_author sorting
    */
    public function articles(){
        $data = Article::sortable()->orderBy('article_author', 'asc')->paginate(10);

        return view('welcome', ['articles' => $data]);
    }
}
