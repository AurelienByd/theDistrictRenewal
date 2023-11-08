<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Plat;
use App\Entity\Categorie;
use App\DataFixtures\CategoriesFixtures;

class PlatsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $plat1 = new Plat();

        $plat1->setId(5);
        $plat1->setLibelle("Pizza Bianca");
        $plat1->setDescription("Une pizza fine et croustillante garnie de crème mascarpone légèrement citronnée et de tranches de saumon fumé, le tout relevé de baies roses et de basilic frais.");
        $plat1->setPrix(15.40);
        $plat1->setImage("pizza-salmon.png");
            // on intègre la référence créée dans CategoriesFixtures.php
        $plat1->setCategorie($this->getReference(CategoriesFixtures::CATEGORIE_PIZZA_REFERENCE));
        $plat1->setActive(true);

        $manager->persist($plat1); // persist qui permet de spécifier à doctrine qu'une nouvelle entité doit être persisté

        $plat2 = new Plat();

        $plat2->setId(14);
        $plat2->setLibelle("Pizza Margherita");
        $plat2->setDescription("Une authentique pizza margarita, un classique de la cuisine italienne! Une pâte faite maison, une sauce tomate fraîche, de la mozzarella Fior di latte, du basilic, origan, ail, sucre, sel & poivre...");
        $plat2->setPrix(15.40);
        $plat2->setImage("pizza-margherita.jpg");
            // on intègre la référence créée dans CategoriesFixtures.php
        $plat2->setCategorie($this->getReference(CategoriesFixtures::CATEGORIE_PIZZA_REFERENCE));
        $plat2->setActive(true);

        $manager->persist($plat2);

        $plat3 = new Plat();

        $plat3->setId(19);
        $plat3->setLibelle("Pizza aux épinards et à l'ail");
        $plat3->setDescription("Pizza à base d'épinards et d'ail");
        $plat3->setPrix(15.00);
        $plat3->setImage("Food-Name-8298.jpg");
            // on intègre la référence créée dans CategoriesFixtures.php
        $plat3->setCategorie($this->getReference(CategoriesFixtures::CATEGORIE_PIZZA_REFERENCE));
        $plat3->setActive(false);

        $manager->persist($plat3);

        $plat4 = new Plat();

        $plat4->setId(12);
        $plat4->setLibelle("Spaghetti aux légumes");
        $plat4->setDescription("Un plat de spaghetti au pesto de basilic et légumes poêlés, très parfumé et rapide");
        $plat4->setPrix(10.00);
        $plat4->setImage("spaghetti-legumes.jpg");
            // on intègre la référence créée dans CategoriesFixtures.php
        $plat4->setCategorie($this->getReference(CategoriesFixtures::CATEGORIE_PASTA_REFERENCE));
        $plat4->setActive(true);

        $manager->persist($plat4);

        $plat5 = new Plat();

        $plat5->setId(16);
        $plat5->setLibelle("Lasagnes");
        $plat5->setDescription("Découvrez notre recette des lasagnes, l'une des spécialités italiennes que tout le monde aime avec sa viande hachée et gratinée à l'emmental. Et bien sûr, une inoubliable béchamel à la noix de muscade.");
        $plat5->setPrix(12.00);
        $plat5->setImage("lasagnes_viande.jpg");
            // on intègre la référence créée dans CategoriesFixtures.php
        $plat5->setCategorie($this->getReference(CategoriesFixtures::CATEGORIE_PASTA_REFERENCE));
        $plat5->setActive(true);

        $manager->persist($plat5);

        $plat6 = new Plat();

        $plat6->setId(17);
        $plat6->setLibelle("Tagliatelles au saumon");
        $plat6->setDescription("Découvrez notre recette délicieuse de tagliatelles au saumon frais et à la crème qui qui vous assure un véritable régal!");
        $plat6->setPrix(12.00);
        $plat6->setImage("tagliatelles_saumon.webp");
            // on intègre la référence créée dans CategoriesFixtures.php
        $plat6->setCategorie($this->getReference(CategoriesFixtures::CATEGORIE_PASTA_REFERENCE));
        $plat6->setActive(false);

        $manager->persist($plat6);

        $plat7 = new Plat();

        $plat7->setId(15);
        $plat7->setLibelle("Courgettes farcies");
        $plat7->setDescription("Voici une recette équilibrée à base de courgettes, quinoa et champignons, 100% vegan et sans gluten!");
        $plat7->setPrix(8.00);
        $plat7->setImage("courgettes_farcies.jpg");
            // on intègre la référence créée dans CategoriesFixtures.php
        $plat7->setCategorie($this->getReference(CategoriesFixtures::CATEGORIE_VEGGIE_REFERENCE));
        $plat7->setActive(true);

        $manager->persist($plat7);

        $plat8 = new Plat();

        $plat8->setId(22);
        $plat8->setLibelle("Quinoa aux potimarrons");
        $plat8->setDescription("Quinoa, potimarron, echalotte, curmin, curcuma, cannelle, ail, coriandre, noisette");
        $plat8->setPrix(30.00);
        $plat8->setImage("recette-quinoa-potimarron.webp");
            // on intègre la référence créée dans CategoriesFixtures.php
        $plat8->setCategorie($this->getReference(CategoriesFixtures::CATEGORIE_VEGGIE_REFERENCE));
        $plat8->setActive(true);

        $manager->persist($plat8);

            // empêcher l'auto incrément
        $metadata = $manager->getClassMetaData(Plat::class);
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

        $manager->flush(); // flush qui indique à doctrine de générer le code sql pour mettre à jour votre base
    }
}
