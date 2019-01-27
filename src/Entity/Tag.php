<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Utils\Slugger;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 */
class Tag implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @var Component
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Component", inversedBy="categories")
     */
    private $components;

    public function __construct()
    {
        $this->components = new ArrayCollection();
    }

    public function getId(): ?int
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

        $this->slug = Slugger::slugify($name);

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }
    public function addComponent(?Component ...$components): void
    {
        foreach ($components as $component) {
            if (!$this->components->contains($component)) {
                $this->components->add($component);
            }
        }
    }

    public function removeComponent(Tag $component): void
    {
        $this->components->removeElement($component);
    }

    public function getComponents(): ?Collection
    {
        return $this->components;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
