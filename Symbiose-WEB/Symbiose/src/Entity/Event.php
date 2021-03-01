<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
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
     */
    private $Name;

    /**
     * @ORM\Column(type="text", length=100)
     */
    private $Supplier;

    /**
     * @ORM\Column(type="integer")
     */
    private $NumParticipants;

    /**
     * @ORM\Column(type="integer")
     */
    private $NumRemaining;

    /**
     * @ORM\Column(type="text", length=100)
     */
    private $Type;




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






}
