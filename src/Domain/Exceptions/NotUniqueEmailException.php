<?php

namespace Domain\Exceptions;

class NotUniqueEmailException extends \DomainException
{
    public function __construct(string $email)
    {
        $message = sprintf("l'email %s a été dejà utilisé" , $email );
        parent::__construct($message);
    }
}