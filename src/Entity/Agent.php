<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AgentRepository")
 */
class Agent
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Agency", inversedBy="agents")
     * @ORM\JoinColumn(nullable=true)
     */
    private $agency;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="agents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Possession", mappedBy="agent")
     */
    private $possessions;

    public function __construct()
    {
        $this->possessions = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAgency(): ?Agency
    {
        return $this->agency;
    }

    public function setAgency(?Agency $agency): self
    {
        $this->agency = $agency;

        return $this;
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
            $possession->setAgent($this);
        }

        return $this;
    }

    public function removePossession(Possession $possession): self
    {
        if ($this->possessions->contains($possession)) {
            $this->possessions->removeElement($possession);
            // set the owning side to null (unless already changed)
            if ($possession->getAgent() === $this) {
                $possession->setAgent(null);
            }
        }

        return $this;
    }
}
