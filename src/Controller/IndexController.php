<?php

namespace App\Controller;
use App\BL\AgentManager;
use App\BL\ClientManager;
use App\BL\PossessionManager;
use App\BL\UserManager;
use App\DAL\UserCrud;
use App\Entity\User;
use App\Forms\HomeSearchForm;
use App\Forms\SearchForm;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

/**
 * Class IndexController
 * @package App\Controller
 */
class IndexController extends AbstractController
{
    /**
     * @var UserCrud
     */
    private $UserCrud;
    /**
     * @var UserManager
     */
    private $userManager;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var Security
     */
    private $security;
    /**
     * @var PossessionManager
     */
    private $possessionManager;
    /**
     * @var AgentManager
     */
    private $agentManager;
    /**
     * @var PaginatorInterface
     */
    private $knp;
    /**
     * @var ClientManager
     */
    private $clientManager;
    /**
     * IndexController constructor.
     * @param EntityManagerInterface $em
     * @param Security $security
     * @param PaginatorInterface $knp
     * @param RegistryInterface $registry
     */
    public function __construct(EntityManagerInterface $em, Security $security, PaginatorInterface $knp, RegistryInterface $registry)
    {
        $this->UserCrud = new UserCrud($em);
        $this->userManager = new UserManager($em,$security);
        $this->em = $em;
        $this->security = $security;
        $this->possessionManager = new PossessionManager($em, $registry ,$knp);
        $this->agentManager = new AgentManager($em);
        $this->knp = $knp;
        $this->clientManager = new ClientManager($em);
    }

    /**
     * @Route("/", name="index")
     * @param Request $request
     * @return Response
     */
    public function getIndex(Request $request) {
        $allClients = $this->clientManager->GetListClient();
        $allPossessions = $this->possessionManager->getListPossessions();
        $numberOfPossessions = count($allPossessions);
        $numberOfClients = count($allClients);
        $possessions = $this->possessionManager->getLatestPossessions();
        $form = $this->createForm(HomeSearchForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $city = $form->get('city')->getData();
            return $this->redirectToRoute('possession_list', array(
                    "city" => $city
            ));
        }
        if($this->security->getUser() != null) {
            $client = $this->userManager->GetClientIdbyUser();
            return $this->render('index/index.html.twig', ['client' => $client, 'possessions' => $possessions, 'form' => $form->createView(), 'nbOfClients' => $numberOfClients, 'nbOfPossessions' => $numberOfPossessions]);
        }
        else{
            return $this->render('index/index.html.twig', ['possessions' => $possessions, 'form' => $form->createView(), 'nbOfClients' => $numberOfClients, 'nbOfPossessions' => $numberOfPossessions]);
        }
    }

    /**
     * @Route("/mentionslegales", name="mentionsLegales")
     */
    public function mentionsLegales(){
        return $this->render('index/mentionsLegales.html.twig');
    }
}
