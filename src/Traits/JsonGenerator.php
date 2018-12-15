<?php

namespace App\Traits;

trait JsonGenerator {

    /*
    * @return json
    */    
    function getJson($number, $entrys)
    {
        $array[] = null;
        for ($i = 0; $i <= $number; $i++){
            $array[$i] = rand(0, $entrys);
        }

        return json_encode($array);

    }

}