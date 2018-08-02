<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 02/08/2018
 * Time: 13:45
 */

namespace App\Utils\Generic;


use App\Exception\StringNotFoundException;

class SqlServicesGeneric
{
    static public function isValidOrder( string $order )
    {
        $orderList = ["DESC","ASC"];

        if( !in_array($order,$orderList) ) {
            throw new StringNotFoundException("This order (".$order.") isn't valid");
        }

        return true;
    }

}