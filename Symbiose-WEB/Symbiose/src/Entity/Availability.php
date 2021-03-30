<?php

namespace App\Entity;

use App\Repository\AvailabilityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Field;


/**
 * @ORM\Entity(repositoryClass=AvailabilityRepository::class)
 */
class Availability
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @param ArrayCollection $field_serialnumber
     */
    public function setFieldSerialnumber(ArrayCollection $field_serialnumber): void
    {
        $this->field_serialnumber = $field_serialnumber;
    }

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->Date_start;
    }

    public function setDateStart(\DateTimeInterface $Date_start): self
    {
        $this->Date_start = $Date_start;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->Date_end;
    }

    public function setDateEnd(\DateTimeInterface $Date_end): self
    {
        $this->Date_end = $Date_end;

        return $this;
    }

    /**
     * @return Collection|field[]
     */
    public function getFieldSerialnumber(): Collection
    {
        return $this->field_serialnumber;
    }

    public function addFieldSerialnumber(field $fieldSerialnumber): self
    {
        if (!$this->field_serialnumber->contains($fieldSerialnumber)) {
            $this->field_serialnumber[] = $fieldSerialnumber;
            $fieldSerialnumber->setAvailability($this);
        }

        return $this;
    }

    public function removeFieldSerialnumber(field $fieldSerialnumber): self
    {
        if ($this->field_serialnumber->removeElement($fieldSerialnumber)) {
            // set the owning side to null (unless already changed)
            if ($fieldSerialnumber->getAvailability() === $this) {
                $fieldSerialnumber->setAvailability(null);
            }
        }

        return $this;
    }
}
