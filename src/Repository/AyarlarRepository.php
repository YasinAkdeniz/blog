<?php

namespace App\Repository;

use App\Entity\Ayarlar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ayarlar|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ayarlar|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ayarlar[]    findAll()
 * @method Ayarlar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AyarlarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ayarlar::class);
    }

    // /**
    //  * @return Ayarlar[] Returns an array of Ayarlar objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ayarlar
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
