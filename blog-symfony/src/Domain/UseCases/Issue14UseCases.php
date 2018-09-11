<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 30/08/2018
 * Time: 16:56
 */

namespace App\Domain\UseCases;


use App\Domain\Command\Post\AddPostWithActualUser;
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
     * @var AddPostWithActualUser
     */
    private $addPostWithActualUser;

    /**
     * Issue14UseCases constructor.
     *
     * @param FormBuilderCollection $formBuilderCollection
     * @param GatewayAuthenticateUser $gatewayAuthenticateUser
     * @param AddPostWithActualUser $addPostWithActualUser
     */
    public function __construct( FormBuilderCollection $formBuilderCollection,
                                 GatewayAuthenticateUser $gatewayAuthenticateUser,
                                 AddPostWithActualUser $addPostWithActualUser ) {
        $this -> formBuilderCollection = $formBuilderCollection;
        $this -> gatewayAuthenticateUser = $gatewayAuthenticateUser;
        $this -> addPostWithActualUser = $addPostWithActualUser;
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

            try {

                $post = $addPostType -> getData();
                $this -> addPostWithActualUser -> addPost($post);

                return ["msg" => "formAddedSuccessfull"];

            } catch( \Exception $e ) {
                throw $e;
            }

        }

        return [
            "form" => $this -> formBuilderCollection
                            -> getForm("AddPostType")
                            -> getView()
        ];
    }
}