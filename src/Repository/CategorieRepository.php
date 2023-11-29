<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categorie>
 *
 * @method Categorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorie[]    findAll()
 * @method Categorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function getSomeCategories()
    {
        $entityManager = $this->getEntityManager(); //on instancie l'entity manager

        $query = $entityManager->createQuery( //on crée la requête 
            'SELECT c
            FROM App\Entity\Categorie c
            WHERE c.active = 1'
        )->setMaxResults(3);

        return $query->getResult();
    }

    public function affichTitreCat($categorie_id)
    { 
        
        $entityManager = $this->getEntityManager(); //on instancie l'entity manager

        $query = $entityManager->createQuery( //on crée la requête 
            'SELECT c
            FROM App\Entity\Categorie c
            WHERE c.active = 1 AND c.id=:id'
        )->setParameter('id', $categorie_id);

        return $query->getResult();
    }

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

//    /**
//     * @return Categorie[] Returns an array of Categorie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Categorie
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
