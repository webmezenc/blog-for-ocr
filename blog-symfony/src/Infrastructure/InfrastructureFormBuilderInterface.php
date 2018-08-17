<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 16/08/2018
 * Time: 17:38
 */

namespace App\Infrastructure;


interface InfrastructureFormBuilderInterface
{
    public function submitForm( array $formData );
    public function getForm();
    public function getErrors();
    public function getView();
    public function getFormName(): string;
}