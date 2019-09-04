<?php

namespace App\Repository;

use App\Entity\DiscountPeriod;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DiscountPeriod|null find($id, $lockMode = null, $lockVersion = null)
 * @method DiscountPeriod|null findOneBy(array $criteria, array $orderBy = null)
 * @method DiscountPeriod[]    findAll()
 * @method DiscountPeriod[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiscountPeriodRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DiscountPeriod::class);
    }

    // /**
    //  * @return DiscountPeriod[] Returns an array of DiscountPeriod objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DiscountPeriod
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
