<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 13/08/2018
 * Time: 11:01
 */

namespace App\Tests\Infrastructure\Repository\InMemory;

use App\Entity\User;
use App\Repository\InMemory\UserRepository;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{

    private $userRepository;

    public function setUp() {
        $this -> userRepository = new UserRepository();
    }

    public function testShouldObtainAnEntityNotFoundWithinFind() {

        $this -> expectException( "\App\Exception\EntityNotFoundException" );

        $this -> userRepository -> find( 15 );
    }
}
