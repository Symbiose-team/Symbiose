<?php

namespace App\Entity;

use App\Repository\ConversationRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Message;
use Symfony\Component\Console\Helper\Table;
use Doctrine\ORM\Mapping\Index;
/**
 * @ORM\Entity(repositoryClass=ConversationRepository::class)
 * @ORm\Table(name="conversation_table",indexes={@Index(name="last_message_id", columns={"last_message_id"})})

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
     * @ORM\OneToMany (targetEntity="Participant", mappedBy="conversation")
     */
    private $participants;
    /**
     * @ORM\OneToOne (targetEntity="Participant")
     * @ORM\JoinColumn (name="last_message_id",referencedColumnName="id")
     */
    private $lastMessage;
    /**
     * @ORM\OneToMany (targetEntity="Message", mappedBy="conversation")
     */
    private $messages;

    public function getId(): ?int
    {
        return $this->id;
    }
}
