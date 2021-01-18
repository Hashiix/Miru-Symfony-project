<?php

namespace App\Entity;

use App\Repository\AnimeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnimeRepository::class)
 */
class Anime
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity=Member::class, inversedBy="createdBy")
     */
    private $createdBy;

    /**
     * @ORM\ManyToMany(targetEntity=Member::class, inversedBy="updatedBy")
     */
    private $updatedBy;

    public function __construct()
    {
        $this->createdBy = new ArrayCollection();
        $this->updatedBy = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Member[]
     */
    public function getCreatedBy(): Collection
    {
        return $this->createdBy;
    }

    public function addCreatedBy(Member $createdBy): self
    {
        if (!$this->createdBy->contains($createdBy)) {
            $this->createdBy[] = $createdBy;
        }

        return $this;
    }

    public function removeCreatedBy(Member $createdBy): self
    {
        $this->createdBy->removeElement($createdBy);

        return $this;
    }

    /**
     * @return Collection|Member[]
     */
    public function getUpdatedBy(): Collection
    {
        return $this->updatedBy;
    }

    public function addUpdatedBy(Member $updatedBy): self
    {
        if (!$this->updatedBy->contains($updatedBy)) {
            $this->updatedBy[] = $updatedBy;
        }

        return $this;
    }

    public function removeUpdatedBy(Member $updatedBy): self
    {
        $this->updatedBy->removeElement($updatedBy);

        return $this;
    }
}
