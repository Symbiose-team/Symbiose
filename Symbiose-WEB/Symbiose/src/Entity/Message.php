<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Conversation;
use Symfony\Component\Console\Helper\Table;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 * @ORm\Table(name="message_table",indexes={@Index(name="created_at_index", columns={"created_at"})})

 * @ORM\HasLifecycleCallbacks()
 */
class Message
{
    use timeStamp;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column (type="text")
     */
    private $content;
    /**
     * @ORM\ManyToOne (targetEntity="User",inversedBy="Message")
     */
    private $user;
    /**
     * @ORM\ManyToOne (targetEntity="Conversation",inversedBy="Message")
     */
    private $conversation;

    public function getId(): ?int
    {
        return $this->id;
    }
}
