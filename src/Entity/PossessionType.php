<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PossessionTypeRepository")
 */
class PossessionType
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
     * @ORM\OneToMany(targetEntity="App\Entity\Possession", mappedBy="type")
     */
    private $possessions;

    /**
     * PossessionType constructor.
     */
    public function __construct()
    {
        $this->possessions = new ArrayCollection();
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
     * @return PossessionType
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Possession[]
     */
    public function getPossessions(): Collection
    {
        return $this->possessions;
    }

    /**
     * @param Possession $possession
     * @return PossessionType
     */
    public function addPossession(Possession $possession): self
    {
        if (!$this->possessions->contains($possession)) {
            $this->possessions[] = $possession;
            $possession->setType($this);
        }

        return $this;
    }

    /**
     * @param Possession $possession
     * @return PossessionType
     */
    public function removePossession(Possession $possession): self
    {
        if ($this->possessions->contains($possession)) {
            $this->possessions->removeElement($possession);
            // set the owning side to null (unless already changed)
            if ($possession->getType() === $this) {
                $possession->setType(null);
            }
        }

        return $this;
    }
}
