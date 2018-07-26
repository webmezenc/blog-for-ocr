<?php

namespace App\Repository;

use App\Entity\TypeMedia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypeMedia|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeMedia|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeMedia[]    findAll()
 * @method TypeMedia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeMediaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TypeMedia::class);
    }

//    /**
//     * @return TypeMedia[] Returns an array of TypeMedia objects
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
    public function findOneBySomeField($value): ?TypeMedia
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
