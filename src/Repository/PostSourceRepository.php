<?php

namespace App\Repository;

use App\Entity\PostSource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PostSource|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostSource|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostSource[]    findAll()
 * @method PostSource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostSourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostSource::class);
    }

    // /**
    //  * @return PostSource[] Returns an array of PostSource objects
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
    public function findOneBySomeField($value): ?PostSource
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
