<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 13/08/2018
 * Time: 11:07
 */

namespace App\Repository\InMemory;


use App\Entity\User;
use App\Exception\EntityNotFoundException;
use App\Exception\EntityNotValidException;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;
use App\Utils\Generic\EntityServicesGeneric;
use App\Utils\Generic\HydratorServicesGeneric;
use App\Utils\Generic\InMemoryDataServicesGeneric;
use App\Utils\Generic\ObjectServicesGeneric;

class MemoryRepository implements RepositoryAdapterInterface
{

    /**
     * @var array
     */
    protected $repositoryTupples;

    /**
     * @var InMemoryDataServicesGeneric
     */
    protected $inMemoryDataServicesGeneric;


    /**
     * @var HydratorServicesGeneric
     */
    protected $hydratorServicesGeneric;


    /**
     * @var string
     */
    private $entity;


    /**
     * MemoryRepository constructor.
     *
     * @param InMemoryDataServicesGeneric $inMemoryDataServicesGeneric
     * @param HydratorServicesGeneric $hydratorServicesGeneric
     * @param string $entity
     *
     * @throws \Exception
     */
    public function __construct( InMemoryDataServicesGeneric $inMemoryDataServicesGeneric, HydratorServicesGeneric $hydratorServicesGeneric, string $entity ) {

        $this -> repositoryTupples = $inMemoryDataServicesGeneric -> getDataForEntity( $entity );
        $this -> inMemoryDataServicesGeneric = $inMemoryDataServicesGeneric;
        $this -> hydratorServicesGeneric = $hydratorServicesGeneric;
        $this -> entity = $entity;
    }

    /**
     * @param int $id
     *
     * @return mixed
     *
     * @throws EntityNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null) {

        return $this -> findOneBy( array("id" => $id ));

    }

    public function getEntityManager() {
        return $this;
    }


    /**
     * @return array
     */
    public function findAll() {

        $tupples = [];

        foreach( $this -> repositoryTupples as $tupple ) {
            $tupples[] =  $this -> hydratorServicesGeneric -> hydrate( $this -> entity, $tupple);
        }

        return $tupples;

    }



    /**
     * @param object $entity
     *
     * @throws EntityNotValidException
     * @throws \App\Exception\TypeErrorException
     */
    public function persist( $entity ) {

        $className = EntityServicesGeneric::getClassName($this -> entity);

        if( $entity instanceof $className ) {

            $tabParameters = ObjectServicesGeneric::getArrayFromObject( $entity );

            $this -> repositoryTupples = $this -> inMemoryDataServicesGeneric -> addDataInTuppleWithAutoIncrement( $tabParameters, $this -> repositoryTupples );

            end( $this -> repositoryTupples );

            return $this -> hydratorServicesGeneric -> hydrate( $this -> entity, current($this -> repositoryTupples));

        } else {
            throw new EntityNotValidException("Entity isn't a valid instance of ".$className);
        }
    }


    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     *
     * @return array|null
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): ?array {

        return $this -> inMemoryDataServicesGeneric -> searchInTuppleWithParametersAndHydrateEntityIfEntityIsDefined( $params, $this -> repositoryTupples, $this -> entity );
    }


    /**
     * @param array $criteria
     * @param array|null $orderBy
     *
     * @return mixed
     *
     * @throws EntityNotFoundException
     */
    public function findOneBy(array $criteria, array $orderBy = null) {
        $find = $this -> inMemoryDataServicesGeneric -> searchInTuppleWithParametersAndHydrateEntityIfEntityIsDefined( $params, $this -> repositoryTupples, $this -> entity );

        if( is_null($find) ) {
            throw new EntityNotFoundException("Entity isn't found");
        } else {
            return current($find);
        }
    }


    public function remove($entity) {

    }

    public function flush() {

    }



}