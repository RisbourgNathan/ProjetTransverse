<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 08/11/2018
 * Time: 14:25
 */

namespace App\Controller;
use App\DAL\ClientCrud;
use App\DAL\UserCrud;
use App\Entity\Client;
use App\Forms\RegisterForm;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class RegistrationController extends AbstractController
{
    private $entityManager;
    private $userCrud;
    private $clientCrud;

    /**
     * RegistrationController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->userCrud = new UserCrud($entityManager);
        $this->clientCrud = new ClientCrud($entityManager);
    }

    /**
     * @Route("/register", name="user_registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form, set the future user and client
        $user = new User();
        $client = new Client();
        $form = $this->createForm(RegisterForm::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRoles(["ROLE_CLIENT"]);
            // 4) save the User and Client!
            $this->userCrud->createUser($user);
            $this->clientCrud->createClient($client, $user);

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user
            $session = new Session();
            // $session->start();
            $session->set('username',$user->getUsername());
            $username = $session->get('username');
            return $this->redirectToRoute('index');
        }

        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );
    }
}