<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 08/11/2018
 * Time: 14:25
 */

namespace App\Controller;
use App\BL\UuidService;
use App\DAL\ClientCrud;
use App\DAL\UserCrud;
use App\Entity\Client;
use App\Forms\RegisterForm;
use App\Entity\User;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

/**
 * Class RegistrationController
 * @package App\Controller
 */
class RegistrationController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var UserCrud
     */
    private $userCrud;
    /**
     * @var ClientCrud
     */
    private $clientCrud;
    /**
     * @var UuidService
     */
    private $uuidService;

    /**
     * RegistrationController constructor.
     * @param EntityManagerInterface $entityManager
     * @param Security $security
     */
    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->userCrud = new UserCrud($entityManager);
        $this->clientCrud = new ClientCrud($entityManager);
        $this->uuidService = new UuidService($entityManager, $security);
    }

    /**
     * @Route("/register", name="user_registration")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return RedirectResponse|Response
     */
    public function register(LoginFormAuthenticator $authenticator, GuardAuthenticatorHandler $authenticatorHandler, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form, set the future user and client
        $user = new User();
        $user->setNotifications(0);
        $client = new Client();
        $client->setSponsor(null);
        $form = $this->createForm(RegisterForm::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRoles(["ROLE_CLIENT"]);

            try {
                $this->uuidService->setUserSponsorship($user);
            } catch (\Exception $e) {
                return $this->render(
                    'registration/register.html.twig',
                    array('form' => $form->createView())
                );
            }

            $sponsorsCode = $form['sponsorCode']->getData();
            $sponsor = $this->uuidService->getSponsorFromCode($sponsorsCode);

            if ($sponsorsCode)
            {
                if ($sponsor)
                {
                    $sponsor->setSponsorshipCodeState(true);
                    $client->setSponsor($sponsor->getClients()->first());
                }
                else {
                    return $this->render(
                        'registration/register.html.twig',
                        array('form' => $form->createView())
                    );
                }
            }

            // 4) save the User and Client!
            $this->userCrud->createUser($user);
            $this->clientCrud->createClient($client, $user);

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user
            $session = new Session();
            // $session->start();
            $session->set('username',$user->getUsername());
//            $username = $session->get('username');

            // In order to connect after registration
            return $authenticatorHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // Firewall name
            );

        }

        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );
    }
}
