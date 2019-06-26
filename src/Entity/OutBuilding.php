<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OutBuildingRepository")
 */
class OutBuilding
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
     * @ORM\OneToMany(targetEntity="App\Entity\OwnOutBuilding", mappedBy="outBuilding")
     */
    private $ownOutBuilding;


    /**
     * OutBuilding constructor.
     */
    public function __construct()
    {
        $this->ownOutBuilding = new ArrayCollection();
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
     * @return OutBuilding
     */
    public function setName(string $name): self
    {
        $this->name = $name;

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
     * @return OutBuilding
     */
    public function addOwnOutBuilding(OwnOutBuilding $ownOutBuilding): self
    {
        if (!$this->ownOutBuilding->contains($ownOutBuilding)) {
            $this->ownOutBuilding[] = $ownOutBuilding;
            $ownOutBuilding->setOutBuilding($this);
        }

        return $this;
    }

    /**
     * @param OwnOutBuilding $ownOutBuilding
     * @return OutBuilding
     */
    public function removeOwnOutBuilding(OwnOutBuilding $ownOutBuilding): self
    {
        if ($this->ownOutBuilding->contains($ownOutBuilding)) {
            $this->ownOutBuilding->removeElement($ownOutBuilding);
            // set the owning side to null (unless already changed)
            if ($ownOutBuilding->getOutBuilding() === $this) {
                $ownOutBuilding->setOutBuilding(null);
            }
        }

        return $this;
    }
}
