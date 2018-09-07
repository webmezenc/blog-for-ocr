<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 05/09/2018
 * Time: 15:43
 */

namespace App\Domain\UseCases;



use App\Domain\Command\Post\EditPostWithActualUser;
use App\Infrastructure\Form\FormBuilderCollection;
use App\Infrastructure\InfrastructureFormBuilderInterface;

class Issue35UseCases implements UseCasesLogicInterface
{

    /**
     * @var FormBuilderCollection
     */
    private $formBuilderCollection;


    /**
     * @var EditPostWithActualUser
     */
    private $editPostWithActualUser;

    /**
     * Issue35UseCases constructor.
     *
     * @param FormBuilderCollection $formBuilderCollection
     * @param EditPostWithActualUser $editPostWithActualUser
     */
    public function __construct
    (
        FormBuilderCollection $formBuilderCollection,
        EditPostWithActualUser $editPostWithActualUser
    )
    {
        $this -> formBuilderCollection  = $formBuilderCollection;
        $this -> editPostWithActualUser = $editPostWithActualUser;
    }

    /**
     * @return array
     *
     * @throws \App\Exception\EntityParametersErrorException
     * @throws \App\Exception\FormInstanceNotFoundException
     * @throws \App\Exception\UnhautorizedException
     */
    public function process(): array
    {
        $addOrEditPostType = $this -> formBuilderCollection -> getForm("AddOrEditPostType");

        if($addOrEditPostType -> isSubmitted()) {

            return $this->processWhenFormIsSubmitted($addOrEditPostType);
        }

        return [
            "form" => $addOrEditPostType -> getView()
        ];
    }

    /**
     * @param InfrastructureFormBuilderInterface $addOrEditPostType
     * @return array
     * @throws \App\Exception\EntityParametersErrorException
     * @throws \App\Exception\UnhautorizedException
     */
    private function processWhenFormIsSubmitted(InfrastructureFormBuilderInterface $addOrEditPostType): array
    {
        if (!$addOrEditPostType->isValid()) {
            return [
                "msg" => "formIsInvalid",
                "form" => $addOrEditPostType->getView()
            ];

        }

        $post = $addOrEditPostType->getData();

        $this->editPostWithActualUser->editPost($post);

        return ["msg" => "postIsSuccessfullEdited"];
    }

}