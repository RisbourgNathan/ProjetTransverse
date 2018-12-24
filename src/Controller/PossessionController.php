<?php

namespace App\Controller;

use App\BL\PossessionManager;
use App\BL\PossessionTypeManager;
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
 * @Route("/possession", name="possession_")
 */
class PossessionController extends AbstractController
{
    private $security;
    private $entityManager;
    private $possessionManager;
    private $possessionTypeManager;
    private $clientManager;

    /**
     * PossessionController constructor.
     * @param EntityManagerInterface $entityManager
     * @param Security $security
     */
    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->possessionManager = new PossessionManager($entityManager);
        $this->possessionTypeManager = new PossessionTypeManager($entityManager);
    }

    /**
     * @Route("/list", name="list")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function list(Request $request)
    {

        $possessionTypes = $this->possessionTypeManager->getAllPossessionTypes();

        $selectedPossessionType = $request->get('possessionTypeSelect');

        if ($selectedPossessionType == null)
        {
            $possessions = $this->possessionManager->getAllPossessions();
        }
        else {
            $possessions = $this->possessionManager->getPossessionsFromTypeId($selectedPossessionType);
        }

        if (count($possessions) == 0)
        {
            $possessions = null;
        }

        dump($possessions);

        return $this->render("possession/listPossessions.html.twig", array(
            "possessions" => $possessions,
            "possessionTypes" => $possessionTypes
        ));
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

        $possession = new Possession($this->entityManager);

        $originalOwnout = new ArrayCollection();
        foreach ($possession->getOwnoutbuilding() as $ownout)
        {
            $originalOwnout->add($ownout);
        }

        $form = $this->createForm(addPossessionByAgentForm::class, $possession);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {

            $possession->setAgent($agent);

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

            return $this->redirectToRoute("possession_show", array("id" => $possession->getId()));
        }

        return $this->render("possession/createPossession.html.twig", array("form" => $form->createView()));
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