<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 15/11/2018
 * Time: 14:09
 */

namespace App\Controller;
use App\DAL\AdminCrud;
use App\DAL\AgencyCrud;
use App\DAL\UserCrud;
use App\Entity\Administrator;
use App\Entity\Agency;
use App\Entity\Agent;
use App\Entity\User;
use App\Forms\AddAgencyForm;
use App\Forms\AddAgentForm;
use App\Forms\RegisterForm;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use App\DAL\AgentCrud;
/**
 * Class BackOfficeController
 * @package App\Controller
 * @Route ("/backoffice")
 */
class BackOfficeController extends AbstractController
{
    private $UserCrud;
    private $AgentCrud;
    private $em;
    private $AgencyCrud;
    private $AdminCrud;
    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->UserCrud = new UserCrud($em);
        $this->AgentCrud = new AgentCrud($em);
        $this->AgencyCrud = new AgencyCrud($em);
        $this->AdminCrud = new AdminCrud($em);
        $this->em = $em;
    }

    /**
     * @Route("/", name="backoffice")
     */
    public function getHome() {
        return $this->render('backoffice/home.html.twig');
    }

    /**
     * @Route("/addAgent", name="addAgent")
     */
    public function getAddAgent(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        $agent = new Agent();
        $user = new User();
        $form = $this->createForm(AddAgentForm::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRoles(["ROLE_AGENT"]);
            $agency = $form->get('agency')->getData();
            $agent->setUser($user);
            $agent->setAgency($agency);

            $this->UserCrud->GetInscriptionData($user);
            $this->AgentCrud->GetInscriptionData($agent);
            return $this->redirectToRoute('backoffice');
        }
        return $this->render('backoffice/addAgent.html.twig', [
            'form' => $form->createView()
        ]);
    }

    

    /**
     * @Route("/addAgency", name="addAgency")
     */
    public function getAddAgency(Request $request) {
        $agency = new Agency();
        $form = $this->createForm(AddAgencyForm::class,$agency);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->AgencyCrud->getInscriptionData($agency);
            return $this->redirectToRoute('backoffice');
        }
        return $this->render('backoffice/addAgency.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/addAdmin", name="addAdmin")
     */
    public function getAddAdmin(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        $admin = new Administrator();
        $user = new User();
        $form = $this->createForm(RegisterForm::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRoles(["ROLE_ADMIN"]);
            $admin->setUser($user);
            $this->UserCrud->getInscriptionData($user);
            $this->AdminCrud->getInscriptionData($admin);
            return $this->redirectToRoute('backoffice');
        }
        return $this->render('backoffice/addAgency.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/GetListAgent", name="GetListAgent")
     */
    public function getAgentList(){
        $list =  $this->AgentCrud->getListUserAgent();
        return $this->render('backoffice/getListAgent.html.twig', ['ListAgent' => $list]);
    }
}