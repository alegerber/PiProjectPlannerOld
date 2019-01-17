<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Utils\Slugger;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project
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
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var Image
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Image", fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     */
    private $image;

    /**
     * @var Category[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", cascade={"persist"})
     * @ORM\OrderBy({"name": "ASC"})
     */
    private $categories;

    /**
     * @var Tag[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", cascade={"persist"})
     * @ORM\OrderBy({"name": "ASC"})
     */
    private $tags;

    /**
     * @var Component[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Component", cascade={"persist"})
     * @ORM\OrderBy({"name": "ASC"})
     */
    private $components;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->components = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        $this->link = Slugger::slugify($name);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function addCategory(?Category ...$categories): void
    {
        foreach ($categories as $category) {
            if (!$this->categories->contains($category)) {
                $this->categories->add($category);
            }
        }
    }

    public function removeCategory(Category $category): void
    {
        $this->categories->removeElement($category);
    }

    public function getCategories(): ?Collection
    {
        return $this->categories;
    }

    public function addTag(?Tag ...$tags): void
    {
        foreach ($tags as $tag) {
            if (!$this->tags->contains($tag)) {
                $this->tags->add($tag);
            }
        }
    }

    public function removeTag(Tag $tag): void
    {
        $this->tags->removeElement($tag);
    }

    public function getTags(): ?Collection
    {
        return $this->tags;
    }

    public function addComponent(?Component ...$components): void
    {
        foreach ($components as $component) {
            if (!$this->components->contains($component)) {
                $this->components->add($component);
            }
        }
    }

    public function removeComponent(Component $component): void
    {
        $this->components->removeElement($component);
    }

    public function getComponents(): Collection
    {
        return $this->components;
    }
}
