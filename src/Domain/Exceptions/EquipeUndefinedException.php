<?php

namespace Domain\Exceptions;

class EquipeUndefinedException extends \DomainException
{
    public function __construct(string $id)
    {
        $message = sprintf("l'equipe %s n'existe pas" , $id );
        parent::__construct($message);
    }
}