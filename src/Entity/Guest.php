<?php

namespace App\Entity;

use App\Repository\GuestRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity(repositoryClass: GuestRepository::class)]
class Guest extends AbstractEntity
{
    #[Column(type: 'string', length: 255)]
    private string $firstName;

    #[Column(type: 'string', length: 255)]
    private string $lastName;

    #[Column(type: 'string', unique: true, length: 15)]
    private string $phonenumber;

    #[Column(type: 'string', length: 255, nullable: true)]
    private ?string $email = null;

    #[ManyToOne(targetEntity: Country::class)]
    #[JoinColumn(name: 'country_id', referencedColumnName: 'id')]
    private ?Country $country = null;

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhonenumber(): string
    {
        return $this->phonenumber;
    }

    public function setPhonenumber(string $phonenumber): self
    {
        $this->phonenumber = $phonenumber;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
