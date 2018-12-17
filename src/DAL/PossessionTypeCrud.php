<?php

namespace App\DAL;


use App\Entity\PossessionType;
use Doctrine\ORM\EntityManagerInterface;

class PossessionTypeCrud
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createPossessionType(PossessionType $possessionType)
    {
        $this->entityManager->persist($possessionType);
        $this->entityManager->flush();
    }

}