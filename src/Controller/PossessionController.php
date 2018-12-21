<?php

namespace App\Controller;

use App\Entity\Agent;
use App\Entity\Client;
use App\Entity\Possession;
use App\Entity\User;
use App\Forms\addPossessionByAgentForm;
use App\Forms\PossessionType;
use Doctrine\Common\Collections\ArrayCollection;
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
     * @param EntityManagerInterface $entityManager
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
            }
            else {
                return $this->redirectToRoute('agent_hasNoClientError');
            }
        }
        else {
            return $this->redirectToRoute('index');
        }




//        $possession = new Possession($this->entityManager);
        $possession = $this->entityManager->getRepository(Possession::class)->find(7);

        $originalOwnout = new ArrayCollection();
        foreach ($possession->getOwnoutbuilding() as $ownout)
        {
            $originalOwnout->add($ownout);
        }

        $form = $this->createForm(addPossessionByAgentForm::class, $possession, array(
            'clients' => $clients,
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            foreach ($originalOwnout as $ownout)
            {
                if (false === $possession->getOwnoutbuilding()->contains($ownout))
                {
                    $ownout->setPossession(null);
                    $this->entityManager->remove($ownout);
                }
            }

            $ownoutbuildings = $possession->getOwnOutBuilding();
            foreach ($ownoutbuildings as $elem)
            {

                $elem->setPossession($possession);
                $this->entityManager->persist($elem);
            }
            $this->entityManager->persist($possession);
            $this->entityManager->flush();

        }
        dump($form->getData());
        return $this->render("possession/createPossession.html.twig", array("form" => $form->createView(), "test" => $userAgent->getId()));
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function showPossession($id)
    {
        $possession = $this->entityManager->getRepository(Possession::class)->find($id);
        $possessionOutbuildings = $possession->getOwnOutbuilding();

        return $this->render("possession/showPossession.html.twig", array("possession" => $possession, "possOwnOutbuilding" => $possessionOutbuildings));
    }

}