<?php

namespace App\Controller;

use App\BL\PossessionTypeManager;
use App\DAL\PossessionTypeCrud;
use App\Entity\PossessionType;
use App\Forms\addPossessionTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PossessionTypeController
 * @package App\Controller
 * @Route("/possessionType", name="possessionType_")
 * @IsGranted("ROLE_ADMIN")
 */
class PossessionTypeController extends AbstractController
{
    /**
     * @var PossessionTypeCrud
     */
    private $possessionTypeCrud;
    /**
     * @var PossessionTypeManager
     */
    private $possessionTypeManager;

    /**
     * PossessionTypeController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->possessionTypeCrud = new PossessionTypeCrud($entityManager);
        $this->possessionTypeManager = new PossessionTypeManager($entityManager);
    }


    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showPossessionTypes()
    {
        return $this->render("possessionType/showPossessionTypes.html.twig", array("possessionTypes" => $this->possessionTypeManager->getAllPossessionTypes()));
    }
}