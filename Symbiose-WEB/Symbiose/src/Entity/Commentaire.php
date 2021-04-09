<?php

namespace App\Entity;

use App\Repository\Communication\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contenu;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commentaires")
     */
    private $User;

    /**
     * @ORM\ManyToOne(targetEntity=Publication::class, inversedBy="commentaires")
     */
    private $Publication;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="comments")
     */
    private $productcomment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getPublication(): ?Publication
    {
        return $this->Publication;
    }

    public function setPublication(?Publication $Publication): self
    {
        $this->Publication = $Publication;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getProductcomment(): ?Product
    {
        return $this->productcomment;
    }

    public function setProductcomment(?Product $productcomment): self
    {
        $this->productcomment = $productcomment;

        return $this;
    }
}
