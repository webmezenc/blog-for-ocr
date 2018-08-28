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


    /**
     * ParametersBag constructor.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters = array())
    {
        $this -> parameterBag = new ParameterBag($parameters);
    }


    /**
     * @return array
     */
    public function all(): array
    {
        return $this -> parameterBag -> all();
    }


    /**
     * @param array $parameters
     */
    public function add(array $parameters = array())
    {
        return $this -> parameterBag -> add( $parameters );
    }


    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key)
    {
        return $this -> parameterBag -> get($key);
    }


    /**
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool
    {
        return $this -> parameterBag -> has($key);
    }


}