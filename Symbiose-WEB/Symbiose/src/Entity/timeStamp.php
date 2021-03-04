<?php
namespace App\Entity;
trait timeStamp
{
/**
 * @ORM\Column (type="datetime")
 */

 private $createdAt;

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
/**
 * @ORM\PrePersist()
 */
public function PrePersit(){
    $this->createdAt=new \DateTime();
}



}




?>