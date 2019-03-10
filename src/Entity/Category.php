<?php declare(strict_types = 1);

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category implements \JsonSerializable
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
     * @var Component[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Component", inversedBy="categories")
     */
    private $components;

    /**
     * @var Project[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Project", inversedBy="categories")
     */
    private $projects;

    public function __construct()
    {
        $this->components = new ArrayCollection();
        $this->projects = new ArrayCollection();
    }

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

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
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

    public function addProject(?Project ...$projects): void
    {
        foreach ($projects as $project) {
            if (!$this->projects->contains($project)) {
                $this->projects->add($project);
            }
        }
    }

    public function removeProject(Tag $project): void
    {
        $this->projects->removeElement($project);
    }

    public function getProjects(): ?Collection
    {
        return $this->projects;
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
