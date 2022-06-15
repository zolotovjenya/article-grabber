<?php
namespace App\Custom;

class GoutteParams{
    static public  function getAllNews(){
       return 'main ul li.group-link-underline a';
    }

    static public function getDate(){
        return 'a p';
    }

    static public function getTitle(){
        return 'main h1';
    }

    static public function getAuthor(){
        return 'article p[itemprop="author"] a';
    }

    static public function getTags(){
        return 'article p:contains("Filed in:")';
    }
}