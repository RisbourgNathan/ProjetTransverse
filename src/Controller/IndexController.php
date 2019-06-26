<?php

namespace App\Controller;
use App\BL\AgentManager;
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
    }

    /**
     * @Route("/", name="index")
     * @param Request $request
     * @return Response
     */
    public function getIndex(Request $request) {
        $possessions = $this->possessionManager->getLatestPossessions();
        $form = $this->createForm(HomeSearchForm::class);
        $form2 = $this->createForm(SearchForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
//           return $this->redirect('http://127.0.0.1:8000/possession/list?search_form%5Bcity%5D='.$form->get('city')->getData().'&search_form%5Btype%5D%5B%5D=babb353d-6b95-412a-a21b-7d88de06e8f6&search_form%5Btype%5D%5B%5D=8e3738ac-48e7-4388-8a2c-269fcd58f238&search_form%5Btype%5D%5B%5D=2028a9f7-3041-41ff-8a72-8855632fb817&search_form%5Btype%5D%5B%5D=89a9e33f-9d48-4871-b67d-749b8bb03274&search_form%5Bprice%5D=500000&search_form%5BValider%5D=');

            $city = $form->get('city')->getData();
            $possessions = $this->possessionManager->getPossessionsByName($city, $request);
//            $possessions = $this->knp->paginate($this->possessionManager->getPossessionsByName($city),
//                $request->query->getInt("page", 1),
//                9);

            $client = null;
            if ($this->security->getUser() != null)
            {
                $client = $this->userManager->GetClientIdbyUser();
            }

            return $this->redirectToRoute('possession_list', array(
//                "possessions" => $possessions,
                    "city" => $city
//                "client" => $client
            ));
        }

        if($this->security->getUser() != null) {
            $client = $this->userManager->GetClientIdbyUser();
            return $this->render('index/index.html.twig', ['client' => $client, 'possessions' => $possessions, 'form' => $form->createView()]);
        }
        else{
            return $this->render('index/index.html.twig', ['possessions' => $possessions, 'form' => $form->createView()]);
        }
    }

    /**
     * @Route("/mentionslegales", name="mentionsLegales")
     */
    public function mentionsLegales(){
        return $this->render('index/mentionsLegales.html.twig');
    }
}
