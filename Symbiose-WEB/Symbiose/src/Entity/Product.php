<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *@Assert\NotBlank(message="Veuillez donner un nom a votre produit")
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez donner une description a votre produit")
     */
    private $Description;

    /**
     * @ORM\Column(type="decimal", nullable=false)
     * @Assert\NotBlank(message="Veuillez préciser un PRIX !")
     */
    private $Price;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez specifier le type de votre produit")
     */
    private $Type;

    /**
     * @ORM\Column(type="boolean" ,nullable=false)
     */
    private $State;


    //THESE HERE ARE THE GETTERS AND SETTERS
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->Price;
    }

    public function setPrice(float $price): self
    {
        $this->Price = $price;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $type): self
    {
        $this->Type = $type;

        return $this;
    }

    public function getState(): ?bool
    {
        return $this->State;
    }

    public function setState(bool $state): self
    {
        $this->State = $state;

        return $this;
    }
}
