<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;

#[Entity(repositoryClass: CountryRepository::class)]
class Country extends AbstractEntity
{
    #[Column(type: 'string', length: 100)]
    private string $name;

    #[Column(type: 'string', length: 10)]
    private string $phonePrefix;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPhonePrefix(): string
    {
        return $this->phonePrefix;
    }

    public function setPhonePrefix(string $phonePrefix): self
    {
        $this->phonePrefix = $phonePrefix;

        return $this;
    }
}
