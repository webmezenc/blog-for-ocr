<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 16/08/2018
 * Time: 17:38
 */

namespace App\Infrastructure;


interface InfrastructureFormInterface
{
    public function getForm( string $formName );
    public function getErrors();
    public function getView();
}