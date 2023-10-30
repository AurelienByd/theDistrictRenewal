<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RgpdController extends AbstractController
{
    #[Route('/mentions_legales', name: 'app_mentions_legales')]
    public function mentionsLegales(): Response
    {
        return $this->render('rgpd/mentions_legales.html.twig', [
            'controller_name' => 'RgpdController',
        ]);
    }

    #[Route('/politique_de_confidentialite', name: 'app_politique_de_confidentialite')]
    public function politiqueDeConfidentialite(): Response
    {
        return $this->render('rgpd/politique_de_confidentialite.html.twig', [
            'controller_name' => 'RgpdController',
        ]);
    }
}
