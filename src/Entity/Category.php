<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

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

    /**
     * @var Project[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Project")
     * @ORM\OrderBy({"name": "ASC"})
     */
    private $projects;

    /**
     * @var Component[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Component")
     * @ORM\OrderBy({"name": "ASC"})
     */
    private $components;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
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

        return $this;
    }

    public function getComponentLink(): ?string
    {
        return $this->component_link;
    }

    public function setComponentLink(string $component_link): self
    {
        $this->component_link = $component_link;

        return $this;
    }

    public function addProject(?Project ...$Projects): void
    {
        foreach ($Projects as $Project) {
            if (!$this->projects->contains($Project)) {
                $this->projects->add($Project);
            }
        }
    }

    public function removeProject(Project $Project): void
    {
        $this->projects->removeElement($Project);
    }

    public function getProjects(): Collection
    {
        return $this->projects;
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
