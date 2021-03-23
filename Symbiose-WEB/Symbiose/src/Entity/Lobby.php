<?php

namespace App\Entity;

use App\Repository\LobbyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=LobbyRepository::class)
 */
class Lobby
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank(message="Wrong input!")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $owner;

    /**
     * @ORM\Column(type="integer")
     *
     */
    private $nbplayers;

    /**
     * @ORM\Column(type="integer")
     * @Assert\EqualTo(value=8,message="Max 8 please !")
     */
    private $maxplayers;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="lobby")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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

    public function getOwner(): ?string
    {
        return $this->owner;
    }

    public function setOwner(string $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getNbplayers(): ?int
    {
        return $this->nbplayers;
    }

    public function setNbplayers(int $nbplayers): self
    {
        $this->nbplayers = $nbplayers;

        return $this;
    }

    public function getMaxplayers(): ?int
    {
        return $this->maxplayers;
    }

    public function setMaxplayers(int $maxplayers): self
    {
        $this->maxplayers = $maxplayers;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setLobby($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getLobby() === $this) {
                $user->setLobby(null);
            }
        }

        return $this;
    }
}
