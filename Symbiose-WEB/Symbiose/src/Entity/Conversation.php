<?php

namespace App\Entity;

use App\Repository\Communication\ConversationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConversationRepository::class)
 */
class Conversation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    
    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="conversation", orphanRemoval=true)
     */
    private $Messages;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="conversations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User1;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="conversationsRecus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User2;

    public function __construct()
    {
        $this->Messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->Messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->Messages->contains($message)) {
            $this->Messages[] = $message;
            $message->setConversation($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->Messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getConversation() === $this) {
                $message->setConversation(null);
            }
        }

        return $this;
    }

    public function getUser1(): ?User
    {
        return $this->User1;
    }

    public function setUser1(?User $User1): self
    {
        $this->User1 = $User1;

        return $this;
    }

    public function getUser2(): ?User
    {
        return $this->User2;
    }

    public function setUser2(?User $User2): self
    {
        $this->User2 = $User2;

        return $this;
    }
}
