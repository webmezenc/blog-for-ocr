<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 17/08/2018
 * Time: 14:03
 */

namespace App\Infrastructure\Form;


use App\Exception\FormBuilderIsAlreadyInCollectionException;
use App\Exception\FormCollectionIsEmptyException;
use App\Exception\FormInstanceNotFoundException;
use App\Infrastructure\InfrastructureFormBuilderCollectionInterface;
use App\Infrastructure\InfrastructureFormBuilderInterface;

class FormBuilderCollection implements InfrastructureFormBuilderCollectionInterface
{


    /**
     * @var array
     */
    private $formBuilderCollection = [];

    /**
     * @param InfrastructureFormBuilderInterface $form
     */
    public function addForm( InfrastructureFormBuilderInterface $form)
    {
        if( key_exists($form -> getFormName(),$this -> formBuilderCollection) ) {
            throw new FormBuilderIsAlreadyInCollectionException("Form builder ".$form -> getFormName()." already exist in collection");
        }

        $this -> formBuilderCollection[ $form -> getFormName() ] = $form;
    }


    /**
     * @param string $formName
     */
    public function getForm(string $formName): InfrastructureFormBuilderInterface
    {
        if( !key_exists($formName,$this -> formBuilderCollection) ) {
            throw new FormInstanceNotFoundException("The form ".$formName." isn't present in collection");
        }

        return $this -> formBuilderCollection[$formName];
    }


    /**
     * @return InfrastructureFormBuilderInterface[]
     *
     * @throws FormCollectionIsEmptyException
     */
    public function getAllForms(): array
    {
        if( empty($this -> formBuilderCollection) ) {
            throw new FormCollectionIsEmptyException("The form collection is empty");
        }

        return $this -> formBuilderCollection;
    }

}