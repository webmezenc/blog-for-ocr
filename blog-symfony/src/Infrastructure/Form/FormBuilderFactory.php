<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 17/08/2018
 * Time: 09:59
 */

namespace App\Infrastructure\Form;


use App\Exception\FormNotFoundException;
use App\Infrastructure\InfrastructureFormBuilderInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class FormBuilderFactory
{
    const FORM_BUILDER = ['FormBuilderSymfony'];


    /**
     * @var ContainerInterface
     */
    private $container;


    /**
     * @var Request
     */
    private $request;

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
     *
     * @return InfrastructureFormBuilderInterface
     *
     * @throws FormNotFoundException
     */
    public function create( string $formName, string $formBuilderName = 'FormBuilderSymfony' ): InfrastructureFormBuilderInterface {

        if( !in_array($formBuilderName,self::FORM_BUILDER) ) {
            throw new FormNotFoundException("The form ".$formBuilderName." isn't found");
        }

        return $this -> getFormBuilderSymfony( $formName );
    }


    /**
     * @param string $formName
     *
     * @return FormBuilderSymfonyFormBuilder
     *
     * @throws FormNotFoundException
     */
    private function getFormBuilderSymfony( string $formName ) {
        return new FormBuilderSymfonyFormBuilder( $formName,$this -> container -> get("form.factory"),$this -> request );
    }
}