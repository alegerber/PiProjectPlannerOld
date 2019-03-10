<?php declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image
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
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload an image first.")
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg", "image/jpg" })
     */
    private $uploadedFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload an image first.")
     */
    private $uploadedFileOriginName;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Assert\Length(max=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @var Tag[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", cascade={"persist"})
     * @ORM\OrderBy({"name": "ASC"})
     */
    private $tags;

    /**
     * @var bool $uploadedFileTest
     */
    private $uploadedFileTest;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->uploadedFileTest = false;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUploadedFile(): ?UploadedFile
    {
        return new UploadedFile((string) $this->uploadedFile, $this->uploadedFileOriginName, null, null, $this->uploadedFileTest);
    }

    public function setUploadedFile(?UploadedFile $uploadedFile, bool $test = false): self
    {
        if (null !== $uploadedFile) {
            $this->uploadedFile = $uploadedFile;
            $this->uploadedFileOriginName = $uploadedFile->getClientOriginalName();
            $this->uploadedFileTest = $test;
        }

        return $this;
    }

    /**
     * Function for correcting the filepath in fixtures.
     *
     * @param string|null $uploadedFilePath
     * @return void
     */
    public function setUploadedFileFixture(?string $uploadedFilePath): void
    {
        if (null !== $uploadedFilePath) {
            $this->uploadedFile = $uploadedFilePath;
        }
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
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
}
