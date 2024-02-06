<?php

namespace Domain\Exceptions;

class UserUndefinedException extends \DomainException
{
    public function __construct(string $id)
    {
        $message = sprintf("l'utilisateur %s n'existe pas" , $id );
        parent::__construct($message);
    }
}