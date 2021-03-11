<?php

namespace App\Entity;

use App\Repository\AnswerClaimRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnswerClaimRepository::class)
 */
class AnswerClaim
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
    private $idAnswer;

    /**
     * @ORM\Column(type="text")
     */
    private $contentAnswer;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdAnswer(): ?int
    {
        return $this->idAnswer;
    }

    public function setIdAnswer(int $idAnswer): self
    {
        $this->idAnswer = $idAnswer;

        return $this;
    }

    public function getContentAnswer(): ?string
    {
        return $this->contentAnswer;
    }

    public function setContentAnswer(string $contentAnswer): self
    {
        $this->contentAnswer = $contentAnswer;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
