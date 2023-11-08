<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\PlatRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class CatalogueController extends AbstractController
{
    //On va avoir souvent besoin d'injecter les respositories de nos entités dans les contrôleurs et les services
    //Pour ne pas les injecter dans chaque fonction, on va les instancier UNE SEULE fois dans le constructeur de notre contrôleur:
    //N'oubliez pas d'importer vos respositories (les lignes "use..." en haut de la page)

    private $platRepo;
    private $categorieRepo;
    private $em;

    public function __construct(PlatRepository $platRepo, CategorieRepository $categorieRepo, EntityManagerInterface $em)
    {
        $this->platRepo = $platRepo;
        $this->categorieRepo = $categorieRepo;
        $this->em = $em;
    }

    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {

        //on appelle la fonction `findAll()` du repository de la classe `Categorie` afin de récupérer toutes les catégories de la base de données;

        // $categories = $this->categorieRepo->findAll();
        $categories = $this->categorieRepo->getSomeCategories();
        $plats = $this->platRepo->getSomePlats();

        // dd($categories); 

        return $this->render('catalogue/index.html.twig', [
            'controller_name' => 'CatalogueController',
            'categories' => $categories,
            'plats' => $plats
        ]);
    }

    #[Route('/plats', name: 'app_plats')]
    public function plats(): Response
    {
        $plats = $this->platRepo->getSomePlats2();

        return $this->render('catalogue/plats.html.twig', [
            'controller_name' => 'CatalogueController',
            'plats' => $plats
        ]);
    }

    #[Route('/plats/{categorie_id}', name: 'app_plats_by_categorie')]
    public function platsByCategorie($categorie_id): Response
    {

        // $categorie = $this->categorieRepo->find($categorie_id);
        $categorie = $this->categorieRepo->affichTitreCat($categorie_id);
        $allPlatsByCat = $this->platRepo->allPlatsByCat($categorie_id);
        // $allPlatsByCat = $this->categorieRepo->allPlatsByCat($categorie_id);

        // dd($allPlatsByCat);
        
        return $this->render('catalogue/platsByCategorie.html.twig', [
            'controller_name' => 'CatalogueController',
            'categorie' => $categorie,
            'allPlatsByCat' => $allPlatsByCat
        ]);
    }

    #[Route('/categories', name: 'app_categories')]
    public function categories(): Response
    {
        $categories = $this->categorieRepo->getSomeCategories();

        return $this->render('catalogue/categories.html.twig', [
            'controller_name' => 'CatalogueController',
            'categories' => $categories
        ]);
    }
}
