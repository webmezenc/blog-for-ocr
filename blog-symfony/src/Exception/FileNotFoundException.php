<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 02/08/2018
 * Time: 13:46
 */

namespace App\Exception;


use Throwable;

class FileNotFoundException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}