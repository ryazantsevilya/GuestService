<?php

namespace App\Service;

use App\DTO\GuestDTO;
use App\Entity\Guest;
use App\Repository\CountryRepository;
use App\Repository\GuestRepository;
use App\Validator\GuestValidator;
use Doctrine\ORM\EntityManagerInterface;

class GuestService
{
    public function __construct(
        private EntityManagerInterface $em,
        private CountryRepository $countryRepository,
        private GuestRepository $guestRepository,
        private GuestValidator $validator
    ) {
    }

    public function getGuest($id): ?Guest
    {
        return $this->guestRepository->find($id);
    }

    public function createGuest(GuestDTO $dto): Guest
    {
        $this->validator->validate($dto);

        $guest = new Guest();
        $guest->setFirstName($dto->getFirstName());
        $guest->setLastName($dto->getLastName());
        $guest->setPhonenumber($dto->getPhonenumber());
        $guest->setEmail($dto->getEmail());

        $country = $dto->getCountryId() === null ?
                $this->countryRepository->getCountryByPhonenumber($dto->getPhonenumber()) :
                $this->countryRepository->find($dto->getCountryId());

        $guest->setCountry($country);

        $this->em->persist($guest);
        $this->em->flush();

        return $guest;
    }

    public function deleteGuest(int $id): bool
    {
        $guest = $this->guestRepository->find($id);

        if (!$guest) {
            return false;
        }

        $this->em->remove($guest);
        $this->em->flush();

        return true;
    }

    public function editGuest(int $id, GuestDTO $dto): Guest
    {
        $this->validator->validate($dto, GuestValidator::CONTEXT_EDIT);
        
        $guest = $this->guestRepository->find($id);

        $guest->setFirstName($dto->getFirstName());
        $guest->setLastName($dto->getLastName());
        $guest->setPhonenumber($dto->getPhonenumber());
        $guest->setEmail($dto->getEmail());

        $country = $dto->getCountryId() === null ?
            $this->countryRepository->getCountryByPhonenumber($dto->getPhonenumber()) :
            $this->countryRepository->find($dto->getCountryId());

        $guest->setCountry($country);

        $this->em->flush();

        return $guest;
    }
}
