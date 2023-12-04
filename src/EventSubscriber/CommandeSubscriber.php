<?php

    namespace App\EventSubscriber;

    use App\Entity\Commande;
    use App\Entity\Detail;
    use Doctrine\Common\EventSubscriber;
    use Doctrine\ORM\Events;
    use Doctrine\Persistence\Event\LifecycleEventArgs;
    use Symfony\Component\Mailer\MailerInterface;
    use Symfony\Component\Mime\Email;
    use App\Service\MailService;

    class CommandeSubscriber implements EventSubscriber
    {
        private $ms;
        private $mailer;

        public function __construct(MailService $ms, MailerInterface $mailer)
        {
            $this->ms = $ms;
            $this->mailer = $mailer;
        }

        public function getSubscribedEvents()
        {
            //retourne un tableau d'événements (prePersist, postPersist, preUpdate etc...)
            return [
                //événement déclenché après l'insert dans la base de donnée
                Events::postPersist,
            ];
        }

        public function postPersist(LifecycleEventArgs $args)
        {
    //     $args->getObject() nous retourne l'entité concernée par l'événement postPersist
            $entity = $args->getObject();

    //     Vérifier si l'entité est un nouvel objet de type Commande;
    //    Si l'objet persité n'est pas de type Commande, on ne veut pas que le Subscriber se déclenche!
            if ($entity instanceof Commande) {

                $user = $entity->getUtilisateur();

                $email = $user->getEmail();

                $this->ms->sendMail('service-commande-the-district@hotmail.com', $email, 'Confirmation de la commande', 'Bonjour, nous vous confirmons que votre commande a bien été prise en compte.');

                // $email = (new Email())
                //     ->from('service-commande-the-district@hotmail.com')
                //     ->to('user@hotmail.com')
                //     ->subject('Confirmation de la commande')
                //     ->text('Bonjour, nous vous confirmons que votre commande a bien été prise en compte.');
                //     // ->html('<h1>'.'Confirmation de la commande'.'</h1><p>'.'Bonjour, nous vous confirmons que votre commande a bien été prise en compte.'.'</p>');

                // $this->mailer->send($email);
            }
        }
    }