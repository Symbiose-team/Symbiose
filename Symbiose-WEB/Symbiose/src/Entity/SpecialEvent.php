<?php

namespace App\Entity;

use App\Repository\SpecialEventRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SpecialEventRepository::class)
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
     * @ORM\Column(type="text", length=100)
     * @Assert\NotBlank(message="should not be blank")
     */
    private $Supplier;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="invalid input")
     * @Assert\NotNull(message="value is null")
     */
    private $NumParticipants;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="invalid input")
     * @Assert\NotNull(message="value is null")
     */
    private $NumRemaining;

    /**
     * @ORM\Column(type="text", length=100)
     * @Assert\NotBlank(message="invalid input")
     */
    private $Type;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     */
    private $Date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url(message="Veuillez donner un URL valide pour votre event")
     */
    private $picture;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="id_special_event")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;




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
    public function getSupplier()
    {
        return $this->Supplier;
    }

    /**
     * @param mixed $Supplier
     */
    public function setSupplier($Supplier): void
    {
        $this->Supplier = $Supplier;
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
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param mixed $picture
     */
    public function setPicture($picture): void
    {
        $this->picture = $picture;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


}
