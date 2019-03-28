<?php
/**
 * Created by PhpStorm.
 * User: NathanR
 * Date: 3/27/2019
 * Time: 5:31 PM
 */

namespace App\Controller;


use App\BL\PossessionImageManager;
use App\DAL\PossessionImageCrud;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PossessionImageController
 * @package App\Controller
 * @Route("/possImage", name="possImage_")
 */
class PossessionImageController extends AbstractController
{
    private $possessionImageCrud;
    private $possessionImageManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->possessionImageCrud = new PossessionImageCrud($entityManager);
        $this->possessionImageManager = new PossessionImageManager($entityManager);
    }

    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function removePossImg($id)
    {
        $possessionImage = $this->possessionImageManager->getById($id);
        $possessionId = $possessionImage->getPossession()->getId();
        $this->possessionImageCrud->remove($possessionImage);

        return $this->redirectToRoute('possession_modify', array("id" => $possessionId));
    }
}