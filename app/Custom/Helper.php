<?php
namespace App\Custom;

class Helper{
    static function makeTags($tags){
        $str = "";

        if(count($tags) > 0){
            foreach($tags as $t){
                $str .= $t.',';
            }
        }

        return substr_replace($str, "", -1);
    }
}