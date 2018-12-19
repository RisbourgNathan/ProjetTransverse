<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AgencyRepository")
 */
class Agency
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $zip_code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $street;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_main_agency;

    /**
     * @ORM\Column(type="integer")
     */
    private $agency_cost;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Agent", mappedBy="agency", orphanRemoval=true)
     */
    private $agents;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture_path;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AgencyDirector", mappedBy="agency")
     */
    private $agencyDirectors;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Client", mappedBy="agency")
     */
    private $clients;

    public function __construct()
    {
        $this->agents = new ArrayCollection();
        $this->agencyDirectors = new ArrayCollection();
        $this->clients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getIsMainAgency(): ?bool
    {
        return $this->is_main_agency;
    }

    public function setIsMainAgency(bool $is_main_agency): self
    {
        $this->is_main_agency = $is_main_agency;

        return $this;
    }

    public function getAgencyCost(): ?int
    {
        return $this->agency_cost;
    }

    public function setAgencyCost(int $agency_cost): self
    {
        $this->agency_cost = $agency_cost;

        return $this;
    }

    /**
     * @return Collection|Agent[]
     */
    public function getAgents(): Collection
    {
        return $this->agents;
    }

    public function addAgent(Agent $agent): self
    {
        if (!$this->agents->contains($agent)) {
            $this->agents[] = $agent;
            $agent->setAgency($this);
        }

        return $this;
    }

    public function removeAgent(Agent $agent): self
    {
        if ($this->agents->contains($agent)) {
            $this->agents->removeElement($agent);
            // set the owning side to null (unless already changed)
            if ($agent->getAgency() === $this) {
                $agent->setAgency(null);
            }
        }

        return $this;
    }

    public function getPicturePath(): ?string
    {
        return $this->picture_path;
    }

    public function setPicturePath(?string $picture_path): self
    {
        $this->picture_path = $picture_path;

        return $this;
    }

    /**
     * @return Collection|AgencyDirector[]
     */
    public function getAgencyDirectors(): Collection
    {
        return $this->agencyDirectors;
    }

    public function addAgencyDirector(AgencyDirector $agencyDirector): self
    {
        if (!$this->agencyDirectors->contains($agencyDirector)) {
            $this->agencyDirectors[] = $agencyDirector;
            $agencyDirector->setAgency($this);
        }

        return $this;
    }

    public function removeAgencyDirector(AgencyDirector $agencyDirector): self
    {
        if ($this->agencyDirectors->contains($agencyDirector)) {
            $this->agencyDirectors->removeElement($agencyDirector);
            // set the owning side to null (unless already changed)
            if ($agencyDirector->getAgency() === $this) {
                $agencyDirector->setAgency(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setAgency($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->contains($client)) {
            $this->clients->removeElement($client);
            // set the owning side to null (unless already changed)
            if ($client->getAgency() === $this) {
                $client->setAgency(null);
            }
        }

        return $this;
    }
}
