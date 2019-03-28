<?php

namespace App\Controller;

use App\BL\PossessionManager;
use App\BL\PossessionTypeManager;
use App\Entity\Agent;
use App\Entity\Client;
use App\Entity\Possession;
use App\Entity\PossessionImage;
use App\Entity\User;
use App\Forms\addPossessionByAgentForm;
use App\Forms\SearchForm;
use phpDocumentor\Reflection\DocBlock\Description;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Forms\modifyPossessionType;
use App\Entity\PossessionType;
use App\Forms\removePossessionImageType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use http\Exception;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
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
    private $registry;
    private $uploaderHelper;

    /**
     * PossessionController constructor.
     * @param EntityManagerInterface $entityManager
     * @param Security $security
     * @param UploaderHelper $uploaderHelper
     */
    public function __construct(EntityManagerInterface $entityManager, Security $security, RegistryInterface $registry, UploaderHelper $uploaderHelper)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->registry = $registry;
        $this->possessionManager = new PossessionManager($entityManager, $registry);
        $this->possessionTypeManager = new PossessionTypeManager($entityManager);
        $this->uploaderHelper = $uploaderHelper;
    }

    /**
     * @Route("/list", name="list")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
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
            $possessions = $this->possessionManager->getPossessionsBySearch($city, $price, $array_id);
        }
        else{
            $possessions = $this->possessionManager->getAllPossessions();
        }

        if (count($possessions) == 0)
        {
            $possessions = null;
        };
        dump($possessions);
        return $this->render("possession/listPossessions.html.twig", array(
            "possessions" => $possessions,
            'form' => $form->createView()
        ));

    }

    /**
     * @Route("/createByAgent")
     * @\Sensio\Bundle\FrameworkExtraBundle\Configuration\Security("has_role('ROLE_AGENT')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createPossessionByAgent(Request $request)
    {

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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
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

            $this->entityManager->persist($possession);
            $this->entityManager->flush();

            return $this->redirectToRoute("possession_show", array("id" => $possession->getId()));
        }

        return $this->render("possession/modifyPossession.html.twig", array("form" => $form->createView(),
            "possessionImages" => $originalImages));
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function showPossession($id)
    {
        $possession = $this->entityManager->getRepository(Possession::class)->find($id);
        $possessionOutbuildings = $possession->getOwnOutbuilding();

        $images = $possession->getPossessionImage();

        return $this->render("possession/showPossession.html.twig", array("possession" => $possession,
            "possOwnOutbuilding" => $possessionOutbuildings,
            "images" => $images));
    }
}
