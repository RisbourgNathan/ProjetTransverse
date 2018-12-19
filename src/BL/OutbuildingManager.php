<?php

namespace App\BL;


use App\Entity\OutBuilding;
use Doctrine\ORM\EntityManagerInterface;

class OutbuildingManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllOutbuildings()
    {
        return $this->entityManager->getRepository(OutBuilding::class)->findAll();
    }
}