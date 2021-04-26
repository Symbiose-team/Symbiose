<?php

namespace App\Entity;

use App\Entity\Commentaire;
use App\Entity\Conversation;
use App\Entity\Message;
use App\Repository\UserRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *     fields={"Email"},
 *     message="Un autre utilisateur s'est déjà inscrit avec cette adresse email, merci de la modifier "
 * )
 * @UniqueEntity(
 *     fields={"Cin"},
 *     message="Un autre utilisateur s'est déjà inscrit avec ce numéro CIN, merci de le modifier"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("post:read")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseinger votre prénom")
     * @Groups("post:read")
     */
    private ?string $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner votre nom de famille")
     * @Groups("post:read")
     */
    private ?string $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     * @Groups("post:read")
     */
    private ?string $Email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url(message="Veuillez donner un URL valide pour votre avatar")
     * @Groups("post:read")
     */
    private ?string $picture;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8",minMessage="Votre mot de passe doit faire au moins 8 caracteres ! ")
     *
     */
    private ?string $hash;
    /**
     * @Assert\EqualTo(propertyPath="hash",message="Vous n'avez pas correctement confirmer votre mot de passe ")
     */
    public $passwordConfirm;
    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(min="8",minMessage="Votre numéro de cin doit faire 8 caracteres !")
     * @Groups("post:read")
     */
    private ?int $Cin;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="Veuillez selectionner votre date de naissance")
     * @Groups("post:read")
     */
    private ?\DateTimeInterface $Birthday;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $slug;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("post:read")
     */
    private ?string $role;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="16",max="32",maxMessage="Vous avez dépasser les 32 caracteres !",minMessage="l'Adresse ne peut avoir moins de 16 caracteres !")
     * @Groups("post:read")
     */
    private ?string $Adresse;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(min="8",minMessage="Votre numéro doit faire au moins 8 chiffres !")
     * @Groups("post:read")
     */
    private $Phone_Number;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Role",mappedBy="users")
     */
    private $userRoles;


    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private ?\DateTimeImmutable $registeredAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private ?\DateTimeImmutable $accountMustBeVerifiedBefore;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $registrationToken;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isVerified;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?\DateTimeImmutable $accountVerifiedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $forgotPasswordToken;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?\DateTimeImmutable $forgotPasswordTokenRequestedAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?\DateTimeImmutable $forgotPasswordTokenMustBeVerifiedBefore;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?\DateTimeImmutable $ForgotPasswordTokenVerifiedAt;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("post:read")
     */
    private ?bool $isEnabled;

    /**
     * @ORM\OneToMany (targetEntity="App\Entity\Game", mappedBy="user")
     */
    private $games;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Game", mappedBy="joinedBy")
     */
    private $gamesJoined;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="User")
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity=Conversation::class, mappedBy="User1", orphanRemoval=true)
     */
    private $conversations;

    /**
     * @ORM\OneToMany(targetEntity=Conversation::class, mappedBy="User2", orphanRemoval=true)
     */
    private $conversationsRecus;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="user", orphanRemoval=true)
     */
    private $messages;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, mappedBy="Participants")
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="Supplier")
     */
    private $supplierevents;

    /**
     * @ORM\OneToMany(targetEntity=SpecialEvent::class, mappedBy="Participants")
     */
    private $specialEvents;

    /**
     * @ORM\OneToMany(targetEntity=SpecialEvent::class, mappedBy="Supplier")
     */
    private $suppliersevents;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="Supplier")
     */
    private $productowner;

    /**
     * @ORM\OneToMany(targetEntity=Field::class, mappedBy="Booker")
     */
    private $fields;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $genre;




    public function __construct()
    {
        $this->gamesJoined = new ArrayCollection();
        $this->games = new ArrayCollection();
        $this->userRoles = new ArrayCollection();
        //add this new if error undo below
        $this->isEnabled=true;
        $this->isVerified=false;
        $this->registeredAt=new \DateTimeImmutable('now');
        $this->accountMustBeVerifiedBefore=(new \DateTimeImmutable('now'))->add(new \DateInterval("P1D"));
        $this->commentaires = new ArrayCollection();
        $this->conversations = new ArrayCollection();
        $this->conversationsRecus = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->supplierevents = new ArrayCollection();
        $this->specialEvents = new ArrayCollection();
        $this->suppliersevents = new ArrayCollection();
        $this->productowner = new ArrayCollection();
        $this->fields = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getGameJoined(): ArrayCollection
    {
        return $this->gamesJoined;
    }



    /**
     * @return ArrayCollection
     */
    public function getGames(): ArrayCollection
    {
        return $this->games;
    }

    public function getFullname(){
        return "{$this->firstName} {$this->lastName}";
    }
    /**
     * Permet d'initialiser le slug
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function initializeSlug(){
        if(empty($this->slug)){
            $slugify= new Slugify();
            $this->slug=$slugify->slugify($this->firstName . ' ' . $this->lastName);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    public function getCin(): ?int
    {
        return $this->Cin;
    }

    public function setCin(int $Cin): self
    {
        $this->Cin = $Cin;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->Birthday;
    }

    public function setBirthday(\DateTimeInterface $Birthday): self
    {
        $this->Birthday = $Birthday;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): self
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->Phone_Number;
    }

    public function setPhoneNumber(int $Phone_Number): self
    {
        $this->Phone_Number = $Phone_Number;

        return $this;
    }




    public function getRoles()
    {
        $roles = $this->userRoles->map(function($role){
            return $role->getTitle();
        })->toArray();

        $roles[] ='ROLE_USER';

        return $roles;
    }

    public function getPassword()
    {
        return $this->hash;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUsername()
    {
        return $this->Email;
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return Collection|Role[]
     */
    public function getUserRoles(): Collection
    {
        return $this->userRoles;
    }

    public function addUserRole(Role $userRole): self
    {
        if (!$this->userRoles->contains($userRole)) {
            $this->userRoles[] = $userRole;
            $userRole->addUser($this);
        }

        return $this;
    }

    public function removeUserRole(Role $userRole): self
    {
        if ($this->userRoles->removeElement($userRole)) {
            $userRole->removeUser($this);
        }

        return $this;
    }

    public function getRegisteredAt(): \DateTimeImmutable
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt(\DateTimeImmutable $registeredAt): self
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }

    public function getAccountMustBeVerifiedBefore(): \DateTimeImmutable
    {
        return $this->accountMustBeVerifiedBefore;
    }

    public function setAccountMustBeVerifiedBefore(\DateTimeImmutable $accountMustBeVerifiedBefore): self
    {
        $this->accountMustBeVerifiedBefore = $accountMustBeVerifiedBefore;

        return $this;
    }

    public function getRegistrationToken(): ?string
    {
        return $this->registrationToken;
    }

    public function setRegistrationToken(?string $registrationToken): self
    {
        $this->registrationToken = $registrationToken;

        return $this;
    }

    public function getIsVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getAccountVerifiedAt(): ?\DateTimeImmutable
    {
        return $this->accountVerifiedAt;
    }

    public function setAccountVerifiedAt(?\DateTimeImmutable $accountVerifiedAt): self
    {
        $this->accountVerifiedAt = $accountVerifiedAt;

        return $this;
    }

    public function getForgotPasswordToken(): ?string
    {
        return $this->forgotPasswordToken;
    }

    public function setForgotPasswordToken(?string $forgotPasswordToken): self
    {
        $this->forgotPasswordToken = $forgotPasswordToken;

        return $this;
    }

    public function getForgotPasswordTokenRequestedAt(): ?\DateTimeImmutable
    {
        return $this->forgotPasswordTokenRequestedAt;
    }

    public function setForgotPasswordTokenRequestedAt(?\DateTimeImmutable $forgotPasswordTokenRequestedAt): self
    {
        $this->forgotPasswordTokenRequestedAt = $forgotPasswordTokenRequestedAt;

        return $this;
    }

    public function getForgotPasswordTokenMustBeVerifiedBefore(): ?\DateTimeImmutable
    {
        return $this->forgotPasswordTokenMustBeVerifiedBefore;
    }

    public function setForgotPasswordTokenMustBeVerifiedBefore(?\DateTimeImmutable $forgotPasswordTokenMustBeVerifiedBefore): self
    {
        $this->forgotPasswordTokenMustBeVerifiedBefore = $forgotPasswordTokenMustBeVerifiedBefore;

        return $this;
    }

    public function getForgotPasswordTokenVerifiedAt(): ?\DateTimeImmutable
    {
        return $this->ForgotPasswordTokenVerifiedAt;
    }

    public function setForgotPasswordTokenVerifiedAt(?\DateTimeImmutable $ForgotPasswordTokenVerifiedAt): self
    {
        $this->ForgotPasswordTokenVerifiedAt = $ForgotPasswordTokenVerifiedAt;

        return $this;
    }

    public function getIsEnabled(): ?bool
    {
        return $this->isEnabled;
    }

    public function setIsEnabled(bool $isEnabled): self
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setUser($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getUser() === $this) {
                $commentaire->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Conversation[]
     */
    public function getConversations(): Collection
    {
        return $this->conversations;
    }

    public function addConversation(Conversation $conversation): self
    {
        if (!$this->conversations->contains($conversation)) {
            $this->conversations[] = $conversation;
            $conversation->setUser1($this);
        }

        return $this;
    }

    public function removeConversation(Conversation $conversation): self
    {
        if ($this->conversations->removeElement($conversation)) {
            // set the owning side to null (unless already changed)
            if ($conversation->getUser1() === $this) {
                $conversation->setUser1(null);
            }
        }

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * @return Collection|Conversation[]
     */
    public function getConversationsRecus(): Collection
    {
        return $this->conversationsRecus;
    }

    public function addConversationsRecu(Conversation $conversationsRecu): self
    {
        if (!$this->conversationsRecus->contains($conversationsRecu)) {
            $this->conversationsRecus[] = $conversationsRecu;
            $conversationsRecu->setUser2($this);
        }

        return $this;
    }

    public function removeConversationsRecu(Conversation $conversationsRecu): self
    {
        if ($this->conversationsRecus->removeElement($conversationsRecu)) {
            // set the owning side to null (unless already changed)
            if ($conversationsRecu->getUser2() === $this) {
                $conversationsRecu->setUser2(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setUser($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getUser() === $this) {
                $message->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->addParticipant($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            $event->removeParticipant($this);
        }

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getSupplierevents(): Collection
    {
        return $this->supplierevents;
    }

    public function addSupplierevent(Event $supplierevent): self
    {
        if (!$this->supplierevents->contains($supplierevent)) {
            $this->supplierevents[] = $supplierevent;
            $supplierevent->setSupplier($this);
        }

        return $this;
    }

    public function removeSupplierevent(Event $supplierevent): self
    {
        if ($this->supplierevents->removeElement($supplierevent)) {
            // set the owning side to null (unless already changed)
            if ($supplierevent->getSupplier() === $this) {
                $supplierevent->setSupplier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SpecialEvent[]
     */
    public function getSpecialEvents(): Collection
    {
        return $this->specialEvents;
    }

    public function addSpecialEvent(SpecialEvent $specialEvent): self
    {
        if (!$this->specialEvents->contains($specialEvent)) {
            $this->specialEvents[] = $specialEvent;
            $specialEvent->setParticipants($this);
        }

        return $this;
    }

    public function removeSpecialEvent(SpecialEvent $specialEvent): self
    {
        if ($this->specialEvents->removeElement($specialEvent)) {
            // set the owning side to null (unless already changed)
            if ($specialEvent->getParticipants() === $this) {
                $specialEvent->setParticipants(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SpecialEvent[]
     */
    public function getSuppliersevents(): Collection
    {
        return $this->suppliersevents;
    }

    public function addSuppliersevent(SpecialEvent $suppliersevent): self
    {
        if (!$this->suppliersevents->contains($suppliersevent)) {
            $this->suppliersevents[] = $suppliersevent;
            $suppliersevent->setSupplier($this);
        }

        return $this;
    }

    public function removeSuppliersevent(SpecialEvent $suppliersevent): self
    {
        if ($this->suppliersevents->removeElement($suppliersevent)) {
            // set the owning side to null (unless already changed)
            if ($suppliersevent->getSupplier() === $this) {
                $suppliersevent->setSupplier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProductowner(): Collection
    {
        return $this->productowner;
    }

    public function addProductowner(Product $productowner): self
    {
        if (!$this->productowner->contains($productowner)) {
            $this->productowner[] = $productowner;
            $productowner->setSupplier($this);
        }

        return $this;
    }

    public function removeProductowner(Product $productowner): self
    {
        if ($this->productowner->removeElement($productowner)) {
            // set the owning side to null (unless already changed)
            if ($productowner->getSupplier() === $this) {
                $productowner->setSupplier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Field[]
     */
    public function getFields(): Collection
    {
        return $this->fields;
    }

    public function addField(Field $field): self
    {
        if (!$this->fields->contains($field)) {
            $this->fields[] = $field;
            $field->setBooker($this);
        }

        return $this;
    }

    public function removeField(Field $field): self
    {
        if ($this->fields->removeElement($field)) {
            // set the owning side to null (unless already changed)
            if ($field->getBooker() === $this) {
                $field->setBooker(null);
            }
        }

        return $this;
    }


}
