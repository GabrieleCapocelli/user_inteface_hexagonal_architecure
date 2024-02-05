<?php

namespace Domain\ValueObject;

use Symfony\Component\Uid\Uuid;

class Id
{
    private string $id;

    private function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function generate(): self
    {
        return new self(Uuid::v4()->jsonSerialize());
    }

    public static function fromString(string $id): self
    {
        if(Uuid::isValid($id)){
            return new self($id);
        }else{
            throw new \DomainException(sprintf("Id '%s' n'est pas valide", $id));
        }
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
