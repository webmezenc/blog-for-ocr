<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 05/09/2018
 * Time: 11:41
 */

namespace App\Tests\Utils\Generic;

use App\Utils\Generic\SlugServices;
use PHPUnit\Framework\TestCase;

class SlugServicesTest extends TestCase
{
    public function testShouldObtainAValidSlug() {
        $slugServices = new SlugServices();
        $this -> assertInternalType("string",$slugServices -> slugify("Unit test"));
    }
}
