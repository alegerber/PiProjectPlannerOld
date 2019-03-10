<?php declare(strict_types = 1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class ImageFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * @var ObjectManager $manager
     */
    private $manager;

    /**
     * @var int $entries
     */
    private $entries;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->entries = 100;

        $this->image();

        $this->manager->flush();
    }

    private function image(): void
    {
        $entityFixtures = new EntityFixtures();
        for ($i = 0; $i <= $this->entries; ++$i) {
            $this->manager->persist($entityFixtures->getImage($this->manager, $this->entries));
        }
    }

    public function getOrder(): int
    {
        return 2;
    }
}
