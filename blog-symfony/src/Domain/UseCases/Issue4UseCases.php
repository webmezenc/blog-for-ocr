<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 16/08/2018
 * Time: 17:13
 */

namespace App\Domain\UseCases;

use App\Infrastructure\InfrastructureFormBuilderInterface;

class Issue4UseCases implements UseCasesLogicInterface
{
    /**
     * @var InfrastructureFormBuilderInterface
     */
    private $formBuilder;


    public function __construct( InfrastructureFormBuilderInterface $formBuilder )
    {
        $this -> formBuilder = $formBuilder;
    }



    public function process(): array
    {
        // TODO: Implement process() method.
        $RegisterUserForm = $this -> formBuilder -> getForm("RegisterUserType");

        var_dump( $RegisterUserForm -> getData() );


        if ($RegisterUserForm->isSubmitted() && !$RegisterUserForm->isValid()) {
            return [
                "view" => $this -> formBuilder -> getView($RegisterUserForm),
                "formError" => "formIsInvalid"
            ];
        }

        return ["view" => $this -> formBuilder -> getView($RegisterUserForm) ];
    }

}