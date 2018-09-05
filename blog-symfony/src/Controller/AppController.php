<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 02/08/2018
 * Time: 15:08
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AppController extends Controller
{

    /**
     * @param string $msg
     *
     * @return Response
     */
    public function getResponseWithViewError( string $msg, string $trace = "" ): Response
    {

        return $this->render(
            'page/erreur-interne.html.twig', [
            'errorMSG' => $msg,
            'trace' => $trace
        ]);
    }


    /**
     * @param callable $process
     * @param array $parameters
     *
     * @return Response
     */
    public function processController( callable $process, array $parameters ): Response
    {
        try {
            return call_user_func_array( $process, $parameters );
        }  catch( \Exception $e ) {
            return $this -> getResponseWithViewError( $e -> getMessage() , $e -> getTraceAsString() );
        }

    }


}