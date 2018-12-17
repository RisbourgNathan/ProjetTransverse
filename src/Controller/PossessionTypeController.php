<?php

namespace App\Controller;

use App\BL\PossessionTypeManager;
use App\DAL\PossessionTypeCrud;
use App\Entity\PossessionType;
use App\Forms\addPossessionTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PossessionTypeController
 * @package App\Controller
 * @Route("/possessionType", name="possessionType_")
 */
class PossessionTypeController extends AbstractController
{
    private $possessionTypeCrud;
    private $possessionTypeManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->possessionTypeCrud = new PossessionTypeCrud($entityManager);
        $this->possessionTypeManager = new PossessionTypeManager($entityManager);
    }


    /**
     * @Route("/create", name="create")
     */
    public function createPossessionTypeForm(Request $request)
    {
        $possessionType = new PossessionType();

        $form = $this->createForm(addPossessionTypeForm::class, $possessionType);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->possessionTypeCrud->createPossessionType($possessionType);
            return $this->redirectToRoute("possessionType_show");
        }

        return $this->render("possessionType/createPossessionType.html.twig", array("form" => $form->createView()));
    }

    /**
     * @Route("/show", name="show")
     */
    public function showPossessionTypes()
    {
        return $this->render("possessionType/showPossessionTypes.html.twig", array("possessionTypes" => $this->possessionTypeManager->getAllPossessionTypes()));
    }
}