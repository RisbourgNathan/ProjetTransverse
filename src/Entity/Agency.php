<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AgencyRepository")
 * @UniqueEntity(fields={"is_main_agency"}, ignoreNull=true, message="There already is a main agency")
 */
class Agency
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
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
     * @ORM\Column(type="boolean", nullable=true)
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $phone;

    /**
     * Agency constructor.
     */
    public function __construct()
    {
        $this->agents = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Agency
     */
    public function setName(string $name): self
    {
        $this->name = $name;

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
     * @return Agency
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
     * @return Agency
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
     * @param string $street
     * @return Agency
     */
    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsMainAgency(): ?bool
    {
        return $this->is_main_agency;
    }

    /**
     * @param bool|null $is_main_agency
     * @return Agency
     */
    public function setIsMainAgency(?bool $is_main_agency): self
    {
        $this->is_main_agency = $is_main_agency;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getAgencyCost(): ?int
    {
        return $this->agency_cost;
    }

    /**
     * @param int $agency_cost
     * @return Agency
     */
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

    /**
     * @param Agent $agent
     * @return Agency
     */
    public function addAgent(Agent $agent): self
    {
        if (!$this->agents->contains($agent)) {
            $this->agents[] = $agent;
            $agent->setAgency($this);
        }

        return $this;
    }

    /**
     * @param Agent $agent
     * @return Agency
     */
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

    /**
     * @return null|string
     */
    public function getPicturePath(): ?string
    {
        return $this->picture_path;
    }

    /**
     * @param null|string $picture_path
     * @return Agency
     */
    public function setPicturePath(?string $picture_path): self
    {
        $this->picture_path = $picture_path;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPhone(): ?int
    {
        return $this->phone;
    }

    /**
     * @param int|null $phone
     * @return Agency
     */
    public function setPhone(?int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
