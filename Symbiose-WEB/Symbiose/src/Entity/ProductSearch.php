<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class ProductSearch
{

    /**
     * @var string
     */
    public $q = '';

    /**
     * @var int|null
     */
    private $maxPrice;

    /**
     * @var int|null
     */
    private $minPrice;

    /**
     * @var boolean
     */
    public $State = false;


    /**
     * @return int|null
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     * @param int|null $maxPrice
     * @return ProductSearch
     */
    public function setMaxPrice(int $maxPrice): ProductSearch
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMinPrice(): ?int
    {
        return $this->minPrice;
    }

    /**
     * @param int|null $minPrice
     * @return ProductSearch
     */
    public function setMinPrice(int $minPrice): ProductSearch
    {
        $this->minPrice = $minPrice;
        return $this;
    }


}