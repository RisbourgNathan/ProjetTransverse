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
use App\Forms\modifyUserForm;
use App\Forms\RegisterForm;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/account", name="account")
     * @return Response
     */
    public function showProfile()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $client = $this->ClientManager->getClientByUser($user);
        $clientPossessions = $client->getPossessions();
        $favorites = $client->getFavorites();

        return $this->render('account/yourProfile.html.twig', ['client' => $client, 'clientPossessions' => $clientPossessions, 'favorites' => $favorites]);
    }

    /**
     * @Route("/account/modifyProfile", name="modifyProfile")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return RedirectResponse|Response
     */
    public function modifyProfile(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getUser();
        $form = $this->createForm(modifyUserForm::class, $user);
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
