<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact {
    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length (min="2",max="100")
     */
    private $fullname;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/[0-9]{8}/")
     *
     */
    private $phone;

    /**
     * @return string|null
     */
    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    /**
     * @param string|null $fullname
     * @return Contact
     */
    public function setFullname(?string $fullname): Contact
    {
        $this->fullname = $fullname;
        return $this;
    }

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;
    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min="8")
     */
    private $sujet;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min="10")
     */
    private $message;

}