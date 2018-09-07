<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 17/08/2018
 * Time: 09:59
 */

namespace App\Infrastructure\Form;


use App\Exception\FormNotFoundException;
use App\Exception\TypeErrorException;
use App\Infrastructure\InfrastructureFormBuilderInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class FormBuilderFactory
{
    const FORM_BUILDER = ['FormBuilderSymfony'];
    const DEFAULT_BUILDER = 'FormBuilderSymfony';

    /**
     * @var ContainerInterface
     */
    private $container;


    /**
     * @var Request
     */
    private $request;


    /**
     * @var object
     */
    private $entity;

    /**
     * FormBuilderFactory constructor.
     * @param ContainerInterface $container
     * @param Request $request
     */
    public function __construct( ContainerInterface $container, Request $request )
    {
        $this -> container = $container;
        $this -> request = $request;
    }

    /**
     * @param string $formName
     * @param string $formBuilderName
     * @param array $options
     *
     * @return InfrastructureFormBuilderInterface
     *
     * @throws FormNotFoundException
     */
    public function create( string $formName, string $formBuilderName = self::DEFAULT_BUILDER, array $options = array() ): InfrastructureFormBuilderInterface {

        if( !in_array($formBuilderName,self::FORM_BUILDER) ) {
            throw new FormNotFoundException("The form ".$formBuilderName." isn't found");
        }

        return $this -> getFormBuilderSymfony( $formName,$options );
    }


    public function setEntityToFill( $entity ) {

        if(!is_object($entity)) {
            throw new TypeErrorException("Entity should be an object");
        }

        $this -> entity = $entity;

    }


    /**
     * @param string $formName
     *
     * @return FormBuilderSymfonyFormBuilder
     *
     * @throws FormNotFoundException
     */
    private function getFormBuilderSymfony( string $formName, array $options = array()  ) {

        if(isset($this -> entity)) {
            return new FormBuilderSymfonyFormBuilder( $formName,$this -> container -> get("form.factory"),$this -> request, $options,$this -> entity );
        }

        return new FormBuilderSymfonyFormBuilder( $formName,$this -> container -> get("form.factory"),$this -> request, $options );
    }
}