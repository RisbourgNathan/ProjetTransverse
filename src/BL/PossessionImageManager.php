<?php
/**
 * Created by PhpStorm.
 * User: NathanR
 * Date: 3/27/2019
 * Time: 5:37 PM
 */

namespace App\BL;


use App\Entity\Possession;
use App\Entity\PossessionImage;
use Doctrine\ORM\EntityManagerInterface;

class PossessionImageManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getById($id): PossessionImage
    {
        return $this->entityManager->getRepository(PossessionImage::class)->find($id);
    }
}