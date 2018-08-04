<?php

namespace App\Repository;

use App\Entity\Post;
use App\Entity\ValueObject\OrderLimit;
use App\Exception\StringNotFoundException;
use App\Utils\Generic\SqlServicesGeneric;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }


    /**
     * @param OrderLimit $orderLimit
     *
     * @return array
     *
     * @throws StringNotFoundException
     */
    public function getValidPostWithOrderAndLimit( OrderLimit $orderLimit ): array
    {

        try {

            $queryBuilder = $this -> getQueryBuilderWithOrderLimitApplied( $orderLimit );
            $query = $queryBuilder
                          -> andWhere( "p.state = 1" )
                          -> getQuery();

            return $query -> getArrayResult();

        } catch( StringNotFoundException $e ) {
            throw $e;
        }

    }


    /**
     * @return int
     */
    public function getNumberOfValidPost(): int
    {

        return $this -> createQueryBuilder("p")
                     -> select('COUNT(p)')
                     -> andWhere( "p.state = 1" )
                     -> getQuery()
                     -> getSingleScalarResult();

    }


    /**
     * @param OrderLimit $orderLimit
     *
     * @return QueryBuilder
     *
     * @throws StringNotFoundException
     */
    private function getQueryBuilderWithOrderLimitApplied( OrderLimit $orderLimit ): QueryBuilder
    {
        try {

            SqlServicesGeneric::isValidOrder( $orderLimit -> getOrder() );

            return $this -> createQueryBuilder( "p" )
                -> setFirstResult( $orderLimit -> getStart() )
                -> setMaxResults( $orderLimit -> getEnd() )
                -> orderBy( "p.id", $orderLimit -> getOrder() );

        } catch( StringNotFoundException $e ) {
            throw $e;
        }
    }

}
