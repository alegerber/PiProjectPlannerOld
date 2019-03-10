<?php declare(strict_types = 1);

namespace App\Tests\Utils;

use App\Utils\Slugger;
use PHPUnit\Framework\TestCase;

class SluggerTest extends TestCase
{
    public function testSlugify()
    {
        $result = Slugger::slugify('sfaERq awsw sda');

        $this->assertEquals('sfaerq-awsw-sda', $result);
    }
}
