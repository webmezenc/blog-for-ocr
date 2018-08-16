<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 16/08/2018
 * Time: 17:14
 */

namespace App\Tests\Domain\UseCases;

use App\Domain\UseCases\Issue4UseCases;
use PHPUnit\Framework\TestCase;

class Issue4UseCasesTest extends TestCase
{

    public function setUp() {
        $issue4UseCases = new Issue4UseCases();
    }

    public function testShouldDisplayFormWhenUserIsntRegistred() {

    }
}
