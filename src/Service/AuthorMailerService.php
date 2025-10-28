<?php
// src/Service/AuthorMailerService.php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class AuthorMailerService
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    // Méthode pour envoyer un email de notification
    public function notifyAuthor(): void
    {
        $email = (new Email())
            ->from('noreply@bibliotheque.com')
            ->to('nourchrif004@gmail.com')
            ->subject('Nouveau livre ajouté !')
            ->text("Bonjour un livre a été ajouté avec succès.");

        $this->mailer->send($email);
    }
}