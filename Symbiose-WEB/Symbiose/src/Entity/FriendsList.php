<?php

namespace App\Entity;

use App\Repository\FriendsListRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FriendsListRepository::class)
 */
class FriendsList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $amis;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbrClient;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getAmis(): ?string
    {
        return $this->amis;
    }

    public function setAmis(string $amis): self
    {
        $this->amis = $amis;

        return $this;
    }

    public function getNbrClient(): ?int
    {
        return $this->nbrClient;
    }

    public function setNbrClient(int $nbrClient): self
    {
        $this->nbrClient = $nbrClient;

        return $this;
    }
}
