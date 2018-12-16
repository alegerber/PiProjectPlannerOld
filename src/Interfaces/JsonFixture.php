<?php

namespace App\Interfaces;

interface JsonFixture
{
    public function getJson(int $number, int $entrys): ?string;
}
