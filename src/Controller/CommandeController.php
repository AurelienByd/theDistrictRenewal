<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeFormType;
use App\Entity\Detail;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use App\Service\MailService;

#[Route('/commande', name: 'app_commande_')]
class CommandeController extends AbstractController
{
    #[Route('/ajout', name: 'add')]
    public function commande(SessionInterface $session, PlatRepository $platRepository, EntityManagerInterface $entityManager, Request $request, MailerInterface $mailer, MailService $ms): Response
    {

        $panier = $session->get('panier', []);

        if($panier === []){
            $this->addFlash('message', 'Votre panier est vide');
            return $this->redirectToRoute('app_accueil');
        }

        // dd($panier);

        // $totalQuantity = 0;

        $total = 0;

        foreach($panier as $id => $quantity) {
            $plat = $platRepository->find($id);

            // $totalQuantity += $quantity;

            $total += $plat->getPrix() * $quantity;
        }

        $form = $this->createForm(CommandeFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        // Traitement des données du formulaire
        $data = $form->getData();

        $commande = new Commande();

        //On remplit la commande
        $commande->setDateCommande(new \DateTime());
        $commande->setTotal($total);
        $commande->setEtat(0);
        $commande->setUtilisateur($this->getUser());

        // dd($commande);

        $commandeDetails = new Detail();

        //On crée le détail de commande
        $commandeDetails->setPlat($plat);
        $commandeDetails->setCommande($commande);
        $commandeDetails->setQuantite($quantity);

        // dd($commandeDetails);

        //On persiste et on flush
        $entityManager->persist($commande);
        $entityManager->persist($commandeDetails);
        $entityManager->flush();

        // $email = (new Email())
        //     ->from('service-commande-the-district@hotmail.com')
        //     ->to('user@hotmail.com')
        //     //->cc('cc@example.com')
        //     //->bcc('bcc@example.com')
        //     //->replyTo('fabien@example.com')
        //     //->priority(Email::PRIORITY_HIGH)
        //     ->subject('Confirmation de la commande')
        //     ->text('Bonjour, nous vous confirmons que votre commande a bien été prise en compte.')
        //     ->html('<h1>'.'Confirmation de la commande'.'</h1><p>'.'Bonjour, nous vous confirmons que votre commande a bien été prise en compte.'.'</p>');

        //     $mailer->send($email);

        //     //envoi de mail avec notre service MailService
        //     $ms->sendMail('service-commande-the-district@hotmail.com', 'user@hotmail.com', 'Confirmation de la commande', 'Bonjour, nous vous confirmons que votre commande a bien été prise en compte.' );

        $session->remove('panier');

        return $this->redirectToRoute('app_accueil');

        }

        return $this->render('commande/commande.html.twig', [
            'controller_name' => 'CommandeController',
            'commandeForm' => $form->createView(),
        ]);
    }
}
