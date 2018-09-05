<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 05/09/2018
 * Time: 11:39
 */

namespace App\Utils\Generic;


use Cocur\Slugify\Slugify;

class SlugServices implements SlugServicesInterface
{

    /**
     * @param string $chain
     * @return string
     **/
    static public function slugify(string $chain): string
    {
        $slugify = new Slugify();
        return $slugify -> slugify($chain);
    }

}