<?php
/**
 * Created by PhpStorm.
 * User: NathanR
 * Date: 5/22/2019
 * Time: 11:06 AM
 */

namespace App\Controller;


use App\BL\ClientManager;
use App\BL\FavoriteManager;
use App\BL\PossessionManager;
use App\BL\PropositionManager;
use App\Entity\Possession;
use App\Entity\Proposition;
use App\Entity\User;
use App\Forms\PropositionForm;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\Types\This;
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
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, RegistryInterface $registry, PaginatorInterface $paginator, Security $security)
    {
        $this->possessionManager = new PossessionManager($entityManager, $registry, $paginator);
        $this->propositionManager = new PropositionManager($entityManager);
        $this->clientManager = new ClientManager($entityManager);
        $this->security = $security;
        $this->entityManager = $entityManager;
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

        $proposition->setShouldBeDisplayed(true);

        $possession = $this->possessionManager->getPossessionById($idPossession);

        $propositionManager = new PropositionManager($this->entityManager);
        if ($propositionManager->isPropositionAlreadyOngoing($possession, $this->security->getUser()))
        {
            return $this->render("/errors/client/noPropOnOwnProperty.html.twig");
        }

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

            // Flash Message
            $this->addFlash(
                'CreatePropositionSuccess',
                'Votre proposition a bien enregistrée !'
            );

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

        if ($this->denyAccessToProposition($proposition)) //DENY IF NEEDED
        {
            return $this->redirectToRoute("account");
        }

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

            // Flash Message
            $this->addFlash(
                'CounterPropositionSuccess',
                'Votre contre-proposition a bien été enregistrée !'
            );

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

        if ($this->denyAccessToProposition($proposition)) //DENY IF NEEDED
        {
            return $this->redirectToRoute("account");
        }

        $proposition->setState(Proposition::$STATE_ACCEPTED);
        $proposition->getPossession()->setValidationState(Possession::$STATE_SOLD);
        $this->propositionManager->saveProposition($proposition);

        $propositionsToDeny = $proposition->getPossession()->getProposition();

        foreach ($propositionsToDeny as $propositionToDeny)
        {
            if ($propositionToDeny->getState() != Proposition::$STATE_ACCEPTED)
            {
                $propositionToDeny->setState(Proposition::$STATE_DENIED);
                $this->entityManager->persist($propositionToDeny);
            }
        }
        $this->entityManager->flush();

        // Flash Message
        $this->addFlash(
            'AcceptOfferSucces',
            'L\'offre a été accptée !'
        );

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

        if ($this->denyAccessToProposition($proposition)) //DENY IF NEEDED
        {
            return $this->redirectToRoute("account");
        }

        $proposition->setState(Proposition::$STATE_DENIED);
        $this->propositionManager->saveProposition($proposition);

        // Flash Message
        $this->addFlash(
            'DenyOfferSucces',
            'L\'offre a été refusée.'
        );

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

//        if ($possession->getValidationState() == Possession::$STATE_SOLD)
//        {
//            // Flash Message
//            $this->addFlash(
//                'ErrorShowPropForSoldPoss',
//                'Vous avez '
//            );
//
//            return $this->redirectToRoute("account");
//        }

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
        $propositions = $this->propositionManager->getVisibleClientPropositions($client);

        return $this->render("proposition/showMyPropositions.html.twig", array(
            "propositions" => $propositions
        ));
    }

    /**
     * @Route("/hide/{propositionID}", name="hide")
     * @param $propositionID
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function hideProposition($propositionID)
    {
        $proposition = $this->propositionManager->getPropositionById($propositionID);
        $proposition->setShouldBeDisplayed(false);
        $this->propositionManager->saveProposition($proposition);

        return $this->redirectToRoute('account');
    }

    private function denyAccessToProposition(Proposition $proposition)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $client = $this->clientManager->getClientByUser($this->security->getUser());
        $clientId = $client->getId();

        switch ($proposition->getState())
        {
            case Proposition::$STATE_ACCEPTED:
                return true;
                break;

            case Proposition::$STATE_DENIED:
                return true;
                break;

            case Proposition::$STATE_PROPOSITION:
                if ($clientId == $proposition->getClient()->getId())
                {
                    return true;
                }
                break;

            case Proposition::$STATE_COUNTER_PROPOSITION:
                if ($clientId == $proposition->getPossession()->getSeller()->getId())
                {
                    return true;
                }
                break;

            default:
                return true;
        }

        return false;
    }
}