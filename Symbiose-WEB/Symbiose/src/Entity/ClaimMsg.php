<?php

namespace App\Entity;

use App\Repository\ClaimMsgRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClaimMsgRepository::class)
 */
class ClaimMsg
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
    private $idClaimMsg;

    /**
     * @ORM\Column(type="text")
     */
    private $contentClaimMsg;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdClaimMsg(): ?int
    {
        return $this->idClaimMsg;
    }

    public function setIdClaimMsg(int $idClaimMsg): self
    {
        $this->idClaimMsg = $idClaimMsg;

        return $this;
    }

    public function getContentClaimMsg(): ?string
    {
        return $this->contentClaimMsg;
    }

    public function setContentClaimMsg(string $contentClaimMsg): self
    {
        $this->contentClaimMsg = $contentClaimMsg;

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
