<?php

namespace Domain\Exceptions;

class NotUniqueNomException extends \DomainException
{
    public function __construct(string $nom)
    {
        $message = sprintf("ce nom %s a été dejà utilisé" , $nom );
        parent::__construct($message);
    }
}