<?php

namespace App\Controller;
use App\BL\AgentManager;
use App\BL\PossessionManager;
use App\BL\UserManager;
use App\DAL\UserCrud;
use App\Entity\User;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
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
     */
    public function getIndex() {
        $possessions = $this->possessionManager->getLatestPossessions();
        if($this->security->getUser() != null) {
            $client = $this->UserManager->GetClientIdbyUser();
            $agent = $this->agentManager->getAgentByUser($this->getUser());
            return $this->render('index/index.html.twig', ['client' => $client, 'possessions' => $possessions, 'agent' => $agent]);
        }
        else{
            return $this->render('index/index.html.twig', ['possessions' => $possessions]);
        }
    }
}
