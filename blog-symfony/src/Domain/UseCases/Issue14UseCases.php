<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 30/08/2018
 * Time: 16:56
 */

namespace App\Domain\UseCases;


use App\Infrastructure\Form\FormBuilderCollection;
use App\Infrastructure\GatewayAuthenticateUser;

class Issue14UseCases implements UseCasesLogicInterface
{
    /**
     * @var FormBuilderCollection
     */
    private $formBuilderCollection;

    /**
     * @var GatewayAuthenticateUser
     */
    private $gatewayAuthenticateUser;

    /**
     * Issue14UseCases constructor.
     * @param FormBuilderCollection $formBuilderCollection
     * @param GatewayAuthenticateUser $gatewayAuthenticateUser
     */
    public function __construct( FormBuilderCollection $formBuilderCollection,
                                 GatewayAuthenticateUser $gatewayAuthenticateUser ) {
        $this -> formBuilderCollection = $formBuilderCollection;
        $this -> gatewayAuthenticateUser = $gatewayAuthenticateUser;
    }


    public function process(): array
    {
        $addPostType = $this -> formBuilderCollection  -> getForm("AddPostType");

        if( $addPostType -> isSubmitted() ) {

            if( !$addPostType -> isValid() ) {

                return [
                    "form" => $this -> formBuilderCollection
                                    -> getForm("AddPostType")
                                    -> getView(),
                    "msg" => "formIsInvalid"
                ];

            }



        }

        return [
            "form" => $this -> formBuilderCollection
                            -> getForm("AddPostType")
                            -> getView()
        ];
    }
}