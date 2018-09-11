<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 21/08/2018
 * Time: 16:31
 */

namespace App\Infrastructure\Render;


use App\Exception\InfrastructureAdapterException;
use Psr\Container\ContainerInterface;

class RenderFactory
{
    const RENDERS = ['Twig'];
    const DEFAULT_RENDER = 'Twig';


    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct( ContainerInterface $container )
    {
        $this -> container = $container;
    }

    /**
     * @param string $name
     *
     * @throws InfrastructureAdapterException
     */
    public function create( string $name = self::DEFAULT_RENDER ) {

        $this->isValidRenderException($name);

        return $this -> getTwigRender();
    }

    /**
     * @param string $name
     * @throws InvalidRenderException
     */
    private function isValidRenderException(string $name): void
    {
        if (!in_array($name, self::RENDERS)) {
            throw new InfrastructureAdapterException("The render " . $name . " isn't valid, the render must be in this list : " . implode(",", self::RENDERS));
        }
    }


    private function getTwigRender() {
        return new TwigRender( $this -> container -> get("twig") );
    }
}