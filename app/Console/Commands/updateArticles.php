<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Article;
use Goutte;
use Carbon\Carbon;

class updateArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parsed https://laravel-news.com/blog and updated article data in DB';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $articles = Article::all();

        if(!empty($articles)){
            foreach($articles as $a){
                $article = Goutte::request('GET', $a->article_url);

                /*if($article){
                    $title = $article->filter('main h1')->text();
                    $author = $article->filter('article p[itemprop="author"] a')->text();

                    
                    $tags = $article->filter('article p:contains("Filed in:")')
                                    ->nextAll('div')
                                    ->eq(0)
                                    ->filter('a')
                                    ->each(function ($a) {
                                        return $t[] = $a->text();
                                    });  
                                    
                    $tagFinal = $this->makeTags($tags); 
                    
                    $final[] = array(
                        'article_title'  => $title,
                        'article_date'   => $date,
                        'article_url'    => $url,
                        'article_author' => $author,
                        'article_tags'   => $tagFinal
                    );
                }*/
            }

            $articleModel = Article::update($final);

            if($articleModel){
                dump("Success");
            }
        }
    }
}
