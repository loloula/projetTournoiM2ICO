<?php

namespace App\Repository;

use App\Entity\Poulee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Poulee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Poulee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Poulee[]    findAll()
 * @method Poulee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PouleeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Poulee::class);
    }

    // /**
    //  * @return Poulee[] Returns an array of Poulee objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Poulee
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
