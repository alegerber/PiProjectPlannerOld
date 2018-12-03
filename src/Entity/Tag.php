<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagsRepository")
 */
class Tag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
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
    private $componentLink;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $project;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $component;

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
        return $this->componentLink;
    }

    public function setComponentLink(string $componentLink): self
    {
        $this->componentLink = $componentLink;

        return $this;
    }

    public function getProject()
    {
        return $this->project;
    }

    public function setproject($project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getComponent()
    {
        return $this->component;
    }

    public function setComponent($component): self
    {
        $this->component = $component;

        return $this;
    }
}
