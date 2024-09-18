<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Generator;

class CountryFixture extends Fixture implements FixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as $data) {
            $country = $this->getCountry($data);

            $manager->persist($country);
        }

        $manager->flush();
    }

    private function getCountry(array $data): Country
    {
        $country = new Country();
        $country->setName($data[1]);
        $country->setPhonePrefix($data[2]);

        return $country;
    }

    private function getData(): Generator
    {
        $file = fopen(__DIR__ . DIRECTORY_SEPARATOR . 'country.csv', 'r');

        while (($line = fgetcsv($file)) !== false) {
            yield $line;
        }

        fclose($file);
    }
}
