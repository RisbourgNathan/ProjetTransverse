<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="clients")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="sponsor")
     */
    private $sponsor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Possession", mappedBy="seller", orphanRemoval=true)
     */
    private $possessions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Proposition", mappedBy="client")
     */
    private $Proposition;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Possession", inversedBy="clientsWithThisPossessionAsFavorite")
     */
    private $favoritePossessions;

    public function __construct()
    {
        $this->sponsor = new ArrayCollection();
        $this->possessions = new ArrayCollection();
        $this->Proposition = new ArrayCollection();
        $this->favoritePossessions = new ArrayCollection();
    }



    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSponsor(): ?self
    {
        return $this->sponsor;
    }

    public function setSponsor(?self $sponsor): self
    {
        $this->sponsor = $sponsor;

        return $this;
    }

    public function addSponsor(self $sponsor): self
    {
        if (!$this->sponsor->contains($sponsor)) {
            $this->sponsor[] = $sponsor;
            $sponsor->setSponsor($this);
        }

        return $this;
    }

    public function removeSponsor(self $sponsor): self
    {
        if ($this->sponsor->contains($sponsor)) {
            $this->sponsor->removeElement($sponsor);
            // set the owning side to null (unless already changed)
            if ($sponsor->getSponsor() === $this) {
                $sponsor->setSponsor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Possession[]
     */
    public function getPossessions(): Collection
    {
        return $this->possessions;
    }

    public function addPossession(Possession $possession): self
    {
        if (!$this->possessions->contains($possession)) {
            $this->possessions[] = $possession;
            $possession->setSeller($this);
        }

        return $this;
    }

    public function removePossession(Possession $possession): self
    {
        if ($this->possessions->contains($possession)) {
            $this->possessions->removeElement($possession);
            // set the owning side to null (unless already changed)
            if ($possession->getSeller() === $this) {
                $possession->setSeller(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Proposition[]
     */
    public function getProposition(): Collection
    {
        return $this->Proposition;
    }

    public function addProposition(Proposition $proposition): self
    {
        if (!$this->Proposition->contains($proposition)) {
            $this->Proposition[] = $proposition;
            $proposition->setClient($this);
        }

        return $this;
    }

    public function removeProposition(Proposition $proposition): self
    {
        if ($this->Proposition->contains($proposition)) {
            $this->Proposition->removeElement($proposition);
            // set the owning side to null (unless already changed)
            if ($proposition->getClient() === $this) {
                $proposition->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Possession[]
     */
    public function getFavoritePossessions(): Collection
    {
        return $this->favoritePossessions;
    }

    public function addFavoritePossession(Possession $favoritePossession): self
    {
        if (!$this->favoritePossessions->contains($favoritePossession)) {
            $this->favoritePossessions[] = $favoritePossession;
        }

        return $this;
    }

    public function removeFavoritePossession(Possession $favoritePossession): self
    {
        if ($this->favoritePossessions->contains($favoritePossession)) {
            $this->favoritePossessions->removeElement($favoritePossession);
        }

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }
}
