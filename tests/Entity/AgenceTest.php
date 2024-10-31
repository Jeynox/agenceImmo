<?php

namespace App\Tests\Entity;

use App\Entity\Agence;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AgenceTest extends KernelTestCase
{
    public function getEntity(): Agence
    {
        $agence = new Agence();
        return $agence->setName('SuperAgence')
            ->setAdress('12 rue de Paris')
            ->setCity('Paris')
            ->setPostalCode('75000')
            ->setEmail('agence@test.com')
            ->setWebsite('https://agence.com');
    }

    public function assertHasErrors(Agence $agence, int $number = 0)
    {
        self::bootKernel();
        $container = static::getContainer();

        $errors = $container->get('validator')->validate($agence);
        $messages = [];
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }
        $this->assertCount($number, $errors, implode(',', $messages));
    }

    public function testEntityIsValid(): void
    {
        $agence = $this->getEntity();

        $this->assertHasErrors($agence, 0);
    }

    public function testInvalidName(): void
    {
        $agence = $this->getEntity()->setName('');
        $this->assertHasErrors($agence, 2); 

        // Vérifie que le nom de l'agence a moins de 2 caractères
        $agence = $this->getEntity()->setName('A');
        $this->assertHasErrors($agence, 1);
    }

    public function testInvalidAdress(): void
    {
        $agence = $this->getEntity()->setAdress('');
        $this->assertHasErrors($agence, 2); 
    }

    public function testInvalidCity(): void
    {
        $agence = $this->getEntity()->setCity('');
        $this->assertHasErrors($agence, 1); 
    }

    public function testInvalidPostalCode(): void
    {
        $agence = $this->getEntity()->setPostalCode('');
        $this->assertHasErrors($agence, 1);

        // Vérifie que le code postal ne comporte uniquement 5 chiffres
        $agence = $this->getEntity()->setPostalCode('7500'); 
        $this->assertHasErrors($agence, 1);
    }

    public function testInvalidEmail(): void
    {
        $agence = $this->getEntity()->setEmail('');
        $this->assertHasErrors($agence, 1); 

        // Vérifie que le format de l'email est valide
        $agence = $this->getEntity()->setEmail('test'); 
        $this->assertHasErrors($agence, 1);
    }

    public function testInvalidWebsite(): void
    {
        $agence = $this->getEntity()->setWebsite('');
        $this->assertHasErrors($agence, 1);
        
        // Vérifie que le format de url est valide
        $agence = $this->getEntity()->setWebsite('test.com');
        $this->assertHasErrors($agence, 1); 
    }
}
