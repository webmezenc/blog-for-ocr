<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 16/08/2018
 * Time: 17:43
 */

namespace App\Infrastructure\Form;


use App\Exception\FormNotFoundException;
use App\Infrastructure\InfrastructureFormInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;

class FormBuilderSymfonyForm implements InfrastructureFormInterface
{

    const FORM_NAMESPACE = "\App\Form\\";

    /**
     * @var FormFactory
     */
    private $formfactory;


    /**
     * @var FormInterface
     */
    private $form;

    public function __construct( FormFactory $formFactory ) {
        $this -> formfactory = $formFactory;
    }


    /**
     * @param string $formName
     *
     * @return FormInterface
     *
     * @throws FormNotFoundException
     */
    public function getForm(string $formName)
    {
        $this -> isValidForm($formName);

        $this -> form = $this -> formfactory -> create( $this->getFormClassName($formName) );

        return $this -> form;
    }

    public function getErrors()
    {

    }

    public function getView()
    {
       return $this -> form -> createView();
    }

    /**
     * @param string $formName
     *
     * @return bool
     *
     * @throws FormNotFoundException
     */
    private function isValidForm( string $formName ): bool {

        $className = $this->getFormClassName($formName);

        if( !class_exists($className) ) {
            throw new FormNotFoundException("THe form ".$formName." isn't found");
        }

        return true;

    }

    /**
     * @param string $formName
     * @return string
     */
    private function getFormClassName(string $formName): string
    {
        $className = self::FORM_NAMESPACE . $formName;

        return $className;
    }

}