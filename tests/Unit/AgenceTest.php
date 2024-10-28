<?php

namespace App\Tests\Unit;

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
            ->setWebsite('agence.com');
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
        self::bootKernel();
        $container = static::getContainer();
        $agence = $this->getEntity();
        $agence->setName('');
        $errors = $container->get('validator')->validate($agence);

        $this->assertCount(2, $errors);
        $errorsMessages = ['This value should not be blank.', 'Le nom de l\'agence doit faire au moins 2 caractères',];

        $messagesErrorsFound = [];

        foreach ($errors as $error) {
            $messagesErrorsFound[] = $error->getMessage();
        }
        foreach ($errorsMessages as $errorMessage) {
            $this->assertContains($errorMessage, $messagesErrorsFound);
        }
    }
}
