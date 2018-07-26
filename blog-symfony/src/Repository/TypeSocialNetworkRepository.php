<?php

namespace App\Repository;

use App\Entity\TypeSocialNetwork;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypeSocialNetwork|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeSocialNetwork|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeSocialNetwork[]    findAll()
 * @method TypeSocialNetwork[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeSocialNetworkRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TypeSocialNetwork::class);
    }

//    /**
//     * @return TypeSocialNetwork[] Returns an array of TypeSocialNetwork objects
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
    public function findOneBySomeField($value): ?TypeSocialNetwork
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
