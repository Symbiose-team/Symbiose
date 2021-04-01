<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=5)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @ORM\JoinColumn(nullable=false)
     */
    private $time;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="games")
     * @ORM\JoinColumn()
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="gameJoined")
     * @ORM\JoinTable(name="game_joines",
     *     joinColumns={@ORM\JoinColumn(name="game_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     * )
     */
    private $joinedBy;

    /**
     * MicroPost constructor.
     */
    public function __construct()
    {
        $this->joinedBy = new ArrayCollection();
    }
    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
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

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }
    /**
     * @return Collection
     */
    public function getJoinedBy()
    {
        return $this->joinedBy;
    }

    /**
     * @param ArrayCollection $joinedBy
     */
    public function setJoinedBy(ArrayCollection $joinedBy): void
    {
        $this->joinedBy = $joinedBy;
    }



    /**
     * @param User $user
     * @return void
     */
    public function join(User $user)
    {
        if ($this->joinedBy->contains($user)) {
            return;
        }

        $this->joinedBy->add($user);
    }


}
