<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=MemberRepository::class)
 * @UniqueEntity(
 *     fields={"email"},
 *     message="L'email que vous avez indiqué est déjà utilisé !"
 * )
 * @UniqueEntity(
 *     fields={"username"},
 *     message="Le pseudo que vous avez indiqué est déjà utilisé !"
 * )
 */
class Member implements UserInterface
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
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *     min= "8",
     *     max= "50",
     *     minMessage= "Votre mot de passe doit faire au moins 8 caractères",
     *     maxMessage= "Votre mot de passe ne doit pas faire plus de 50 caractères",
     *     )
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="datetime")
     */
    private $registration_date;

    /**
     * @Assert\EqualTo(
     *     propertyPath= "password",
     *     message="Vous n'avez pas tapé le même mot de passe"
     * )
     */
    public $passwordVerify;

    /**
     * @ORM\ManyToMany(targetEntity=Anime::class, mappedBy="createdBy")
     */
    private $createdBy;

    /**
     * @ORM\ManyToMany(targetEntity=Anime::class, mappedBy="updatedBy")
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registration_date;
    }

    public function setRegistrationDate(\DateTimeInterface $registration_date): self
    {
        $this->registration_date = $registration_date;

        return $this;
    }

    public function eraseCredentials()
    {
    }

    public function getSalt()
    {
        return null;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * @return Collection|Anime[]
     */
    public function getCreatedBy(): Collection
    {
        return $this->createdBy;
    }

    public function addCreatedBy(Anime $createdBy): self
    {
        if (!$this->createdBy->contains($createdBy)) {
            $this->createdBy[] = $createdBy;
            $createdBy->addCreatedBy($this);
        }

        return $this;
    }

    public function removeCreatedBy(Anime $createdBy): self
    {
        if ($this->createdBy->removeElement($createdBy)) {
            $createdBy->removeCreatedBy($this);
        }

        return $this;
    }

    /**
     * @return Collection|Anime[]
     */
    public function getUpdatedBy(): Collection
    {
        return $this->updatedBy;
    }

    public function addUpdatedBy(Anime $updatedBy): self
    {
        if (!$this->updatedBy->contains($updatedBy)) {
            $this->updatedBy[] = $updatedBy;
            $updatedBy->addUpdatedBy($this);
        }

        return $this;
    }

    public function removeUpdatedBy(Anime $updatedBy): self
    {
        if ($this->updatedBy->removeElement($updatedBy)) {
            $updatedBy->removeUpdatedBy($this);
        }

        return $this;
    }
}
