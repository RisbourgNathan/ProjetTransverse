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
use App\Entity\Proposition;
use App\Forms\PropositionForm;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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

    public function __construct(EntityManagerInterface $entityManager, RegistryInterface $registry, PaginatorInterface $paginator)
    {
        $this->possessionManager = new PossessionManager($entityManager, $registry, $paginator);
        $this->propositionManager = new PropositionManager($entityManager);
        $this->clientManager = new ClientManager($entityManager);
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
        $proposition->setPossession($possession);

        $usr = $this->getUser();
        $client = $this->clientManager->GetClientById($usr->getId());
        $proposition->setClient($client);

        $form  = $this->createForm(PropositionForm::class, $proposition);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
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
     */
    public function createCounterProposition($id)
    {
        $proposition = new Proposition();
    }
}