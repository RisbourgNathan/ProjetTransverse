<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 21/12/2018
 * Time: 14:19
 */

namespace App\Controller;
use App\BL\ClientManager;
use App\DAL\ClientCrud;
use App\Entity\User;
use App\Forms\modifyClientForm;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use App\BL\UserManager;
use Symfony\Component\Security\Core\Security;

class ProfileController extends AbstractController
{
    private $UserManager;
    private $ClientManager;
    private $ClientCrud;
    private $em;
    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder, Security $security)
    {
        $this->UserManager = new UserManager($em, $security);
        $this->ClientManager = new ClientManager($em);
        $this->ClientCrud = new ClientCrud($em);
        $this->em = $em;
    }


    /**
     * @Route("/account/{idClient}", name="account")
     */
    public function showProfile($idClient)
    {
        $client = $this->ClientManager->GetClientById($idClient);
        $clientPossessions = $client->getPossessions();

        return $this->render('account/yourProfile.html.twig', ['client' => $client, 'clientPossessions' => $clientPossessions]);
    }
     /**
     * @Route("/account/modifyProfile/{idClient}", name="modifyProfile")
     */
    public function modifyProfile($idClient, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->ClientManager->GetClientUserById($idClient);
        $form = $this->createForm(modifyClientForm::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $this->ClientCrud->GetInscriptionData($user);
            return $this->redirectToRoute('index');
        }
        return $this->render('account/modifyClient.html.twig', [
            'form' => $form->createView()
        ]);
    }
}