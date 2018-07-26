<?php

namespace App\Repository;

use App\Entity\MediaAssociated;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MediaAssociated|null find($id, $lockMode = null, $lockVersion = null)
 * @method MediaAssociated|null findOneBy(array $criteria, array $orderBy = null)
 * @method MediaAssociated[]    findAll()
 * @method MediaAssociated[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediaAssociatedRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MediaAssociated::class);
    }

//    /**
//     * @return MediaAssociated[] Returns an array of MediaAssociated objects
//     */
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
    public function findOneBySomeField($value): ?MediaAssociated
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
