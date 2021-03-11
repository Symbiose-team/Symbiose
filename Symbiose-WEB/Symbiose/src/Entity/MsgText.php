<?php

namespace App\Entity;

use App\Repository\MsgTextRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MsgTextRepository::class)
 */
class MsgText
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
    private $idMsgT;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdMsgT(): ?int
    {
        return $this->idMsgT;
    }

    public function setIdMsgT(int $idMsgT): self
    {
        $this->idMsgT = $idMsgT;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
