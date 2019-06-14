<?php
/**
 * Created by PhpStorm.
 * User: NathanR
 * Date: 5/22/2019
 * Time: 11:42 AM
 */

namespace App\BL;


use App\Entity\Proposition;
use Doctrine\ORM\EntityManagerInterface;

class PropositionManager
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function saveProposition(Proposition $proposition)
    {
        $this->entityManager->persist($proposition);
        $this->entityManager->flush();
    }

    public function getPropositionById($id)
    {
       return $this->entityManager->getRepository(Proposition::class)->find($id);
    }
}