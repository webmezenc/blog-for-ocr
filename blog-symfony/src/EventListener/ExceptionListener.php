<?php
/**
 * Created by PhpStorm.
 * User: admin4111687
 * Date: 29/08/2018
 * Time: 16:00
 */

namespace App\EventListener;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $response = new Response();

        if ($exception instanceof AccessDeniedHttpException) {
            $response->setStatusCode(Response::HTTP_FORBIDDEN);

            $response->setContent("Vous n'êtes pas autorisé à visualiser ce contenu");
        }

        $event->setResponse($response);
    }
}