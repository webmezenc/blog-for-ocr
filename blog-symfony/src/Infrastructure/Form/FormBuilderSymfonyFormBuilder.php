<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 16/08/2018
 * Time: 17:43
 */

namespace App\Infrastructure\Form;


use App\Exception\FormInstanceNotFoundException;
use App\Exception\FormNotFoundException;
use App\Infrastructure\InfrastructureFormBuilderInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class FormBuilderSymfonyFormBuilder implements InfrastructureFormBuilderInterface
{

    const FORM_NAMESPACE = "\App\Form\\";


    /**
     * @var FormInterface
     */
    private $form;

    public function __construct( string $formName, FormFactory $formFactory, Request $request ) {
        $formfactory = $formFactory;

        $this -> isValidForm($formName);

        $this -> form = $formfactory -> create( $this->getFormClassName($formName) );
        $this -> form -> handleRequest( $request );
    }

    /**
     * @param array $formData
     */
    public function submitForm(array $formData)
    {
        $this -> form -> submit( $formData );
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this -> form;
    }


    /**
     * @return mixed
     *
     * @throws FormInstanceNotFoundException
     */
    public function getErrors()
    {
        $this -> validityFormInstance( $this -> form );

        return $this -> form  -> getErrors();
    }


    /**
     * @return mixed
     *
     * @throws FormInstanceNotFoundException
     */
    public function getView()
    {
       $this -> validityFormInstance( $this -> form  );

       return $this -> form  -> createView();
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


    /**
     * @param mixed form
     *
     * @throws FormInstanceNotFoundException
     */
    private function validityFormInstance( $form ): void
    {
        if ( !($form instanceof FormInterface) ) {
            throw new FormInstanceNotFoundException("Form instance isn't defined");
        }
    }

}