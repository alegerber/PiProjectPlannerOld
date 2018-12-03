<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

abstract class ParentFixtures extends Fixture
{

    /**
     * @var ObjectManager
     */
    protected $manager;

    /**
     * @var integer
     */
    protected $entrys;
    
    abstract public function load(ObjectManager $manager);


    protected function getJson($number)
    {
        $array[] = null;
        for ($i = 0; $i <= $number; $i++){
            $array[$i] = rand(0, $this->entrys);
        }
        return json_encode($array);

    }
}
