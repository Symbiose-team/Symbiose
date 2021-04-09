<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @Vich\Uploadable()
 */
class Product
{

    const ARTICLE = [
        0 => 'Equipment',
        1 => 'Clothing'
    ];

    const STATE = [
        0 => 'Sold',
        1 => 'In Stock'
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @var File|null
     * @Assert\Image(mimeTypes="image/jpeg")
     * @Vich\UploadableField(mapping="products_image", fileNameProperty="filename")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *@Assert\NotBlank(message="Veuillez donner un nom a votre produit")
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez donner une description a votre produit")
     */
    private $Description;

    /**
     * @ORM\Column(type="decimal", nullable=false)
     * @Assert\NotBlank(message="Veuillez préciser un PRIX !")
     */
    private $Price;
    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Veuillez specifier le type de votre produit")
     */
    public $Type;

    /**
     * @ORM\Column(type="boolean" ,options={"default" = false})
     */
    private $State = false;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="productowner")
     */
    private $Supplier;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="productcomment")
     */
    private $comments;


    //THESE HERE ARE THE GETTERS AND SETTERS

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @param string|null $filename
     * @return Product
     */
    public function setFilename(?string $filename): Product
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $imageFile
     * @return Product
     */
    public function setImageFile(?File $imageFile): Product
    {
        $this->imageFile = $imageFile;
        if ($this->imageFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->Price;
    }

    public function setPrice(float $price): self
    {
        $this->Price = $price;

        return $this;
    }

    public function getFormattedPrice(): string
    {
        return number_format($this->Price, 0, '', ' ');
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $type): self
    {
        $this->Type = $type;

        return $this;
    }

    public function getArticleType(): string
    {
        return self::ARTICLE[$this->Type];
    }

    public function getState(): ?bool
    {
        return $this->State;
    }

    public function setState(bool $state): self
    {
        $this->State = $state;

        return $this;
    }
    public function getStateType(): string
    {
        return self::STATE[$this->State];
    }
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getSupplier(): ?User
    {
        return $this->Supplier;
    }

    public function setSupplier(?User $Supplier): self
    {
        $this->Supplier = $Supplier;

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Commentaire $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setProductcomment($this);
        }

        return $this;
    }

    public function removeComment(Commentaire $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getProductcomment() === $this) {
                $comment->setProductcomment(null);
            }
        }

        return $this;
    }


}
