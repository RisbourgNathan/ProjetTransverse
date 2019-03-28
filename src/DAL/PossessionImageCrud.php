<?php
/**
 * Created by PhpStorm.
 * User: NathanR
 * Date: 3/27/2019
 * Time: 5:27 PM
 */

namespace App\DAL;


use App\Entity\PossessionImage;
use Doctrine\ORM\EntityManagerInterface;

class PossessionImageCrud
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function remove(PossessionImage $possessionImage)
    {
        var_dump($possessionImage->getImageName());
        $possessionImage->setPossession(null);
//        $possessionImage->setImageName(null);
        $this->entityManager->remove($possessionImage);
        $this->entityManager->flush();
    }
}