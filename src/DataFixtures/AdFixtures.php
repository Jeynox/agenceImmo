<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Enum\AdType;
use App\Enum\AdStatus;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AdFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $adTypes = [AdType::Appartement, AdType::Maison];
        $adStatus = [AdStatus::Louer, AdStatus::Vendre];

        for ($i = 0; $i <= 9; $i++) {
            $ad = new Ad();
            $ad->setTitle('Title ' . $i)
                ->setDescription('Description ' . $i)
                ->setStatus($adStatus[array_rand($adStatus)])
                ->setPrice( $ad->getStatus() === 'Louer' ? rand(1000, 5000) : rand(400000, 1000000))
                ->setSurface(rand(30, 200))
                ->setType($adTypes[array_rand($adTypes)])
                ->setAddress($i . 'rue de Paris')
                ->setPostalCode("7500" . $i)
                ->setCity('Paris')
                ->setCreatedAt(new \DateTimeImmutable())
                ->setAgence($this->getReference('agence_' . rand(1,5)));
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
