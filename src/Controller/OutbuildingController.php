<?php

namespace App\Controller;


use App\BL\OutbuildingManager;
use App\DAL\OutbuildingCrud;
use App\Entity\OutBuilding;
use App\Entity\OwnOutBuilding;
use App\Entity\Possession;
use App\Forms\AddOutbuilding;
use App\Forms\DependencyForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class OutbuildingController
 * @package App\Controller
 * @Route("/outbuilding", name="outbuilding_")
 */
class OutbuildingController extends AbstractController
{
    /**
     * @var OutbuildingManager
     */
    private $outbuildingManager;
    /**
     * @var OutbuildingCrud
     */
    private $outbuildingCrud;

    /**
     * OutbuildingController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->outbuildingManager = new OutbuildingManager($entityManager);
        $this->outbuildingCrud = new OutbuildingCrud($entityManager);
    }

    /**
     * @Route("/add", name="add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addOutbuilding(Request $request)
    {
        $outbuilding = new OutBuilding();
        $form = $this->createForm(AddOutbuilding::class, $outbuilding);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->outbuildingCrud->createOutbuilding($outbuilding);
            return $this->redirectToRoute("outbuilding_show");
        }

        return $this->render("outbuilding/addOutbuilding.html.twig", array("form" => $form->createView()));
    }

    /**
     * @Route("/show", name="show")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showOutbuildings()
    {
        $outbuildings = $this->outbuildingManager->getAllOutbuildings();
        return $this->render("outbuilding/showOutbuilding.html.twig", array("outbuildings" => $outbuildings));
    }
}