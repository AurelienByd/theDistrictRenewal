<?php

    namespace App\EventSubscriber;

    use App\Entity\Commande;
    use App\Entity\Detail;
    use App\Entity\Utilisateur;
    use Doctrine\Common\EventSubscriber;
    use Doctrine\ORM\Events;
    use Doctrine\Persistence\Event\LifecycleEventArgs;
    use Symfony\Component\Mailer\MailerInterface;
    use Symfony\Component\Mime\Email;
    use App\Service\MailService;

    class CommandeSubscriber implements EventSubscriber
    {
        private $ms;
        private $user;

        public function __construct(MailService $ms, Utilisateur $user)
        {
            $this->ms = $ms;
            $this->user = $user;
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
    //        $args->getObject() nous retourne l'entité concernée par l'événement postPersist
            $entity = $args->getObject();

    //     Vérifier si l'entité est un nouvel objet de type Commande;
    //    Si l'objet persité n'est pas de type Commande, on ne veut pas que le Subscriber se déclenche!
            if ($entity instanceof Commande && $entity instanceof Detail) {

                //     Envoyer un e-mail à l'admin

                $this->ms->sendMail('service-commande-the-district@hotmail.com', $this->user->getEmail(), 'Confirmation de la commande', 'Bonjour, nous vous confirmons que votre commande a bien été prise en compte.');

            }
        }
    }