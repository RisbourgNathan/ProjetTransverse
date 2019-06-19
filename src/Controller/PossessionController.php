<?php

namespace App\Controller;

use App\BL\AgentManager;
use App\BL\ClientManager;
use App\BL\FavoriteManager;
use App\BL\PossessionManager;
use App\BL\PossessionTypeManager;
use App\BL\UserManager;
use App\Entity\Agent;
use App\Entity\Possession;
use App\Entity\User;
use App\Forms\addPossessionByAgentForm;
use App\Forms\SearchForm;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Forms\modifyPossessionType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

/**
 * Class PossessionController
 * @package App\Controller
 * @Route("/possession", name="possession_")
 */
class PossessionController extends AbstractController
{
    private $security;
    private $entityManager;
    private $possessionManager;
    private $possessionTypeManager;
    private $clientManager;
    private $userManager;
    private $registry;
    private $uploaderHelper;
    private $knp;
    private $agentManager;
    private $favoriteManager;

    /**
     * PossessionController constructor.
     * @param EntityManagerInterface $entityManager
     * @param Security $security
     * @param RegistryInterface $registry
     * @param UploaderHelper $uploaderHelper
     * @param PaginatorInterface $knp
     */
    public function __construct(EntityManagerInterface $entityManager, Security $security, RegistryInterface $registry, UploaderHelper $uploaderHelper, PaginatorInterface $knp)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->registry = $registry;
        $this->possessionManager = new PossessionManager($entityManager, $registry, $knp);
        $this->userManager = new UserManager($entityManager, $security);
        $this->possessionTypeManager = new PossessionTypeManager($entityManager);
        $this->uploaderHelper = $uploaderHelper;
        $this->knp = $knp;
        $this->agentManager = new AgentManager($entityManager);
        $this->clientManager = new ClientManager($entityManager);
        $this->favoriteManager = new FavoriteManager($entityManager);
    }

    /**
     * @Route("/list", name="list")
     * @param Request $request
     * @return Response
     */
    public function list(Request $request)
    {
        $form = $this->createForm(SearchForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $city = $form->get('city')->getData();

            $price = $form->get('price')->getData();

            $type_id = $form->get('type')->getData();

            $array_id = array();
            foreach ($type_id as $type)
            {
                array_push($array_id,$type->getId());
            }
            $possessions = $this->possessionManager->getPossessionsBySearch($city, $price, $array_id, $request);
        }
        else{
            $possessions = $this->possessionManager->getAllPossessions($request);
        }

        if (count($possessions) == 0)
        {
            $possessions = null;
        };

        $client = NULL;

        if($this->security->getUser() != null){
            $client = $this->userManager->GetClientIdbyUser();
        }
        dump($possessions);
        return $this->render("possession/listPossessions.html.twig", array(
            "possessions" => $possessions,
            'form' => $form->createView(),
            'client' => $client
        ));

    }

    /**
     * @Route("/createByAgent")
     * @\Sensio\Bundle\FrameworkExtraBundle\Configuration\Security("has_role('ROLE_AGENT')")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function createPossessionByAgent(Request $request)
    {
        if ($this->isGranted('ROLE_ADMIN'))
        {
            throw  new AccessDeniedException("Only agents can create possessions");
        }

        $userAgent = $this->entityManager->getRepository(User::class)->find($this->security->getUser());
        $agent = $this->entityManager->getRepository(Agent::class)->findOneBy(array('user' => $userAgent->getId()));

        $possession = new Possession();

        $originalOwnout = new ArrayCollection();
        foreach ($possession->getOwnoutbuilding() as $ownout)
        {
            $originalOwnout->add($ownout);
        }

        $originalPhotos = new ArrayCollection();
        foreach ($possession->getPossessionImage() as $image)
        {
            $originalPhotos->add($image);
        }

        $form = $this->createForm(addPossessionByAgentForm::class, $possession);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $possession->setAgent($agent);
            $possession->setCreatedAt(new \DateTime('now'));

            foreach ($originalOwnout as $ownout)
            {
                if (false === $possession->getOwnoutbuilding()->contains($ownout))
                {
                    $ownout->setPossession(null);
                    $this->entityManager->remove($ownout);
                }
            }

            foreach ($originalPhotos as $image)
            {
                if (false === $possession->getPossessionImage()->contains($image))
                {
                    $image->setPossession(null);
                    $this->entityManager->remove($image);
                }
            }

            $ownoutbuildings = $possession->getOwnOutBuilding();
            foreach ($ownoutbuildings as $elem)
            {
                $elem->setPossession($possession);
                $this->entityManager->persist($elem);
            }

            $possessionImages = $possession->getPossessionImage();
            foreach ($possessionImages as $image)
            {
                $image->setPossession($possession);
                $this->entityManager->persist($image);
            }

            $this->entityManager->persist($possession);
            $this->entityManager->flush();

            return $this->redirectToRoute("possession_show", array("id" => $possession->getId()));
        }

        return $this->render("possession/createPossession.html.twig", array("form" => $form->createView()));
    }

    /**
     * @Route("/modify/{id}", name="modify")
     * @param $id
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function modifyPossession($id, Request $request)
    {
        $possession = $this->possessionManager->getPossessionById($id);

        $originalImages = $possession->getPossessionImage();


        $originalOwnout = new ArrayCollection();


        foreach ($possession->getOwnoutbuilding() as $ownout)
        {
            $originalOwnout->add($ownout);
        }

        $form = $this->createForm(modifyPossessionType::class, $possession);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            foreach ($originalOwnout as $ownout)
            {
                if (false === $possession->getOwnoutbuilding()->contains($ownout))
                {
                    $ownout->setPossession(null);
                    $this->entityManager->remove($ownout);
                }
            }

            $ownoutbuildings = $possession->getOwnOutBuilding();
            foreach ($ownoutbuildings as $elem)
            {
                $elem->setPossession($possession);
                $this->entityManager->persist($elem);
            }

            $possessionImages = $possession->getPossessionImage();
            foreach ($possessionImages as $image)
            {
                $image->setPossession($possession);
                $this->entityManager->persist($image);
                $possession->addPossessionImage($image);
            }

            $this->notifyFavClients($possession);

            $this->entityManager->persist($possession);
            $this->entityManager->flush();

            return $this->redirectToRoute("possession_show", array("id" => $possession->getId()));
        }

        return $this->render("possession/modifyPossession.html.twig", array("form" => $form->createView(),
            "possessionImages" => $originalImages));
    }

    /**
     * @Route("/manage", name="manage")
     * @return Response
     */
    public function managePossession(){
        $user = $this->getUser();
        $agent = $this->agentManager->getAgentByUser($user);
        $possessions = $agent->getPossessions();
        return $this->render('possession/managePossessions.html.twig', ['possessions' => $possessions]);
    }

    /**
     * @Route("/show/{id}", name="show")
     * @param $id
     * @return Response
     */
    public function showPossession($id)
    {
        if($this->getUser()->getRoles() == ["ROLE_CLIENT"]) {
            $possession = $this->entityManager->getRepository(Possession::class)->find($id);

            $client = $this->clientManager->getClientByUser($this->getUser());

            if ($this->favoriteManager->getFavorite($possession, $client) == null) {
                $isFavorite = false;
            } else {
                $isFavorite = true;
            }
            $possessionOutbuildings = $possession->getOwnOutbuilding();

            $images = $possession->getPossessionImage();

            $agency = $possession->getAgent()->getAgency();

            return $this->render("possession/showPossession.html.twig", array("possession" => $possession,
                "possOwnOutbuilding" => $possessionOutbuildings,
                "isFavorite" => $isFavorite,
                "images" => $images,
                "agency" => $agency));
        }
        else{
            $possession = $this->entityManager->getRepository(Possession::class)->find($id);
            $possessionOutbuildings = $possession->getOwnOutbuilding();

            $images = $possession->getPossessionImage();

            $agency = $possession->getAgent()->getAgency();

            return $this->render("possession/showPossession.html.twig", array("possession" => $possession,
                "possOwnOutbuilding" => $possessionOutbuildings,
                "images" => $images,
                "agency" => $agency));
        }
    }



    /**
     * @Route("/addToFavorite/{id}", name="addToFavorites")
     * @param $id
     * @return RedirectResponse
     */
    public function addToFavorites($id){
        $possession = $this->possessionManager->getPossessionById($id);
        $this->clientManager->addToFavorites($possession, $this->getUser());
        $this->addFlash('success','Favori ajouté');
        return $this->redirectToRoute('possession_show', array("id" => $id));
    }

    /**
     * @Route("/removeFromFavorites/{id}", name="removeFromFavorites")
     * @param $id
     * @return RedirectResponse
     */
    public function removeFromFavorites($id){
        $possession = $this->possessionManager->getPossessionById($id);
        $this->clientManager->removeFromFavorites($possession, $this->getUser());
        $this->addFlash('success','Favori supprimé');
        return $this->redirectToRoute('possession_show', array("id" => $id));
    }

    public function notifyFavClients(Possession $possession)
    {
        $userManager = new UserManager($this->entityManager, $this->security);
        $clientManager = new ClientManager($this->entityManager);

        $clients = $clientManager->getClientsWithPossessionAsFavorite($possession);

        foreach ($clients as $client) {
            $user = $client->getUser();
            $userManager->increaseNotification($user);
            $this->entityManager->persist($user);
//            $this->entityManager->flush();

        }
        $this->entityManager->flush();
    }
}
