<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UtilisateurRepository;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Form\UpdateFormType;


class ProfilController extends AbstractController
{
    private $userRepo;

    public function __construct(UtilisateurRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    #[Route('/profil/{user_email}', name: 'app_profil')]
    public function profil($user_email): Response
    {

        $users = $this->userRepo->infosUser($user_email);

        return $this->render('profil/profil.html.twig', [
            'controller_name' => 'ProfilController',
            'users' => $users
        ]);
    }

    #[Route('/update/{user_email}', name: 'app_update')]
    public function update(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, $user_email): Response
    {

        // $users = $this->userRepo->infosUser($user_email);

        $users = $entityManager->getRepository(Utilisateur::class)->findOneBy(['email'=> $user_email]);
        $form = $this->createForm(UpdateFormType::class, $users);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $users = $form->getData();
            // encode the plain password
            // $users->setPassword(
            //     $userPasswordHasher->hashPassword(
            //         $users,
            //         $form->get('plainPassword')->getData()
            //     )
            // );

            $entityManager->persist($users);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_accueil');
        }

        return $this->render('profil/update.html.twig', [
            'controller_name' => 'ProfilController',
            'updateForm' => $form->createView(),
            'users' => $users
        ]);
    }
}
