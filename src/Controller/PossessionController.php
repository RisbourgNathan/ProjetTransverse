<?php

namespace App\Controller;

use App\Entity\Possession;
use App\Forms\addPossessionByAgentForm;
use App\Forms\PossessionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PossessionController
 * @package App\Controller
 * @Route("/possession")
 */
class PossessionController extends AbstractController
{

    /**
     * PossessionController constructor.
     */
    public function __construct()
    {

    }

    /**
     * @Route("/create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createPossession(Request $request)
    {
        $possession = new Possession();

        $form = $this->createForm(addPossessionByAgentForm::class, $possession);



        return $this->render("possession/createPossession.html.twig", array("form" => $form->createView()));
    }

}