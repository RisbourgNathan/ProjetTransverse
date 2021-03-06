<?php

namespace App\Entity;

use App\BL\UserManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectManagerAware;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Symfony\Component\Security\Core\Security;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PossessionRepository")
 * @ORM\Table(name="possession", indexes={@Index(name="title_idx",columns={"title"})})
 * @ORM\HasLifecycleCallbacks()
 */
class Possession implements ObjectManagerAware
{
    public static $STATE_SOLD = "SOLD";
    public static $STATE_SELL = "SELL";
    private $entityManager;
    private $security;

    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $surface;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $roomNumber;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $floorNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $zip_code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $street;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $minimumPrice;

    /**
     * @ORM\Column(type="integer")
     */
    private $sellingPrice;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $validationState;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PossessionType", inversedBy="possessions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="possessions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $seller;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\OutBuilding", mappedBy="ownOutBuilding")
     */
    private $outBuildings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OwnOutBuilding", mappedBy="possession", cascade={"persist"})
     */
    private $ownOutBuilding;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Proposition", mappedBy="possession")
     */
    private $proposition;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Client", mappedBy="favoritePossessions")
     * @ORM\JoinColumn(nullable=true)
     */
    private $clientsWithThisPossessionAsFavorite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Agent", inversedBy="possessions")
     */
    private $agent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PossessionImage", mappedBy="possession", orphanRemoval=true)
     */
    private $possessionImages;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $orientation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $constructionDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Favorite", mappedBy="possession", orphanRemoval=true)
     */
    private $favorites;

    /**
     * Possession constructor.
     */
    public function __construct()
    {
        $this->outBuildings = new ArrayCollection();
        $this->ownOutBuilding = new ArrayCollection();
        $this->proposition = new ArrayCollection();
        $this->clientsWithThisPossessionAsFavorite = new ArrayCollection();
        $this->possessionImages = new ArrayCollection();
        $this->favorites = new ArrayCollection();

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getSurface(): ?int
    {
        return $this->surface;
    }

    /**
     * @param int|null $surface
     * @return Possession
     */
    public function setSurface(?int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getRoomNumber(): ?int
    {
        return $this->roomNumber;
    }

    /**
     * @param int|null $roomNumber
     * @return Possession
     */
    public function setRoomNumber(?int $roomNumber): self
    {
        $this->roomNumber = $roomNumber;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getFloorNumber(): ?int
    {
        return $this->floorNumber;
    }

    /**
     * @param int|null $floorNumber
     * @return Possession
     */
    public function setFloorNumber(?int $floorNumber): self
    {
        $this->floorNumber = $floorNumber;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return Possession
     */
    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getZipCode(): ?string
    {
        return $this->zip_code;
    }

    /**
     * @param string $zip_code
     * @return Possession
     */
    public function setZipCode(string $zip_code): self
    {
        $this->zip_code = $zip_code;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param null|string $street
     * @return Possession
     */
    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMinimumPrice(): ?int
    {
        return $this->minimumPrice;
    }

    /**
     * @param int|null $minimumPrice
     * @return Possession
     */
    public function setMinimumPrice(?int $minimumPrice): self
    {
        $this->minimumPrice = $minimumPrice;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getSellingPrice(): ?int
    {
        return $this->sellingPrice;
    }

    /**
     * @param int $sellingPrice
     * @return Possession
     */
    public function setSellingPrice(int $sellingPrice): self
    {
        $this->sellingPrice = $sellingPrice;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     * @return Possession
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getValidationState(): ?string
    {
        return $this->validationState;
    }

    /**
     * @param null|string $validationState
     * @return Possession
     */
    public function setValidationState(?string $validationState): self
    {
        $this->validationState = $validationState;

        return $this;
    }

    /**
     * @return PossessionType|null
     */
    public function getType(): ?PossessionType
    {
        return $this->type;
    }

    /**
     * @param PossessionType|null $type
     * @return Possession
     */
    public function setType(?PossessionType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Client|null
     */
    public function getSeller(): ?Client
    {
        return $this->seller;
    }

    /**
     * @param Client|null $seller
     * @return Possession
     */
    public function setSeller(?Client $seller): self
    {
        $this->seller = $seller;

        return $this;
    }

    /**
     * @return Collection|OutBuilding[]
     */
    public function getOutBuildings(): Collection
    {
        return $this->outBuildings;
    }

    /**
     * @param OutBuilding $outBuilding
     * @return Possession
     */
    public function addOutBuilding(OutBuilding $outBuilding): self
    {
        if (!$this->outBuildings->contains($outBuilding)) {
            $this->outBuildings[] = $outBuilding;
            $outBuilding->addOwnOutBuilding($this);
        }

        return $this;
    }

    /**
     * @param OutBuilding $outBuilding
     * @return Possession
     */
    public function removeOutBuilding(OutBuilding $outBuilding): self
    {
        if ($this->outBuildings->contains($outBuilding)) {
            $this->outBuildings->removeElement($outBuilding);
            $outBuilding->removeOwnOutBuilding($this);
        }

        return $this;
    }

    /**
     * @return Collection|OwnOutBuilding[]
     */
    public function getOwnOutBuilding(): Collection
    {
        return $this->ownOutBuilding;
    }

    /**
     * @param OwnOutBuilding $ownOutBuilding
     * @return Possession
     */
    public function addOwnOutBuilding(OwnOutBuilding $ownOutBuilding): self
    {
        if (!$this->ownOutBuilding->contains($ownOutBuilding)) {
            $this->ownOutBuilding[] = $ownOutBuilding;
            $ownOutBuilding->setPossession($this);
        }

        return $this;
    }

    /**
     * @param OwnOutBuilding $ownOutBuilding
     * @return Possession
     */
    public function removeOwnOutBuilding(OwnOutBuilding $ownOutBuilding): self
    {
        if ($this->ownOutBuilding->contains($ownOutBuilding)) {
            $this->ownOutBuilding->removeElement($ownOutBuilding);
            // set the owning side to null (unless already changed)
            if ($ownOutBuilding->getPossession() === $this) {
                $ownOutBuilding->setPossession(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Proposition[]
     */
    public function getProposition(): Collection
    {
        return $this->proposition;
    }

    /**
     * @param Proposition $proposition
     * @return Possession
     */
    public function addProposition(Proposition $proposition): self
    {
        if (!$this->proposition->contains($proposition)) {
            $this->proposition[] = $proposition;
            $proposition->setPossession($this);
        }

        return $this;
    }

    /**
     * @param Proposition $proposition
     * @return Possession
     */
    public function removeProposition(Proposition $proposition): self
    {
        if ($this->proposition->contains($proposition)) {
            $this->proposition->removeElement($proposition);
            // set the owning side to null (unless already changed)
            if ($proposition->getPossession() === $this) {
                $proposition->setPossession(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClientsWithThisPossessionAsFavorite(): Collection
    {
        return $this->clientsWithThisPossessionAsFavorite;
    }

    /**
     * @param Client $clientsWithThisPossessionAsFavorite
     * @return Possession
     */
    public function addClientsWithThisPossessionAsFavorite(Client $clientsWithThisPossessionAsFavorite): self
    {
        if (!$this->clientsWithThisPossessionAsFavorite->contains($clientsWithThisPossessionAsFavorite)) {
            $this->clientsWithThisPossessionAsFavorite[] = $clientsWithThisPossessionAsFavorite;
            $clientsWithThisPossessionAsFavorite->addFavoritePossession($this);
        }

        return $this;
    }

    /**
     * @param Client $clientsWithThisPossessionAsFavorite
     * @return Possession
     */
    public function removeClientsWithThisPossessionAsFavorite(Client $clientsWithThisPossessionAsFavorite): self
    {
        if ($this->clientsWithThisPossessionAsFavorite->contains($clientsWithThisPossessionAsFavorite)) {
            $this->clientsWithThisPossessionAsFavorite->removeElement($clientsWithThisPossessionAsFavorite);
            $clientsWithThisPossessionAsFavorite->removeFavoritePossession($this);
        }

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Possession
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Agent|null
     */
    public function getAgent(): ?Agent
    {
        return $this->agent;
    }

    /**
     * @param Agent|null $agent
     * @return Possession
     */
    public function setAgent(?Agent $agent): self
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * @return Collection|PossessionImage[]
     */
    public function getPossessionImage(): Collection
    {
        return $this->possessionImages;
    }

    /**
     * @param PossessionImage $possessionImage
     * @return Possession
     */
    public function addPossessionImage(PossessionImage $possessionImage): self
    {
        if (!$this->possessionImages->contains($possessionImage)) {
            $this->possessionImages[] = $possessionImage;
            $possessionImage->setPossession($this);
        }

        return $this;
    }

    /**
     * @param PossessionImage $possessionImage
     * @return Possession
     */
    public function removePossessionImage(PossessionImage $possessionImage): self
    {
        if ($this->possessionImages->contains($possessionImage)) {
            $this->possessionImages->removeElement($possessionImage);
            // set the owning side to null (unless already changed)
            if ($possessionImage->getPossession() === $this) {
                $possessionImage->setPossession(null);
            }
        }

        return $this;
    }

    /**
     * @param $value
     */
    public function setPossessionImages($value)
    {
        $this->possessionImages = $value;
    }

    /**
     * @return Collection|PossessionImage[]
     */
    public function getPossessionImages(): Collection
    {
        return $this->possessionImages;
    }

    /**
     * @return null|string
     */
    public function getOrientation(): ?string
    {
        return $this->orientation;
    }

    /**
     * @param string $Orientation
     * @return Possession
     */
    public function setOrientation(string $Orientation): self
    {
        $this->orientation = $Orientation;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getConstructionDate(): ?int
    {
        return $this->constructionDate;
    }

    /**
     * @param int|null $constructionDate
     * @return Possession
     */
    public function setConstructionDate(?int $constructionDate): self
    {
        $this->constructionDate = $constructionDate;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface|null $createdAt
     * @return Possession
     */
    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|Favorite[]
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    /**
     * @param Favorite $favorite
     * @return Possession
     */
    public function addFavorite(Favorite $favorite): self
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites[] = $favorite;
            $favorite->setPossession($this);
        }

        return $this;
    }

    /**
     * @param Favorite $favorite
     * @return Possession
     */
    public function removeFavorite(Favorite $favorite): self
    {
        if ($this->favorites->contains($favorite)) {
            $this->favorites->removeElement($favorite);
            // set the owning side to null (unless already changed)
            if ($favorite->getPossession() === $this) {
                $favorite->setPossession(null);
            }
        }

        return $this;
    }

    /**
     * @param PreFlushEventArgs $args
     */
    public function sendNotifications(PreFlushEventArgs $args)
    {
        $em = $args->getEntityManager();

        $clients = $this->getClientsWithThisPossessionAsFavorite();

        foreach ($clients as $client) {
            $user = $client->getUser();
//            $user->setNotifications($user->getNotifications() + 1);
            $user->setNotifications(99);
//            $this->entityManager->persist($user);
//            $this->entityManager->flush();

//            $em->persist($user);
//            $em->flush();
        }
//        $this->entityManager->flush();
    }

    /**
     * Injects responsible ObjectManager and the ClassMetadata into this persistent object.
     *
     * @param ObjectManager $objectManager
     * @param ClassMetadata $classMetadata
     * @return void
     */
    public function injectObjectManager(ObjectManager $objectManager, ClassMetadata $classMetadata)
    {
        $this->entityManager = $objectManager;
    }
}
