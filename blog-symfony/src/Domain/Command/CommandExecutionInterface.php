<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 26/08/2018
 * Time: 20:39
 */

namespace App\Domain\Command;


interface CommandExecutionInterface
{
    public function executeCommand(): bool;
}