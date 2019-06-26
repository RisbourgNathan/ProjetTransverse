<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OwnOutBuildingRepository")
 */
class OwnOutBuilding
{
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Possession", inversedBy="ownOutBuilding")
     * @ORM\JoinColumn(nullable=false)
     */
    private $possession;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OutBuilding", inversedBy="ownOutBuilding")
     * @ORM\JoinColumn(nullable=false)
     */
    private $outBuilding;

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
     * @return OwnOutBuilding
     */
    public function setSurface(?int $surface): self
    {
        $this->surface = $surface;

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
     * @return OwnOutBuilding
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Possession|null
     */
    public function getPossession(): ?Possession
    {
        return $this->possession;
    }

    /**
     * @param Possession|null $possession
     * @return OwnOutBuilding
     */
    public function setPossession(?Possession $possession): self
    {
        $this->possession = $possession;

        return $this;
    }

    /**
     * @return OutBuilding|null
     */
    public function getOutBuilding(): ?OutBuilding
    {
        return $this->outBuilding;
    }

    /**
     * @param OutBuilding|null $outBuilding
     * @return OwnOutBuilding
     */
    public function setOutBuilding(?OutBuilding $outBuilding): self
    {
        $this->outBuilding = $outBuilding;

        return $this;
    }
}
