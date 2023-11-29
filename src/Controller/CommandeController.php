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

#[Route('/commande', name: 'app_commande_')]
class CommandeController extends AbstractController
{
    #[Route('/ajout', name: 'add')]
    public function commande(SessionInterface $session, PlatRepository $platRepository, EntityManagerInterface $entityManager, Request $request): Response
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
        $entityManager>flush();
        // $session->remove('panier');
        // dd($session);

        return $this->redirectToRoute('app_accueil');

        }

        return $this->render('commande/commande.html.twig', [
            'controller_name' => 'CommandeController',
            'commandeForm' => $form->createView(),
        ]);
    }
}
