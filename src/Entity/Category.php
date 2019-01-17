<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Utils\Slugger;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $component_link;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        $this->component_link = Slugger::slugify($name);

        return $this;
    }

    public function getComponentLink(): ?string
    {
        return $this->component_link;
    }
}
