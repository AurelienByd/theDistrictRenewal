<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Categorie;
use App\Entity\Plat;
use App\DataFixtures\PlatsFixtures;

class CategoriesFixtures extends Fixture
{
        // pour relier l'id de la catégorie et l'envoyer dans PlatsFixtures.php pour la table `plat` dans la colonne `categorie_id`
    public const CATEGORIE_PIZZA_REFERENCE = 4;
    public const CATEGORIE_PASTA_REFERENCE = 10;
    public const CATEGORIE_VEGGIE_REFERENCE = 14;

    public function load(ObjectManager $manager): void
    {
        $categorie1 = new Categorie();

        $categorie1->setId(4);
        $categorie1->setLibelle("Pizza");
        $categorie1->setImage("pizza_cat.jpg");
        $categorie1->setActive(true);

            // pour relier l'id de la catégorie et l'envoyer dans PlatsFixtures.php pour la table `plat` dans la colonne `categorie_id`
        $this->addReference(self::CATEGORIE_PIZZA_REFERENCE, $categorie1);

        $manager->persist($categorie1); // persist qui permet de spécifier à doctrine qu'une nouvelle entité doit être persisté

        $categorie2 = new Categorie();

        $categorie2->setId(10);
        $categorie2->setLibelle("Pasta");
        $categorie2->setImage("pasta_cat.jpg");
        $categorie2->setActive(true);

            // pour relier l'id de la catégorie et l'envoyer dans PlatsFixtures.php pour la table `plat` dans la colonne `categorie_id`
        $this->addReference(self::CATEGORIE_PASTA_REFERENCE, $categorie2);

        $manager->persist($categorie2);

        $categorie3 = new Categorie();

        $categorie3->setId(14);
        $categorie3->setLibelle("Veggie");
        $categorie3->setImage("veggie_cat.jpg");
        $categorie3->setActive(true);

            // pour relier l'id de la catégorie et l'envoyer dans PlatsFixtures.php pour la table `plat` dans la colonne `categorie_id`
        $this->addReference(self::CATEGORIE_VEGGIE_REFERENCE, $categorie3);

        $manager->persist($categorie3);

            // empêcher l'auto incrément
        $metadata = $manager->getClassMetaData(Categorie::class);
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

        $manager->flush(); // flush qui indique à doctrine de générer le code sql pour mettre à jour votre base
    }
}
