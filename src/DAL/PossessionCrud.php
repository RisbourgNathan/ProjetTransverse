<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 19/12/2018
 * Time: 15:46
 */

namespace App\DAL;
use App\Entity\Possession;
use Doctrine\ORM\EntityManagerInterface;

class PossessionCrud
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createPossession(Possession $possession)
    {
        $this->entityManager->persist($possession);
        $this->entityManager->flush();
    }
}