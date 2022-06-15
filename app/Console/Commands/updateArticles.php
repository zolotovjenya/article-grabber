<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Article;
use Goutte;
use Carbon\Carbon;
use App\Custom\Helper;
use App\Custom\GoutteParams;

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
        $final = [];

        if(!empty($articles)){
            foreach($articles as $a){
                $article = Goutte::request('GET', config('general.parsingDomain').$a->article_url);

                try{
                    $title = $article->filter(GoutteParams::getTitle())->text();
                    $author = $article->filter(GoutteParams::getAuthor())->text();
                    $date = strtotime($article->filter(GoutteParams::getArticleDate())->text());
                    
                    $tags = $article->filter(GoutteParams::getTags())->nextAll('div')->eq(0)->filter('a')->each(function ($a) {
                        return $t[] = $a->text();
                    });  
                                    
                    $tagFinal = Helper::makeTags($tags); 

                    $updatedField = $this->getUpdatedFields($a, $title, $author, $tagFinal, $date);                    

                    if(!empty($updatedField) > 0){
                        $articleModel = Article::where('article_id', $a->article_id)
                                                ->update($updatedField);

                        if($articleModel){
                            dump(trans('news.successfullyUpdated'));
                        }
                    } else {
                        dump(trans('news.nothingUpdate'));
                    }
                } catch(Exception $e) {
                    /* 
                    You will see in console if url already not exists
                    */
                    dump(trans('news.urlNotExists', ['url' => $a->article_url]));
                }
            }
        }
    }

    private function getUpdatedFields($a, $title, $author, $tagFinal, $date){
        $data = [];

        if($a->article_title != $title){
            $data['article_title'] = $title;
        }

        if($a->article_author != $author){
            $data['article_author'] = $author;
        }

        if($a->article_tags != $tagFinal){
            $data['article_tags'] = $tagFinal;
        }

        if($a->article_date != $date){
            $data['article_date'] = $date;
        }

        return $data;
    }
}
