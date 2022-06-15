<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Article;
use Goutte;
use Carbon\Carbon;
use App\Custom\Helper;
use App\Custom\GoutteParams;

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
    protected $description = 'Module for parsing https://laravel-news.com/blog and insert to DB';

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
            $crawler = Goutte::request('GET', config('general.parsingDomain').'/category/news?page='.$i);

            $crawler->filter(GoutteParams::getAllNews())->each(function ($node) {
                if(isset($node) && !empty($node)){                
                    $date = strtotime($node->filter(GoutteParams::getDate())->eq(0)->text());
                    
                    if($date > Carbon::now()->subMonths(4)->timestamp){
                        $url = config('general.parsingDomain').$node->attr('href');

                        $article = Goutte::request('GET', $url);

                        $title = $article->filter(GoutteParams::getTitle())->text();
                        $author = $article->filter(GoutteParams::getAuthor())->text();

                       
                        $tags = $article->filter(GoutteParams::getTags())->nextAll('div')->eq(0)->filter('a')->each(function ($a) {
                            return $t[] = $a->text();
                        });  
                                        
                        $tagFinal = Helper::makeTags($tags); 

                        if(!empty($title) && !empty($date) && !empty($node->attr('href')) && !empty($author) && !empty($tagFinal)){                        
                            $final[] = array(
                                'article_title'  => $title,
                                'article_date'   => $date,
                                'article_url'    => $node->attr('href'),
                                'article_author' => $author,
                                'article_tags'   => $tagFinal
                            );
                        }
                    } else {
                        exit;
                    }
                }

                if(count($final) > 0 ){
                    $articleModel = Article::insert($final);

                    if($articleModel){
                        dump(trans('news.successfullyAdded'));
                    }
                }
            });       
                 
        }
    }
}
