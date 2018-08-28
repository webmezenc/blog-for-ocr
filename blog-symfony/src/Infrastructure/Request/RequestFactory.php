<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 07/08/2018
 * Time: 13:57
 */

namespace App\Infrastructure\Request;


use App\Infrastructure\InfrastructureRequestInterface;
use Symfony\Component\HttpFoundation\Request;

class RequestFactory
{

    const PROVIDER_LIST = ['HttpFoundation'];
    const DEFAULT_PROVIDER = 'HttpFoundation';

    /**
     * @param string $provider
     *
     * @return InfrastructureRequestInterface
     */
    static public function create( string $provider = self::DEFAULT_PROVIDER): InfrastructureRequestInterface {
        return self::getHttpFoundation();
    }


    /**
     * @return InfrastructureRequestInterface
     */
    static private function getHttpFoundation(): InfrastructureRequestInterface {
        $request = Request::createFromGlobals();

        return new HttpFoundationRequest( $request );
    }

}