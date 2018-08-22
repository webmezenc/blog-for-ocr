<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 04/08/2018
 * Time: 13:00
 */

namespace App\Infrastructure\Repository;

use App\Exception\ClassNotFoundException;
use App\Exception\InfrastructureAdapterException;
use App\Infrastructure\InfrastructureRepositoryFactoryInterface;
use App\Infrastructure\Repository\Entity\RepositoryAdapterInterface;
use App\Utils\Generic\FileServicesGeneric;
use App\Utils\Generic\HydratorServicesGeneric;
use App\Utils\Generic\InMemoryDataServicesGeneric;
use App\Utils\Generic\ObjectServicesGeneric;
use Psr\Container\ContainerInterface;

class RepositoryFactory implements InfrastructureRepositoryFactoryInterface
{

    const PROVIDER_LIST = ['doctrine',"inMemory"];


    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $provider;


    /**
     * @var ContainerInterface
     */
    private $container;


    /**
     * RepositoryFactory constructor.
     * @param ContainerInterface $container
     */
    public function __construct( ContainerInterface $container )
    {
        $this -> container = $container;
    }


    /**
     * @param string $name
     * @param string $provider
     *
     * @throws InfrastructureAdapterException
     */
    public function create(string $name, string $provider = "doctrine")
    {
        $this -> name = $name;
        $this -> provider = $provider;


        try {

            $this -> isValidProvider( $provider );

            return $this -> getProviderRepository( $provider );

        } catch ( \Exception $e ) {
            throw new InfrastructureAdapterException("An error has occurred when obtain repository : ".$e -> getMessage() );
        }

    }


    /**
     * @param string $provider
     *
     * @throws InfrastructureAdapterException
     */
    private function getProviderRepository( string $provider )
    {
        $methodName = "get".ucfirst($provider)."Repository";

        if( !method_exists($this,$methodName) ) {
            throw new InfrastructureAdapterException("No method defined for ".$provider." provider");
        } else {
            return $this -> $methodName();
        }

    }



    /**
     * @param string $provider
     *
     * @return bool
     *
     * @throws InfrastructureAdapterException
     */
    private function isValidProvider( string $provider ): bool
    {
        if( !in_array($provider,self::PROVIDER_LIST) ) {
            throw new InfrastructureAdapterException("The provider (".$provider.") isn't valid provider");
        }

        return true;
    }


    /**
     * @return RepositoryAdapterInterface
     *
     * @throws InfrastructureAdapterException
     */
    private function getDoctrineRepository()
    {

        try {

            $className = $this -> isEntityClassExistGetClassName( $this -> name );

            $repository = $this -> container -> get("doctrine") -> getRepository( $className );

            return $this -> validationRepository( $repository );

        } catch( \Exception $e ) {
            throw new InfrastructureAdapterException("Error occurred when obtain Doctrine repository : ".$e -> getMessage() );
        }

    }


    /**
     * @param $repository
     *
     * @return mixed
     *
     * @throws InfrastructureAdapterException
     */
    private function validationRepository( $repository ) {

        if( $repository instanceof RepositoryAdapterInterface ) {
                return $repository;
            } else {
            throw new InfrastructureAdapterException("The repository not implement standard interface");
        }

    }


    /**
     * @return RepositoryAdapterInterface
     *
     * @throws InfrastructureAdapterException
     */
    private function getInMemoryRepository()
    {

        try {

            $repositoryClassName = "\App\Repository\InMemory\\".$this -> name."Repository";

            $repository = new $repositoryClassName( new InMemoryDataServicesGeneric( new FileServicesGeneric(), new HydratorServicesGeneric( new ObjectServicesGeneric() ) ), new HydratorServicesGeneric( new ObjectServicesGeneric()) );

            return $this -> validationRepository( $repository );

        } catch( \Exception $e ) {
            throw new InfrastructureAdapterException("Error occurred when obtain ".$this -> name." in memory repository : ".$e -> getMessage() );
        }

    }


    /**
     * @param string $entityName
     *
     * @return string
     *
     * @throws ClassNotFoundException
     */
    private function isEntityClassExistGetClassName( string $entityName ): string
    {
        $className = $this->getClassNameEntity($entityName);

        if( !class_exists($className) ) {
            throw new ClassNotFoundException("This entity ".$entityName." isn't found");
        }

        return $className;
    }

    /**
     * @param string $entityName
     * @return string
     */
    private function getClassNameEntity(string $entityName): string
    {
        $className = "\App\Entity\\" . $entityName;
        return $className;
    }


}