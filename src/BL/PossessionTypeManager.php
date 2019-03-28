<?php

namespace App\BL;


use App\Entity\Possession;
use App\Entity\PossessionType;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;

class PossessionTypeManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllPossessionTypes(): array 
    {
        return $this->entityManager->getRepository(PossessionType::class)->findAll();
    }
}