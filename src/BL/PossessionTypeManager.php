<?php

namespace App\BL;


use App\Entity\PossessionType;
use Doctrine\ORM\EntityManagerInterface;

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