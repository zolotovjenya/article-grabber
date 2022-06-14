<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Article;
use Goutte;
use Carbon\Carbon;

class InsertArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parsed https://laravel-news.com/blog and insert to DB';

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
        $final = [];

        for($i=1;$i<1000000000;$i++){
            $crawler = Goutte::request('GET', 'https://laravel-news.com/category/news?page='.$i);

            $crawler->filter('main ul li.group-link-underline a')->each(function ($node) {
                if(isset($node) && !empty($node)){                
                    $date = strtotime($node->filter('a p')->eq(0)->text());
                    
                    if($date > Carbon::now()->subMonths(4)->timestamp){
                        $url = 'https://laravel-news.com'.$node->attr('href');

                        $article = Goutte::request('GET', $url);

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
                    } else {
                        exit;
                    }
                }

                if(count($final) > 0 ){
                    $articleModel = Article::insert($final);

                    if($articleModel){
                        dump("Success");
                    }
                }
            });       
                 
        }

       
    }

    private function makeTags($tags){
        $str = "";

        if(count($tags) > 0){
            foreach($tags as $t){
                $str .= $t.',';
            }
        }

        return substr_replace($str, "", -1);
    }
}
