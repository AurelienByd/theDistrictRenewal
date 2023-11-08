<?php

namespace App\Repository;

use App\Entity\Plat;
use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Plat>
 *
 * @method Plat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Plat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Plat[]    findAll()
 * @method Plat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlatRepository extends ServiceEntityRepository
{
    public function getSomePlats()
    {
        $entityManager = $this->getEntityManager(); //on instancie l'entity manager

        $query = $entityManager->createQuery( //on crée la requête 
            'SELECT p
            FROM App\Entity\Plat p
            WHERE p.active = 1
            ORDER BY p.prix DESC')
        ->setMaxResults(3);

        return $query->getResult();
    }

    public function getSomePlats2()
    {
        $entityManager = $this->getEntityManager(); //on instancie l'entity manager

        $query = $entityManager->createQuery( //on crée la requête 
            'SELECT p
            FROM App\Entity\Plat p
            WHERE p.active = 1')
        ->setMaxResults(6);

        return $query->getResult();
    }

    public function allPlatsByCat($categorie_id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Plat p
            JOIN App\Entity\Categorie c
            WHERE p.active = 1 AND p.categorie=:id'
            )->setParameter('id', $categorie_id);

        return $query->getResult();
    }

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Plat::class);
    }

//    /**
//     * @return Plat[] Returns an array of Plat objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Plat
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
