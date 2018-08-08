<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 04/08/2018
 * Time: 12:07
 */

namespace App\Domain\UseCases;


use App\Exception\InvalidStateException;
use App\Exception\NotFoundException;
use App\Exception\ParameterIsNotFoundException;
use App\Exception\UnhautorizedException;
use App\Infrastructure\InfrastructureRequestInterface;
use App\Utils\Generic\ObjectServicesGeneric;
use App\Utils\Generic\ParametersBagInterface;
use App\Utils\Services\Post\PostServices;

class Issue3UseCases implements UseCasesLogicInterface
{

    /**
     * @var PostServices
     */
    private $postServices;


    /**
     * @var InfrastructureRequestInterface
     */
    private $request;


    /**
     * @var ParametersBagInterface
     */
    private $parametersBag;


    /**
     * Issue3UseCases constructor.
     *
     * @param PostServices $postServices
     * @param InfrastructureRequestInterface $request
     * @param ParametersBagInterface $parametersBag
     */
    public function __construct( PostServices $postServices, InfrastructureRequestInterface $request, ParametersBagInterface $parametersBag )
    {
        $this -> postServices = $postServices;
        $this -> request = $request;
        $this -> parametersBag = $parametersBag;
    }

    /**
     * @return array
     */
    public function process(): array
    {
        try {
            $params = $this -> getParameters();

            $post = $this -> postServices -> getPublishPostBySlug($params["slug"] );

            return ObjectServicesGeneric::getArrayFromObject( $post );

        } catch( ParameterIsNotFoundException $e ) {
            throw new NotFoundException("Parameters aren't valid or aren't defined");
        } catch( InvalidStateException $e ) {
            throw new UnhautorizedException("See this content is unhaotized");
        }
    }


    /**
     * @return array
     */
    private function getParameters(): array
    {
        if( !$this -> parametersBag -> has("slug") ) {
            throw new ParameterIsNotFoundException("The parameter (slug) isn't found");
        }

        return $this -> parametersBag -> all();
    }





}