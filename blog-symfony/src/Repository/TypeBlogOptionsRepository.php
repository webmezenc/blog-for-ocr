<?php

namespace App\Repository;

use App\Entity\TypeBlogOptions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypeBlogOptions|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeBlogOptions|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeBlogOptions[]    findAll()
 * @method TypeBlogOptions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeBlogOptionsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TypeBlogOptions::class);
    }

//    /**
//     * @return TypeBlogOptions[] Returns an array of TypeBlogOptions objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeBlogOptions
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
