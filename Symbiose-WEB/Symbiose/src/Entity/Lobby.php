<?php

namespace App\Entity;

use App\Repository\LobbyRepository;
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
}
