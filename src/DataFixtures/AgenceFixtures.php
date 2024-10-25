<?php

namespace App\DataFixtures;

use App\Entity\Agence;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AgenceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $agence = new Agence();
            $agence->setName('Agence' . $i)
                ->setAdress($i . ' rue de Paris')
                ->setCity('Paris')
                ->setPostalCode('7500' . $i)
                ->setEmail('contact' . $i . '@agence.com')
                ->setWebsite('https://www.agence' . $i . '.com')
                ->setUser($this->getReference('user_agency_' . rand(1, 3)));

            $this->addReference('agence_' . $i, $agence);

            $manager->persist($agence);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
