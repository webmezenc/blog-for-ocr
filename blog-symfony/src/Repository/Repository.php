<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 19/08/2018
 * Time: 19:21
 */

namespace App\Repository;


use App\Exception\EntityPersistenceException;
use App\Exception\EntityPersistORMException;
use App\Exception\TypeErrorException;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\ORMException;

class Repository extends ServiceEntityRepository implements RepositoryAdapterInterface
{

    /**
     * Repository constructor.
     *
     * @param ManagerRegistry $registry
     * @param string $entityClass
     */
    public function __construct(ManagerRegistry $registry, $entityClass)
    {
        parent::__construct($registry, $entityClass);
    }


    /**
     * @throws EntityPersistenceException
     */
    public function flush()
    {
        try {
            $this -> getEntityManager() -> flush();
        } catch( ORMException $e ) {
            throw new EntityPersistenceException("An error has occurred during persistence in database");
        }

    }

    /**
     * @param $entity
     * @return object
     *
     * @throws EntityPersistORMException
     * @throws TypeErrorException
     */
    public function persist($entity)
    {
        if( gettype($entity) !== "object" ) {
            throw new TypeErrorException("Entity must be a valid object");
        }

        try {
            $this -> getEntityManager() -> persist( $entity );
        } catch( ORMException $e ) {
            throw new EntityPersistORMException("An error has occurred during persistence entity in ORM : ".$e -> getMessage());
        }

        return $entity;
    }

}