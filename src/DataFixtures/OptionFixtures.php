<?php

namespace App\DataFixtures;

use App\Entity\Option;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OptionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $option1 = new Option();
        $option1->setName('nombre_chambres');
        $option1->setType('integer');
        $this->addReference('option_1', $option1);
        $manager->persist($option1);

        $option2 = new Option();
        $option2->setName('surface_terrain');
        $option2->setType('float');
        $this->addReference('option_2', $option2);
        $manager->persist($option2);

        $option3 = new Option();
        $option3->setName('meublé');
        $option3->setType('boolean');
        $this->addReference('option_3', $option3);
        $manager->persist($option3);

        $option4 = new Option();
        $option4->setName('jardin');
        $option4->setType('boolean');
        $this->addReference('option_4', $option4);
        $manager->persist($option4);

        $option5 = new Option();
        $option5->setName('parking');
        $option5->setType('boolean');
        $this->addReference('option_5', $option5);
        $manager->persist($option5);

        $option6 = new Option();
        $option6->setName('balcon');
        $option6->setType('boolean');
        $this->addReference('option_6', $option6);
        $manager->persist($option6);

        $option7 = new Option();
        $option7->setName('performance_énergétique');
        $option7->setType('select');
        $this->addReference('option_7', $option7);
        $manager->persist($option7);

        $option8 = new Option();
        $option8->setName('étage');
        $option8->setType('integer');
        $this->addReference('option_8', $option8);
        $manager->persist($option8);

        $option9 = new Option();
        $option9->setName('prix');
        $option9->setType('float');
        $this->addReference('option_9', $option9);
        $manager->persist($option9);

        $option10 = new Option();
        $option10->setName('ascenseur');
        $option10->setType('boolean');
        $this->addReference('option_10', $option10);
        $manager->persist($option10);

        $manager->flush();
    }
}
