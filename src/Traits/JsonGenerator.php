<?php

namespace App\Traits;

trait JsonGenerator
{
    /*
    * Return an json array with length $lenght and contains
    * random numbers between 0 and $entrys.
    *
    * @param int $number
    * @param int $entrys
    *
    * @return string
    */
    public function getJson(int $lenght, int $entrys): string
    {
        $array[] = null;
        for ($i = 0; $i < $lenght; ++$i) {
            $array[$i] = rand(0, $entrys);
        }

        return json_encode($array);
    }
}
