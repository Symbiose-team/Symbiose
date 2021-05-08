<?php

namespace App\Entity;

use App\Repository\SpecialEventRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Nullable;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * @ORM\Entity(repositoryClass=SpecialEventRepository::class)
 * @Vich\Uploadable
 */
class SpecialEvent
{
    //Properties

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", length=100)
     * @Assert\NotBlank(message="should not be blank")
     */
    private $Name;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="invalid input")
     * @Assert\NotNull(message="value is null")
     */
    private $NumParticipants = 100;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="invalid input")
     * @Assert\NotNull(message="value is null")
     */
    private $NumRemaining = 100;

    /**
     * @ORM\Column(type="text", length=100)
     * @Assert\NotBlank(message="invalid input")
     */
    private $Type;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     */
    private $Date;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=false, options={"default"=0})
     */
    private $State;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="specialEvents")
     */
    private $Participants;

    public function __construct()
    {
        $this->Participants = new ArrayCollection();
    }




    //Getters and setters
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * @param mixed $Name
     */
    public function setName($Name): void
    {
        $this->Name = $Name;
    }



    /**
     * @return mixed
     */
    public function getNumParticipants()
    {
        return $this->NumParticipants;
    }

    /**
     * @param mixed $NumParticipants
     */
    public function setNumParticipants($NumParticipants): void
    {
        $this->NumParticipants = $NumParticipants;
    }

    /**
     * @return mixed
     */
    public function getNumRemaining()
    {
        return $this->NumRemaining;
    }

    /**
     * @param mixed $NumRemaining
     */
    public function setNumRemaining($NumRemaining): void
    {
        $this->NumRemaining = $NumRemaining;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->Type;
    }

    /**
     * @param mixed $Type
     */
    public function setType($Type): void
    {
        $this->Type = $Type;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->Date;
    }

    /**
     * @param mixed $Date
     */
    public function setDate($Date): void
    {
        $this->Date = $Date;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->State;
    }

    /**
     * @param mixed $State
     */
    public function setState($State): void
    {
        $this->State = $State;
    }

    /**
     * @return Collection|User[]
     */
    public function getParticipants(): Collection
    {
        return $this->Participants;
    }

    public function addParticipant(User $participant): self
    {
        if (!$this->Participants->contains($participant)) {
            $this->Participants[] = $participant;
        }

        return $this;
    }

    public function removeParticipant(User $participant): self
    {
        $this->Participants->removeElement($participant);

        return $this;
    }




}
