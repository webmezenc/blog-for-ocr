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
use App\Tests\Domain\UseCases\Issue52UseCasesTest;
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
     * @var Issue52UseCases
     */
    private $issue52UseCases;


    /**
     * Issue3UseCases constructor.
     *
     * @param PostServices $postServices
     * @param InfrastructureRequestInterface $request
     * @param ParametersBagInterface $parametersBag
     * @param Issue52UseCases $issue52UseCases
     **/
    public function __construct(
        PostServices $postServices,
        InfrastructureRequestInterface $request,
        ParametersBagInterface $parametersBag,
        Issue52UseCases $issue52UseCases
    )
    {
        $this -> postServices = $postServices;
        $this -> request = $request;
        $this -> parametersBag = $parametersBag;
        $this -> issue52UseCases = $issue52UseCases;
    }

    /**
     * @return array
     */
    public function process(): array
    {
        try {
            $params = $this -> getParameters();

            $post = $this -> postServices -> getPublishPostBySlug($params["slug"] );

            $this -> issue52UseCases -> setPost($post);

            return array_merge(
                ObjectServicesGeneric::getArrayFromObject( $post ),
                $this -> issue52UseCases -> process()
            );

        } catch( ParameterIsNotFoundException $e ) {
            throw new NotFoundException("Parameters aren't valid or aren't defined");
        } catch( InvalidStateException $e ) {
            throw new UnhautorizedException("See this content is unhautorized");
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