<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 */
class Tag implements \JsonSerializable
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

        //Lower case everything
        $this->component_link = strtolower($name);
        //Make alphanumeric (removes all other characters)
        $this->component_link = preg_replace("/[^a-z0-9_\s-]/", '', $this->component_link);
        //Clean up multiple dashes or whitespaces
        $this->component_link = preg_replace("/[\s-]+/", ' ', $this->component_link);
        //Convert whitespaces and underscore to dash
        $this->component_link = preg_replace("/[\s_]/", '-', $this->component_link);

        return $this;
    }

    public function getComponentLink(): string
    {
        return $this->component_link;
    }

    public function setComponentLink(string $component_link): self
    {
        $this->component_link = $component_link;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): string
    {
        // This entity implements JsonSerializable (http://php.net/manual/en/class.jsonserializable.php)
        // so this method is used to customize its JSON representation when json_encode()
        // is called, for example in tags|json_encode (app/Resources/views/form/fields.html.twig)
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
