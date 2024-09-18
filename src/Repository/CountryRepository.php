<?php

namespace App\Repository;

use App\Entity\Country;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CountryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Country::class);
    }

    public function getCountryByPhonenumber(string $phoneNumber): Country
    {
        $prefixs = [
            $phoneNumber[0],
            substr($phoneNumber, 0, 2),
            substr($phoneNumber, 0, 3),
            substr($phoneNumber, 0, 4),
        ];

        return $this->createQueryBuilder('c')
                ->where('c.phonePrefix in (:prefixs)')
                ->setParameter('prefixs', $prefixs)
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
    }
}
