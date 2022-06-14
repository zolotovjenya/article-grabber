<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App;
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
        for($i=1;$i<1000000000;$i++){
            $crawler = Goutte::request('GET', 'https://laravel-news.com/category/news?page='.$i);

            $crawler->filter('main ul li.group-link-underline a')->each(function ($node) {
                if(isset($node) && !empty($node)){                
                    $date = strtotime($node->filter('a p')->eq(0)->text());
                    
                    if($date > Carbon::now()->subMonths(4)->timestamp){
                        $article = Goutte::request('GET', 'https://laravel-news.com'.$node->attr('href'));

                        $title = $article->filter('main h1')->text();
                        dump($title);    
                    } else {
                        exit;
                    }
                }
            });
        }
    }
}
