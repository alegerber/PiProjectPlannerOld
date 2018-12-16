<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $projects;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $components;

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

    public function getProjects()
    {
        return $this->projects;
    }

    public function setProjects($projects): self
    {
        $this->projects = $projects;

        return $this;
    }

    public function getComponents()
    {
        return $this->components;
    }

    public function setComponents($components): self
    {
        $this->components = $components;

        return $this;
    }
}
