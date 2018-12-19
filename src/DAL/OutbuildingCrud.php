<?php

namespace App\DAL;


use App\Entity\OutBuilding;
use Doctrine\ORM\EntityManagerInterface;

class OutbuildingCrud
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createOutbuilding(Outbuilding $outbuilding)
    {
        $this->entityManager->persist($outbuilding);
        $this->entityManager->flush();
    }
}