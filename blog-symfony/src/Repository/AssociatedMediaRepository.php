<?php

namespace App\Repository;

use App\Entity\AssociatedMedia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AssociatedMedia|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssociatedMedia|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssociatedMedia[]    findAll()
 * @method AssociatedMedia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssociatedMediaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AssociatedMedia::class);
    }

//    /**
//     * @return AssociatedMedia[] Returns an array of AssociatedMedia objects
//     */
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
    public function findOneBySomeField($value): ?AssociatedMedia
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
