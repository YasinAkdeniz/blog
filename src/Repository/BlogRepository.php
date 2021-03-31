<?php

namespace App\Repository;

use App\Entity\Blog;
use App\Entity\BlogCategory;
use App\Entity\BlogTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Blog|null find($id, $lockMode = null, $lockVersion = null)
 * @method Blog|null findOneBy(array $criteria, array $orderBy = null)
 * @method Blog[]    findAll()
 * @method Blog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Blog::class);
    }

    /**
     * @param $slug
     * @param int $offset
     * @param int $limit
     * @return int|mixed|string
     */
    public function findByCategorySlug($slug, $offset=0, $limit = 3)
    {
        $rsm = new ResultSetMappingBuilder($this->_em);
        $rsm->addRootEntityFromClassMetadata(Blog::class, 'b');
        $queryBody = 'SELECT b.* FROM blog AS b
                        INNER JOIN blog_category_blog as bcb ON bcb.blog_id=b.id
                        INNER JOIN blog_category AS bc ON bc.id=bcb.blog_category_id
                        WHERE bc.slug = :slug
                        GROUP BY b.id
                        LIMIT :offset, :limit';
        $query = $this->_em->createNativeQuery($queryBody, $rsm);
        $query->setParameter('slug', $slug);
        $query->setParameter('offset', $offset);
        $query->setParameter('limit', $limit);
        return $query->getResult();
    }

    /**
     * @param $searchValue
     * @param $offset
     * @param $length
     * @return int|mixed|string
     */
    public function findByCriterias($searchValue, $offset, $length)
    {
        $qb = $this->createQueryBuilder('b');

        return $qb
            ->orWhere($qb->expr()->like('b.title', ':val'))
            ->orWhere($qb->expr()->like('b.body', ':val'))
            ->setParameter('val', '%'.$searchValue.'%')
            ->orderBy('b.id', 'ASC')
            ->setMaxResults($length)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }

    public function getCountByCriterias($searchValue)
    {
        $qb = $this->createQueryBuilder('b');

        return $qb
            ->select('COUNT(b.id)')
            ->orWhere($qb->expr()->like('b.title', ':val'))
            ->orWhere($qb->expr()->like('b.body', ':val'))
            ->setParameter('val', '%'.$searchValue.'%')
            ->orderBy('b.id', 'ASC')
            ->getQuery()
            ->getSingleScalarResult();
    }



    /**
     * @param $slug
     * @param int $offset
     * @param int $limit
     * @return int|mixed|string
     */
    public function findByTagSlug($slug, $offset=0 , $limit=10)
    {

        $qb = $this->createQueryBuilder('b');

        $query = $qb->innerJoin('b.blogTags','bt')
            ->where('bt.slug=:slug')
            ->setParameter('slug', $slug)
            ->groupBy('b.id')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery();

        return $query->getResult();

    }


    // /**
    //  * @return Blog[] Returns an array of Blog objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Blog
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
