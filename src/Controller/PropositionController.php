<?php
/**
 * Created by PhpStorm.
 * User: NathanR
 * Date: 5/22/2019
 * Time: 11:06 AM
 */

namespace App\Controller;


use App\BL\ClientManager;
use App\BL\PossessionManager;
use App\BL\PropositionManager;
use App\Entity\Possession;
use App\Entity\Proposition;
use App\Forms\PropositionForm;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Tests\Encoder\PasswordEncoder;

/**
 * Class PropositionController
 * @package App\Controller
 * @Route("/proposition", name="proposition_")
 */
class PropositionController extends AbstractController
{
    private $possessionManager;
    private $propositionManager;
    private $clientManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, RegistryInterface $registry, PaginatorInterface $paginator, Security $security)
    {
        $this->possessionManager = new PossessionManager($entityManager, $registry, $paginator);
        $this->propositionManager = new PropositionManager($entityManager);
        $this->clientManager = new ClientManager($entityManager);
        $this->security = $security;
    }

    /**
     * @Route("/create/{idPossession}", name="create")
     * @param $idPossession
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createProposition($idPossession, Request $request)
    {
        $proposition = new Proposition();

        $currentDate = date(DATE_RFC2822);

        $proposition->setDate(new \DateTime($currentDate));

        $possession = $this->possessionManager->getPossessionById($idPossession);

        $currentUserId = $this->clientManager->getClientByUser($this->security->getUser())->getId();
        if ($possession->getSeller()->getId() == $currentUserId)
        {
            return $this->render("/errors/client/noPropOnOwnProperty.html.twig");
        }

        $proposition->setPossession($possession);

        $usr = $this->getUser();
        $client = $this->clientManager->getClientByUser($usr);
        $proposition->setClient($client);

        $form  = $this->createForm(PropositionForm::class, $proposition);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $proposition->setState(Proposition::$STATE_PROPOSITION);
            $this->propositionManager->saveProposition($proposition);
            return $this->redirectToRoute("possession_show", array(
                "id" => $possession->getId()
            ));
        }
        return $this->render('proposition/createProposition.html.twig', array('form'=>$form->createView()));
    }

    /**
     * @Route("/createCounter/{id}", name="createCounter")
     * @param $id
     * @param Request $request
     * @return string
     */
    public function createCounterProposition($id, Request $request)
    {
        $proposition = $this->propositionManager->getPropositionById($id);
        $mockProposition = new Proposition();

        $form  = $this->createForm(PropositionForm::class, $mockProposition);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $proposition->setOldDate($proposition->getDate());
            $proposition->setOldPrice($proposition->getPrice());

            $proposition->setPrice($mockProposition->getPrice());
            $proposition->setDate(new \DateTime(date(DATE_RFC2822)));

            $proposition->setState(Proposition::$STATE_COUNTER_PROPOSITION);

            $this->propositionManager->saveProposition($proposition);

           return $this->redirectToRoute("account");
        }
        return $this->render("proposition/createProposition.html.twig", array('form'=>$form->createView()));
    }

    /**
     * @Route("/accept/{id}", name="accept")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function acceptProposition($id)
    {
        $proposition = $this->propositionManager->getPropositionById($id);
        $proposition->setState(Proposition::$STATE_ACCEPTED);
        $proposition->getPossession()->setValidationState(Possession::$STATE_SOLD);
        $this->propositionManager->saveProposition($proposition);

        return $this->redirectToRoute("account");
    }

    /**
     * @Route("/deny/{id}", name="deny")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function denyProposition($id)
    {
        $proposition = $this->propositionManager->getPropositionById($id);
        $proposition->setState(Proposition::$STATE_DENIED);

        return $this->redirectToRoute("account");
    }

    /**
     * @param $idPossession
     * @Route("/show/{idPossession}", name="showPropositions")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showPropositionsForPossession($idPossession)
    {
//        $usr = $this->getUser();
//        $client = $this->clientManager->getClientByUser($usr);

        $possession = $this->possessionManager->getPossessionById($idPossession);
        $propositions = $possession->getProposition();

        return $this->render('proposition/showPossessionProposition.html.twig', array(
            "possession" => $possession,
            "propositions" => $propositions
        ));
    }

    /**
     * @Route("/my", name="my")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showMyPropositions()
    {
        $client = $this->clientManager->getClientByUser($this->security->getUser());
        $propositions = $client->getProposition();

        return $this->render("proposition/showMyPropositions.html.twig", array(
            "propositions" => $propositions
        ));
    }
}