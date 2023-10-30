<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ContactRepository;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, EntityManagerInterface $entityManager, ContactRepository $contactRepo): Response
    {
        $formContact = $this->createForm(ContactFormType::class);
        // nous utilisons la méthode handleRequest() pour traiter la requête HTTP actuelle et valider les données soumises
        $formContact->handleRequest($request);
        
        // Si le formulaire est soumis et si le formulaire est valide, nous pouvons accéder aux données du formulaire à l'aide de la méthode getData()
        if ($formContact->isSubmitted() && $formContact->isValid()) {

            //on crée une instance de Contact
            $message = new Contact();
            // Traitement des données du formulaire
            $data = $formContact->getData();
            //on stocke les données récupérées dans la variable $message
            $message = $data;

            $entityManager->persist($message);
            $entityManager->flush();

            // Redirection vers accueil
            return $this->redirectToRoute('app_accueil');
        }

            // Ce formulaire sera affiché à l'aide de la méthode render() dans la vue index.html.twig qui se trouve dans le répertoire contact
        return $this->render('contact/contact.html.twig', [
            'controller_name' => 'ContactController',
            'form' => $formContact
        ]);
    }
}
