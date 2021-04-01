<?php

namespace App\Entity;

use App\Repository\CartItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CartItemRepository::class)
 */
class CartItem
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
    private $quantity = 0;

    /**
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $product;


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product): void
    {
        $this->product = $product;
    }


}
