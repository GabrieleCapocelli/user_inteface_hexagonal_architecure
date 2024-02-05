<?php

namespace Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Infra\Repository\EquipeDbalRepository;

#[ORM\Entity(repositoryClass: EquipeDbalRepository::class)]
class Equipe implements \SplSubject
{
    private string $id;
    private string $nom;
    private \SplObjectStorage $observers;


    private function __construct(string $equipeId, string $nom)
    {
        $this->id = $equipeId;
        $this->nom = $nom;
        $this->observers = new \SplObjectStorage;
    }

    public static function create(string $equipeId, string $nom): self
    {
        return new self($equipeId, $nom);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function attach(\SplObserver $observer): void
    {
        $this->observers->attach($observer);
    }

    public function detach(\SplObserver $observer): void
    {
        $this->observers->detach($observer);
    }

    public function notify(): void
    {
        foreach($this->observers as $observer) {
            $observer->update($this);
        }
    }

}
