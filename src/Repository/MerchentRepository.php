<?php

namespace App\Repository;

use App\Entity\Merchent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Merchent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Merchent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Merchent[]    findAll()
 * @method Merchent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MerchentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Merchent::class);
    }

    // /**
    //  * @return Merchent[] Returns an array of Merchent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Merchent
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
