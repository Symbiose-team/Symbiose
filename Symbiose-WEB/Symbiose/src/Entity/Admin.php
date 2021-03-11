<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdminRepository::class)
 */
class Admin
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $idadmin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdadmin(): ?int
    {
        return $this->idadmin;
    }

    public function setIdadmin(int $idadmin): self
    {
        $this->idadmin = $idadmin;

        return $this;
    }
}
