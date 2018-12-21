<?php

namespace App\Services;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class JsonGenerator
{
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @param JsonEncoder
     * @param ObjectNormalizer
     */
    public function __construct()
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
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

        return $this->serializer->encode($array, 'json');
    }
}
