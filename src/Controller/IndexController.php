<?php

namespace App\Controller;
use App\BL\AgentManager;
use App\BL\PossessionManager;
use App\BL\UserManager;
use App\DAL\UserCrud;
use App\Entity\User;
use App\Forms\HomeSearchForm;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class IndexController extends AbstractController
{
    private $UserCrud;
    private $UserManager;
    private $em;
    private $security;
    private $possessionManager;
    private $agentManager;
    public function __construct(EntityManagerInterface $em, Security $security, PaginatorInterface $knp, RegistryInterface $registry)
    {
        $this->UserCrud = new UserCrud($em);
        $this->UserManager = new UserManager($em,$security);
        $this->em = $em;
        $this->security = $security;
        $this->possessionManager = new PossessionManager($em, $registry ,$knp);
        $this->agentManager = new AgentManager($em);
    }

    /**
     * @Route("/", name="index")
     * @param Request $request
     * @return Response
     */
    public function getIndex(Request $request) {
        $possessions = $this->possessionManager->getLatestPossessions();
        $form = $this->createForm(HomeSearchForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
           return $this->redirect('/possession/list?search_form%5Bcity%5D='.$form->get('city')->getData().'&search_form%5Btype%5D%5B%5D=091bf11d-88e1-4315-811d-860350412d2c&search_form%5Btype%5D%5B%5D=f51396cb-d9d6-4f82-aef0-2411de128755&search_form%5Btype%5D%5B%5D=1041a093-8b0c-4c59-a8de-160b4845e6bc&search_form%5Btype%5D%5B%5D=23a4d5f5-4fb4-4d4e-a0be-d94b32d8db44&search_form%5Bprice%5D=500000&search_form%5BValider%5D=');
        }
        if($this->security->getUser() != null) {
            $client = $this->UserManager->GetClientIdbyUser();
            return $this->render('index/index.html.twig', ['client' => $client, 'possessions' => $possessions, 'form' => $form->createView()]);
        }
        else{
            return $this->render('index/index.html.twig', ['possessions' => $possessions, 'form' => $form->createView()]);
        }
    }
}
