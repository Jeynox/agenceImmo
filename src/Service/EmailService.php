<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendConfirmationEmail(string $to, string $confirmationUrl)
    {
        $email = (new Email())
            ->from('test@test.com')
            ->to($to)
            ->subject('Confirmation de votre inscription')
            ->html("<p>Merci de vous être inscrit sur projetImmo. Veuillez confirmer votre inscription en cliquant sur le lien suivant :</p><a href=\"$confirmationUrl\">Confirmer mon inscription</a>");

        $this->mailer->send($email);
    }
}