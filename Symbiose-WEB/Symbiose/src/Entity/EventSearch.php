<?php
namespace App\Entity;

class EventSearch{

    /**
     * @var string|null
     */
    private $Type;

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->Type;
    }

    /**
     * @param string|null $Type
     * @return EventSearch
     */
    public function setType(string $Type): EventSearch
    {
        $this->Type = $Type;
        return $this;
    }






}