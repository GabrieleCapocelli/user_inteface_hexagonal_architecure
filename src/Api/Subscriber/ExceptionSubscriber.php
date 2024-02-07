<?php

namespace Api\Subscriber;

use Domain\Exceptions\EquipeUndefinedException;
use Domain\Exceptions\UserUndefinedException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event)
    {
        if (method_exists($event->getThrowable(), 'getStatusCode')){
            $code = $event->getThrowable()->getStatusCode();
        }
        else {
            switch($event){
                case $event->getThrowable() instanceof UserUndefinedException:
                case $event->getThrowable() instanceof EquipeUndefinedException:
                    $code = 404;
                    break;
                case $event->getThrowable() instanceof  AccessDeniedHttpException:
                    $code = 403;
                    break;
                case $event->getThrowable() instanceof \Error:
                    $code = 500;
                    break;
                default:
                    $code = 400;
                    break;
            }
        }
        $event->setResponse(new JsonResponse(['message' => $event->getThrowable()->getMessage(), 'status' => $code], $code));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.exception' => 'onKernelException',
        ];
    }
}
