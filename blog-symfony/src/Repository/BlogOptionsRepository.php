<?php

namespace App\Repository;

use App\Entity\BlogOptions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BlogOptions|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogOptions|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogOptions[]    findAll()
 * @method BlogOptions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogOptionsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BlogOptions::class);
    }

//    /**
//     * @return BlogOptions[] Returns an array of BlogOptions objects
//     */
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
    public function findOneBySomeField($value): ?BlogOptions
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
