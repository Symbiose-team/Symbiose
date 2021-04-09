<?php

namespace App\Entity;
use App\Entity\Calendar;
use App\Repository\FieldRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;


use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=FieldRepository::class)
 * @ORM\Table(name="Field")

 */
class Field
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Calendar", mappedBy="Field")
     */
    private $calendar;

    /**
     * @return mixed
     */
    public function getCalendar()
    {
        return $this->calendar;
    }



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @ORM\Column(type="integer", length=255)
     */
    private $serialNumber;

    /**
     * @return mixed
     */
    public function getSerialNumber()
    {
        return $this->serialNumber;
    }

    /**
     * @param mixed $serialNumber
     */
    public function setSerialNumber($serialNumber): void
    {
        $this->serialNumber = $serialNumber;
    }


    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank(message="wrong input")
     * */
    private $name;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="wrong input!")
     */
    private $space;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Assert\NotBlank(message="wrong input!")
     */
    private $provider;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;
    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan("today")
     */
    private $Date_start;

    /**
     * @ORM\Column(type="date")
     *   @Assert\Expression(
     *     "this.getDateStart() < this.getDateEnd()",
     *     message="La date fin ne doit pas être antérieure à la date début"
     * )
     */
    private $Date_end;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="fields")
     */
    private $Booker;

    /**
     * @return mixed
     */
    public function getDateStart()
    {
        return $this->Date_start;
    }

    /**
     * @param mixed $Date_start
     */
    public function setDateStart($Date_start): void
    {
        $this->Date_start = $Date_start;
    }

    /**
     * @return mixed
     */
    public function getDateEnd()
    {
        return $this->Date_end;
    }

    /**
     * @param mixed $Date_end
     */
    public function setDateEnd($Date_end): void
    {
        $this->Date_end = $Date_end;
    }




    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getSpace(): ?string
    {
        return $this->space;
    }

    public function setSpace(?string $space): self
    {
        $this->space = $space;

        return $this;
    }

    public function getProvider(): ?string
    {
        return $this->provider;
    }

    public function setProvider(?string $provider): self
    {
        $this->provider = $provider;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }


    public function __toString()
    {
return($this->name) ;
    }

    public function getBooker(): ?User
    {
        return $this->Booker;
    }

    public function setBooker(?User $Booker): self
    {
        $this->Booker = $Booker;

        return $this;
    }
}
