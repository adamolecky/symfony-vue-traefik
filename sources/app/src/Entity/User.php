<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use function md5;
use function password_hash;
use function substr;
use function time;

use const PASSWORD_DEFAULT;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank()
     */
    private ?string $fullName;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank()
     */
    private ?string $password;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private ?string $email;

    /**
     * @ORM\ManyToOne(targetEntity=Role::class, inversedBy="users", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Role $role;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getPassword(): ?string
    {
        $this->password = substr($this->password, 0, -5);

        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
        // TODO: side note: as you can see salt is here only for storing in DB - when wee retrieve data from DB, we skip
        // last 5 chars from string. This is way that even when somebody manages to get to passwords and decrypt them it
        // will be gibberish.
        $meanSalt = substr(md5((string)time()), 1, 5);
        $this->password = "{$hash}{$meanSalt}";

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRoleString(string $roleString): self
    {
        $role = new Role();
        $role->addUser($this);
        $role->setType($roleString);
        $this->role = $role;

        return $this;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }
}
