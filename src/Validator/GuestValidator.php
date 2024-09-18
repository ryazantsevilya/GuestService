<?php

namespace App\Validator;

use App\DTO\GuestDTO;
use App\Repository\CountryRepository;
use App\Repository\GuestRepository;
use Symfony\Component\Validator\Exception\ValidatorException;

class GuestValidator
{
    public const CONTEXT_EDIT = 'EDIT';

    public function __construct(
        private CountryRepository $countryRepository,
        private GuestRepository $guestRepository
    ) {
    }

    public function validate(GuestDTO $guestDTO, ?string $context = null)
    {
        if (!$guestDTO->getFirstName()) {
            throw new ValidatorException('Имя не указано');
        }

        if (!$guestDTO->getLastName()) {
            throw new ValidatorException('Фамилия не указана');
        }

        if (strlen($guestDTO->getFirstName()) > 255) {
            throw new ValidatorException('Имя не должно быть длиннее 255 символов');
        }

        $this->validatePhonenumder($guestDTO, $context);

        if ($guestDTO->getEmail()) {
            $this->validateEmail($guestDTO, $context);
        }

        if (
            $guestDTO->getCountryId()
            && !($this->countryRepository->find($guestDTO->getCountryId()))
        ) {
            throw new ValidatorException('Страна не нейдена');
        }
    }

    private function validateEmail(GuestDTO $guestDTO, ?string $context = null): bool
    {
        $email = $guestDTO->getEmail();

        if (strlen($email) > 255) {
            throw new ValidatorException('Email не должен быть длиннее 255 символов');
        }

        if (
            $guestDTO->getId()
            && $context === self::CONTEXT_EDIT
        ) {
            $findGuest = $this->guestRepository->find($guestDTO->getId());

            if ($findGuest->getEmail() === $guestDTO->getEmail()) {
                return true;
            }
        }

        if ($this->guestRepository->findOneBy(['email' => $email])) {
            throw new ValidatorException('Пользователь с таким email уже существует');
        }

        return true;
    }

    private function validatePhonenumder(GuestDTO $guestDTO, ?string $context = null): bool
    {
        $phonenumber = $guestDTO->getPhonenumber();

        if (!$phonenumber) {
            throw new ValidatorException('Не указан номер телефона');
        }

        if (
            $guestDTO->getId()
            && $context === self::CONTEXT_EDIT
        ) {
            $findGuest = $this->guestRepository->find($guestDTO->getId());

            if ($findGuest->getPhonenumber() === $phonenumber) {
                return true;
            }
        }

        if ($this->guestRepository->findOneBy(['phonenumber' => $phonenumber])) {
            throw new ValidatorException('Пользователь с таким номером телефона уже существует');
        }

        if (
            strlen($phonenumber) < 9 
            || strlen($phonenumber) > 13
        ) {
            throw new ValidatorException('Неверный формат номера телефона');
        }

        // Формат телефона без +
        if (!ctype_digit($phonenumber)) {
            throw new ValidatorException('Неверный формат номера телефона');
        }

        return true;
    }
}
