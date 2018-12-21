<?php

namespace App\Controller;
use App\BL\UserManager;
use App\DAL\UserCrud;
use App\Entity\User;
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
    public function __construct(EntityManagerInterface $em, Security $security)
    {
        $this->UserCrud = new UserCrud($em);
        $this->UserManager = new UserManager($em,$security);
        $this->em = $em;
        $this->security = $security;
    }
    /**
     * @Route("/", name="index")
     */
    public function getIndex() {
        if($this->security->getUser() != null) {
            $client = $this->UserManager->GetClientIdbyUser();
            return $this->render('index/index.html.twig', ['client' => $client]);
        }
        else{
            return $this->render('index/index.html.twig');
        }
    }
}