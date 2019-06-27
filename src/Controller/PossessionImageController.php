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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PossessionImageController
 * @package App\Controller
 * @Route("/possImage", name="possImage_")
 */
class PossessionImageController extends AbstractController
{
    /**
     * @var PossessionImageCrud
     */
    private $possessionImageCrud;
    /**
     * @var PossessionImageManager
     */
    private $possessionImageManager;

    /**
     * PossessionImageController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->possessionImageCrud = new PossessionImageCrud($entityManager);
        $this->possessionImageManager = new PossessionImageManager($entityManager);
    }

    /**
     * @Route("/remove/{id}", name="remove")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @IsGranted("ROLE_AGENT")
     */
    public function removePossImg($id)
    {
        $possessionImage = $this->possessionImageManager->getById($id);
        $possessionId = $possessionImage->getPossession()->getId();
        $this->possessionImageCrud->remove($possessionImage);

        return $this->redirectToRoute('possession_modify', array("id" => $possessionId));
    }
}