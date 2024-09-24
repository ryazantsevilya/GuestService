<?php

namespace App\DTO;

class GuestDTO
{
    private ?int $id = null;
    private ?string $firstName = null;
    private ?string $lastName = null;
    private ?string $phonenumber = null;
    private ?string $email = null;
    private ?int $countryId = null;

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getPhonenumber(): ?string
    {
        return $this->phonenumber;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getCountryId(): ?int
    {
        return $this->countryId;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function setPhonenumber(string $phonenumber): self
    {
        if ($phonenumber[0] === '+') {
            unset($phonenumber[0]);
        }
        
        $this->phonenumber = $phonenumber;

        return $this;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setCountryId(int $countryId): self
    {
        $this->countryId = $countryId;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }
}
