<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseinger votre prénom")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner votre nom de famille")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $Email;

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="user", orphanRemoval=true)
     */
    private $id_event;

    /**
     * @ORM\OneToMany(targetEntity=SpecialEvent::class, mappedBy="user", orphanRemoval=true)
     */
    private $id_special_event;

    public function __construct()
    {
        $this->id_event = new ArrayCollection();
        $this->id_special_event = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * @param mixed $Email
     */
    public function setEmail($Email): void
    {
        $this->Email = $Email;
    }

    /**
     * @return Collection|Event[]
     */
    public function getIdEvent(): Collection
    {
        return $this->id_event;
    }

    public function addIdEvent(Event $idEvent): self
    {
        if (!$this->id_event->contains($idEvent)) {
            $this->id_event[] = $idEvent;
            $idEvent->setUser($this);
        }

        return $this;
    }

    public function removeIdEvent(Event $idEvent): self
    {
        if ($this->id_event->removeElement($idEvent)) {
            // set the owning side to null (unless already changed)
            if ($idEvent->getUser() === $this) {
                $idEvent->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SpecialEvent[]
     */
    public function getIdSpecialEvent(): Collection
    {
        return $this->id_special_event;
    }

    public function addIdSpecialEvent(SpecialEvent $idSpecialEvent): self
    {
        if (!$this->id_special_event->contains($idSpecialEvent)) {
            $this->id_special_event[] = $idSpecialEvent;
            $idSpecialEvent->setUser($this);
        }

        return $this;
    }

    public function removeIdSpecialEvent(SpecialEvent $idSpecialEvent): self
    {
        if ($this->id_special_event->removeElement($idSpecialEvent)) {
            // set the owning side to null (unless already changed)
            if ($idSpecialEvent->getUser() === $this) {
                $idSpecialEvent->setUser(null);
            }
        }

        return $this;
    }


}
