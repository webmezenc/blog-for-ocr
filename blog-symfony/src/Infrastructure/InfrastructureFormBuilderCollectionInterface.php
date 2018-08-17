<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 17/08/2018
 * Time: 11:46
 */

namespace App\Infrastructure;


interface InfrastructureFormBuilderCollectionInterface
{
    public function getForm( string $formName ): InfrastructureFormBuilderInterface;
    public function getAll(): array;
    public function setForm( string $formName, InfrastructureFormBuilderInterface $form );
}