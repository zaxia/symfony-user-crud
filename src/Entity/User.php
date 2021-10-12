<?php
// src/Entity/User.php
namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
*/
class User
{
    
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255)
     */
    private $login;

    /** @ORM\Column(type="string", length=255) */
    private $password;

    /** @ORM\Column(type="string", length=255) */
    private $firstname;

    /** @ORM\Column(type="string", length=255) */
    private $lastname;

    /** @ORM\Column(type="datetime", name="createdAt") */
    private $createdAt;

    /** @ORM\Column(type="datetime", name="updatedAt") */
    private $updatedAt;

    
    function __construct() {
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setLogin($login): ?User
    {
        $this->login = $login;
        return $this;
    }

    public function setPassword($password): ?User
    {
        $this->password = $password;
        return $this;
    }

    public function setFirstname($firstname): ?User
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function setLastname($lastname): ?User
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function setCreatedAt($createdAt): ?User
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setUpdatedAt($updatedAt): ?User
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}