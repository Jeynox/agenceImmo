<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Enum\AdType;
use App\Enum\AdStatus;
use App\Entity\AdOption;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AdFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $adTypes = [AdType::Appartement, AdType::Maison];
        $adStatus = [AdStatus::Louer, AdStatus::Vendre];

        $faker = Factory::create();

        for ($i = 0; $i <= 9; $i++) {
            $ad = new Ad();
            $ad->setTitle('Title ' . $i)
                ->setDescription($faker->paragraph())
                ->setStatus($adStatus[array_rand($adStatus)])
                ->setPrice($ad->getStatus() === 'Louer' ? rand(1000, 5000) : rand(400000, 1000000))
                ->setSurface(rand(30, 200))
                ->setType($adTypes[array_rand($adTypes)])
                ->setAddress($i . 'rue de Paris')
                ->setPostalCode("7500" . $i)
                ->setCity('Paris')
                ->setCreatedAt(new \DateTimeImmutable())
                ->setAgence($this->getReference('agence_' . rand(1, 5)));

            $adOption1 = new AdOption();
            $adOption1->setAd($ad)
                ->setChoice($this->getReference('option_1'))
                ->setValue(['nbChambres' => rand(1, 5)]);

            $adOption2 = new AdOption();
            $adOption2->setAd($ad)
                ->setChoice($this->getReference('option_2'))
                ->setValue(['surfaceTerrain' => rand(50, 500)]);

            $adOption3 = new AdOption();
            $adOption3->setAd($ad)
                ->setChoice($this->getReference('option_3'))
                ->setValue(['meublé' => rand(0, 1)]);

            $manager->persist($adOption1);
            $manager->persist($adOption2);
            $manager->persist($adOption3);
            $manager->persist($ad);
            $manager->persist($ad);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AgenceFixtures::class,
        ];
    }
}
