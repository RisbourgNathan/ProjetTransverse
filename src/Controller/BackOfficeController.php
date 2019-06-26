<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 15/11/2018
 * Time: 14:09
 */

namespace App\Controller;
use App\BL\AdminManager;
use App\BL\AgencyDirectorManager;
use App\BL\AgencyManager;
use App\BL\AgentManager;
use App\BL\PossessionManager;
use App\BL\UserManager;
use App\DAL\AdminCrud;
use App\DAL\AgencyCrud;
use App\DAL\AgencyDirectorCrud;
use App\DAL\UserCrud;
use App\Entity\Administrator;
use App\Entity\Agency;
use App\Entity\AgencyDirector;
use App\Entity\Agent;
use App\Entity\User;
use App\Forms\AddAgencyForm;
use App\Forms\AddAgentForm;
use App\Forms\modifyAdminForm;
use App\Forms\modifyAgencyDirectorForm;
use App\Forms\modifyAgencyForm;
use App\Forms\modifyAgentForm;
use App\Forms\RegisterForm;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use App\DAL\AgentCrud;
use Symfony\Component\Security\Core\Security;

/**
 * Class BackOfficeController
 * @package App\Controller
 * @Route ("/backoffice")
 */
class BackOfficeController extends AbstractController
{
    /**
     * @var UserCrud
     */
    private $UserCrud;
    /**
     * @var UserManager
     */
    private $UserManager;
    /**
     * @var AgentCrud
     */
    private $AgentCrud;
    /**
     * @var AgentManager
     */
    private $AgentManager;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var AgencyCrud
     */
    private $AgencyCrud;
    /**
     * @var AgencyManager
     */
    private $AgencyManager;
    /**
     * @var AgencyDirectorCrud
     */
    private $AgencyDirectorCrud;
    /**
     * @var AgencyDirectorManager
     */
    private $AgencyDirectorManager;
    /**
     * @var AdminCrud
     */
    private $AdminCrud;
    /**
     * @var AdminManager
     */
    private $AdminManager;
    /**
     * @var PossessionManager
     */
    private $possessionManager;
    /**
     * @var RegistryInterface
     */
    private $registry;

    /**
     * BackOfficeController constructor.
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param Security $security
     * @param RegistryInterface $registry
     * @param PaginatorInterface $knp
     */
    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder, Security $security, RegistryInterface $registry, PaginatorInterface $knp)
    {
        $this->UserCrud = new UserCrud($em);
        $this->UserManager = new UserManager($em,$security);
        $this->AgentCrud = new AgentCrud($em);
        $this->AgentManager = new AgentManager($em);
        $this->AgencyCrud = new AgencyCrud($em);
        $this->AgencyManager = new AgencyManager($em);
        $this->AgencyDirectorCrud = new AgencyDirectorCrud($em);
        $this->AgencyDirectorManager = new AgencyDirectorManager($em);
        $this->AdminCrud = new AdminCrud($em);
        $this->AdminManager = new AdminManager($em);
        $this->possessionManager = new PossessionManager($em,$registry, $knp);
        $this->registry = $registry;
        $this->em = $em;
    }

    /**
     * @Route("/", name="backoffice")
     * @return Response
     */
    public function getHome() {
        return $this->render('backoffice/home.html.twig');
    }

    /**
     * @Route("/addAgent", name="addAgent")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return RedirectResponse|Response
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

            $this->UserCrud->createUser($user);
            $this->AgentCrud->GetInscriptionData($agent);
            return $this->redirectToRoute('backoffice');
        }
        return $this->render('backoffice/addAgent.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/modifyAgent/{idAgent}", name="modifyAgent")
     * @param $idAgent
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return RedirectResponse|Response
     */
    public function getModifyAgent($idAgent, Request $request, UserPasswordEncoderInterface $passwordEncoder){
        $user = $this->AgentCrud->getUserAgentById($idAgent);
        $form = $this->createForm(modifyAgentForm::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $this->AgentCrud->GetInscriptionData($user);
            return $this->redirectToRoute('backoffice');
        }
        return $this->render('backoffice/modifyAgent.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/addAgencyDirector", name="addAgencyDirector")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return RedirectResponse|Response
     */
    public function getAddAgencyDirector(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        $agent = new AgencyDirector();
        $user = new User();
        $form = $this->createForm(AddAgentForm::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRoles(["ROLE_AGENCY_DIRECTOR"]);
            $agency = $form->get('agency')->getData();
            $agent->setUser($user);
            $agent->setAgency($agency);

            $this->UserCrud->createUser($user);
            $this->AgencyDirectorCrud->GetInscriptionData($agent);
            return $this->redirectToRoute('backoffice');
        }
        return $this->render('backoffice/addAgencyDirector.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/modifyAgencyDirector/{idAgencyDirector}", name="modifyAgencyDirector")
     * @param $idAgencyDirector
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return RedirectResponse|Response
     */
    public function getModifyAgencyDirector($idAgencyDirector, Request $request, UserPasswordEncoderInterface $passwordEncoder){
        $user = $this->AgencyDirectorCrud->getUserAgencyDirectorById($idAgencyDirector);
        $form = $this->createForm(modifyAgencyDirectorForm::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $this->AdminCrud->GetInscriptionData($user);
            return $this->redirectToRoute('backoffice');
        }
        return $this->render('backoffice/modifyAgencyDirector.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/addAgency", name="addAgency")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function getAddAgency(Request $request) {
        $agency = new Agency();
        $form = $this->createForm(AddAgencyForm::class,$agency);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $isMainAgency = $form['is_main_agency']->getData();

            if ($isMainAgency)
            {
                $agency->setIsMainAgency(true);
            } else {
                $agency->setIsMainAgency(null);
            }

            $this->AgencyCrud->GetInscriptionData($agency);
            return $this->redirectToRoute('backoffice');
        }
        return $this->render('backoffice/addAgency.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/modifyAgency/{idAgency}", name="modifyAgency")
     * @param $idAgency
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return RedirectResponse|Response
     */
    public function getModifyAgency($idAgency, Request $request, UserPasswordEncoderInterface $passwordEncoder){
        $user = $this->AgencyCrud->getAgencyById($idAgency);
        $form = $this->createForm(modifyAgencyForm::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->AdminCrud->GetInscriptionData($user);
            return $this->redirectToRoute('backoffice');
        }
        return $this->render('backoffice/modifyAgency.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/addAdmin", name="addAdmin")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return RedirectResponse|Response
     */
    public function getAddAdmin(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        $admin = new Administrator();
        $user = new User();
        $form = $this->createForm(RegisterForm::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRoles(['ROLE_ADMIN']);
            $admin->setUser($user);
            $this->UserCrud->createUser($user);
            $this->AdminCrud->getInscriptionData($admin);
            return $this->redirectToRoute('backoffice');
        }
        return $this->render('backoffice/addAdmin.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/modifyAdmin/{idAdmin}", name="modifyAdmin")
     * @param $idAdmin
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return RedirectResponse|Response
     */
    public function getModifyAdmin($idAdmin, Request $request, UserPasswordEncoderInterface $passwordEncoder){
        $user = $this->AdminCrud->getUserAdminById($idAdmin);
        $form = $this->createForm(modifyAdminForm::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $this->AdminCrud->GetInscriptionData($user);
            return $this->redirectToRoute('backoffice');
        }
        return $this->render('backoffice/modifyAdmin.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/GetListAgent", name="GetListAgent")
     * @return Response
     */
    public function getAgentList(){
        $list =  $this->AgentManager->getListAgent();
        return $this->render('backoffice/getListAgent.html.twig', ['ListAgent' => $list]);
    }

    /**
     * @Route("/GetListAgencyDirector", name="GetListAgencyDirector")
     * @return Response
     */
    public function getAgencyDirectorList(){
        $list =  $this->AgencyDirectorManager->getListAgencyDirector();
        return $this->render('backoffice/getListAgencyDirector.html.twig', ['ListAgencyDirector' => $list]);
    }


    /**
     * @Route("/GetListAgency", name="GetListAgency")
     * @return Response
     */
    public function getAgencyList(){
        $list =  $this->AgencyManager->getListAgency();
        return $this->render('backoffice/getListAgency.html.twig', ['ListAgency' => $list]);
    }

    /**
     * @Route("/GetListAdmin", name="GetListAdmin")
     * @return Response
     */
    public function getAdminList(){
        $list =  $this->AdminManager->getListAdmin();
        return $this->render('backoffice/getListAdmin.html.twig', ['ListAdmin' => $list]);
    }

    /**
     * @Route("/showPossessionList", name="showPossessionList")
     * @param $request
     * @return Response
     */
    public function showPossessionList($request){
        $list = $this->possessionManager->getAllPossessions($request);
        return $this->render('backoffice/showPossessionList.html.twig', ['listPossession' => $list]);
    }

    /**
     * @Route("/removeAgent/{idAgent}",name="removeAgent")
     * @param $idAgent
     * @return RedirectResponse
     */
    public function removeAgent($idAgent)
    {
        $this->AgentCrud->removeAgent($idAgent);
        return $this->redirectToRoute('GetListAgent');
    }

    /**
     * @Route("/removeAgencyDirector/{idAgencyDirector}",name="removeAgencyDirector")
     * @param $idAgencyDirector
     * @return RedirectResponse
     */
    public function removeAgencyDirector($idAgencyDirector)
    {
        $this->AgencyDirectorCrud->removeAgencyDirector($idAgencyDirector);
        return $this->redirectToRoute('GetListAgencyDirector');
    }

    /**
     * @Route("/removeAgency/{idAgency}",name="removeAgency")
     * @param $idAgency
     * @return RedirectResponse
     */
    public function removeAgency($idAgency)
    {
        $this->AgencyCrud->removeAgency($idAgency);
        return $this->redirectToRoute('GetListAgency');
    }

    /**
     * @Route("/removeAdmin/{idAdmin}",name="removeAdmin")
     * @param $idAdmin
     * @return RedirectResponse
     */
    public function removeAdmin($idAdmin)
    {
        $this->AdminCrud->removeAdmin($idAdmin);
        return $this->redirectToRoute('GetListAdmin');
    }
}
