<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 21/12/2018
 * Time: 14:19
 */

namespace App\Controller;
use App\BL\ClientManager;
use App\BL\FavoriteManager;
use App\BL\PropositionManager;
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

/**
 * Class ProfileController
 * @package App\Controller
 */
class ProfileController extends AbstractController
{
    /**
     * @var UserManager
     */
    private $UserManager;
    /**
     * @var ClientManager
     */
    private $ClientManager;
    /**
     * @var ClientCrud
     */
    private $ClientCrud;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * ProfileController constructor.
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param Security $security
     */
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

        $propositionManager = new PropositionManager($this->em);
        $propositions = $propositionManager->getVisibleClientPropositions($client);

        $favoriteManager  = new FavoriteManager($this->em);
        $user->setNotifications($favoriteManager->getNumberOfNotifications($user));
        $this->em->persist($user);

        $notifications = $client->getUser()->getNotifications();

        return $this->render('account/yourProfile.html.twig', ['client' => $client,
            'clientPossessions' => $clientPossessions,
            'favorites' => $favorites,
            'propositions' => $propositions,
            'notifications' => $notifications]);
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

            // Flash Message
            $this->addFlash(
                'ProfileModificationSuccess',
                'Vos informations ont été modifiées avec succès'
            );

            return $this->redirectToRoute('account');
        }
        return $this->render('account/modifyClient.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
