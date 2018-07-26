<?php

namespace App\Repository;

use App\Entity\AsssociatedMedia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AsssociatedMedia|null find($id, $lockMode = null, $lockVersion = null)
 * @method AsssociatedMedia|null findOneBy(array $criteria, array $orderBy = null)
 * @method AsssociatedMedia[]    findAll()
 * @method AsssociatedMedia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AsssociatedMediaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AsssociatedMedia::class);
    }

//    /**
//     * @return AsssociatedMedia[] Returns an array of AsssociatedMedia objects
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
    public function findOneBySomeField($value): ?AsssociatedMedia
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
