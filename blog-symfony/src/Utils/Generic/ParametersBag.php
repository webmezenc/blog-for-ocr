<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 08/08/2018
 * Time: 19:08
 */

namespace App\Utils\Generic;


use Symfony\Component\HttpFoundation\ParameterBag;

class ParametersBag implements ParametersBagInterface
{

    /**
     * @var ParameterBag
     */
    private $parameterBag;

    public function __construct(array $parameters = array())
    {
        $this -> parameterBag = new ParameterBag($parameters);
    }

    static public function create() {
        return new ParameterBag();
    }

    public function all(): array
    {
        return $this -> parameterBag -> all();
    }

    public function add(array $parameters = array())
    {
        // TODO: Implement add() method.
    }

    public function get(string $key)
    {
        // TODO: Implement get() method.
    }

    public function has(string $key): bool
    {
        // TODO: Implement has() method.
    }


}