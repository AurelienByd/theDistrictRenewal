<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

class MailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer){

        $this->mailer = $mailer;

    }

    public function sendMail($expediteur, $destinataire, $sujet, $message){

        $email = (new Email())
            ->from($expediteur)
            ->to($destinataire)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($sujet)
            ->text($message)
            ->html('<h1>'.$sujet.'</h1><p>'.$message.'</p>');

        $this->mailer->send($email);
    
    }

}