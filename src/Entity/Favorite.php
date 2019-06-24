<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FavoriteRepository")
 */
class Favorite
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Possession", inversedBy="favorites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $possession;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="favorites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $hasNotification;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPossession(): ?Possession
    {
        return $this->possession;
    }

    public function setPossession(?Possession $possession): self
    {
        $this->possession = $possession;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getHasNotification(): ?bool
    {
        return $this->hasNotification;
    }

    public function setHasNotification(?bool $hasNotification): self
    {
        $this->hasNotification = $hasNotification;

        return $this;
    }
}
