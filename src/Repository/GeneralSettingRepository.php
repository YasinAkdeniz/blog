<?php

namespace App\Repository;

use App\Entity\GeneralSetting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GeneralSetting|null find($id, $lockMode = null, $lockVersion = null)
 * @method GeneralSetting|null findOneBy(array $criteria, array $orderBy = null)
 * @method GeneralSetting[]    findAll()
 * @method GeneralSetting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GeneralSettingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GeneralSetting::class);
    }

    // /**
    //  * @return GeneralSetting[] Returns an array of GeneralSetting objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GeneralSetting
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
