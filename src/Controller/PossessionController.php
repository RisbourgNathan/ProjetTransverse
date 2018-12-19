<?php

namespace App\Controller;

use App\Entity\Agent;
use App\Entity\Client;
use App\Entity\Possession;
use App\Entity\User;
use App\Forms\addPossessionByAgentForm;
use App\Forms\PossessionType;
use Doctrine\ORM\EntityManagerInterface;
use http\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class PossessionController
 * @package App\Controller
 * @Route("/possession")
 */
class PossessionController extends AbstractController
{
    private $security;
    private $entityManager;

    /**
     * PossessionController constructor.
     * @param Security $security
     */
    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    /**
     * @Route("/createByAgent")
     * @\Sensio\Bundle\FrameworkExtraBundle\Configuration\Security("has_role('ROLE_AGENT')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createPossessionByAgent(Request $request)
    {

        $userAgent = $this->entityManager->getRepository(User::class)->find($this->security->getUser());
        $agent = $this->entityManager->getRepository(Agent::class)->findOneBy(array('user' => $userAgent->getId()));

        if ($agent != null)
        {
            if (count($agent->getClients()))
            {

                $clients = $agent->getClients();
                dump($clients);
            }
            else {
                return $this->redirectToRoute('agent_hasNoClientError');
            }
        }
        else {
            return $this->redirectToRoute('index');
        }




        $possession = new Possession();

        $form = $this->createForm(addPossessionByAgentForm::class, $possession, array(
            'clients' => $clients,
        ));

        return $this->render("possession/createPossession.html.twig", array("form" => $form->createView(), "test" => $userAgent->getId()));
    }

}