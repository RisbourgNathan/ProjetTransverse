<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PossessionRepository")
 */
class Possession
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
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
     * @ORM\Column(type="string", length=255, nullable=true)
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
     * @ORM\OneToMany(targetEntity="App\Entity\OwnOutBuilding", mappedBy="possession")
     */
    private $ownOutBuilding;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Proposition", mappedBy="possession")
     */
    private $proposition;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Client", mappedBy="favoritePossessions")
     */
    private $clientsWithThisPossessionAsFavorite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $picture_path;

    public function __construct()
    {
        $this->outBuildings = new ArrayCollection();
        $this->ownOutBuilding = new ArrayCollection();
        $this->proposition = new ArrayCollection();
        $this->clientsWithThisPossessionAsFavorite = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(?int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getRoomNumber(): ?int
    {
        return $this->roomNumber;
    }

    public function setRoomNumber(?int $roomNumber): self
    {
        $this->roomNumber = $roomNumber;

        return $this;
    }

    public function getFloorNumber(): ?int
    {
        return $this->floorNumber;
    }

    public function setFloorNumber(?int $floorNumber): self
    {
        $this->floorNumber = $floorNumber;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zip_code;
    }

    public function setZipCode(string $zip_code): self
    {
        $this->zip_code = $zip_code;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getMinimumPrice(): ?int
    {
        return $this->minimumPrice;
    }

    public function setMinimumPrice(?int $minimumPrice): self
    {
        $this->minimumPrice = $minimumPrice;

        return $this;
    }

    public function getSellingPrice(): ?int
    {
        return $this->sellingPrice;
    }

    public function setSellingPrice(int $sellingPrice): self
    {
        $this->sellingPrice = $sellingPrice;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getValidationState(): ?string
    {
        return $this->validationState;
    }

    public function setValidationState(?string $validationState): self
    {
        $this->validationState = $validationState;

        return $this;
    }

    public function getType(): ?PossessionType
    {
        return $this->type;
    }

    public function setType(?PossessionType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSeller(): ?Client
    {
        return $this->seller;
    }

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

    public function addOutBuilding(OutBuilding $outBuilding): self
    {
        if (!$this->outBuildings->contains($outBuilding)) {
            $this->outBuildings[] = $outBuilding;
            $outBuilding->addOwnOutBuilding($this);
        }

        return $this;
    }

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

    public function addOwnOutBuilding(OwnOutBuilding $ownOutBuilding): self
    {
        if (!$this->ownOutBuilding->contains($ownOutBuilding)) {
            $this->ownOutBuilding[] = $ownOutBuilding;
            $ownOutBuilding->setPossession($this);
        }

        return $this;
    }

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

    public function addProposition(Proposition $proposition): self
    {
        if (!$this->proposition->contains($proposition)) {
            $this->proposition[] = $proposition;
            $proposition->setPossession($this);
        }

        return $this;
    }

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

    public function addClientsWithThisPossessionAsFavorite(Client $clientsWithThisPossessionAsFavorite): self
    {
        if (!$this->clientsWithThisPossessionAsFavorite->contains($clientsWithThisPossessionAsFavorite)) {
            $this->clientsWithThisPossessionAsFavorite[] = $clientsWithThisPossessionAsFavorite;
            $clientsWithThisPossessionAsFavorite->addFavoritePossession($this);
        }

        return $this;
    }

    public function removeClientsWithThisPossessionAsFavorite(Client $clientsWithThisPossessionAsFavorite): self
    {
        if ($this->clientsWithThisPossessionAsFavorite->contains($clientsWithThisPossessionAsFavorite)) {
            $this->clientsWithThisPossessionAsFavorite->removeElement($clientsWithThisPossessionAsFavorite);
            $clientsWithThisPossessionAsFavorite->removeFavoritePossession($this);
        }

        return $this;
    }

    public function getPicturePath(): ?string
    {
        return $this->picture_path;
    }

    public function setPicturePath(string $picture_path): self
    {
        $this->picture_path = $picture_path;
        return $this;
    }
}
