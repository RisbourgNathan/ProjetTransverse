<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PropositionRepository")
 */
class Proposition
{

    public static $STATE_PROPOSITION = 'PROPOSITION';
    public static $STATE_COUNTER_PROPOSITION = 'COUNTERPROPOSITION';
    public static $STATE_ACCEPTED = 'ACCEPTED';
    public static $STATE_DENIED = 'DENIED';

    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Possession", inversedBy="proposition")
     * @ORM\JoinColumn(nullable=false)
     */
    private $possession;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="Proposition")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Proposition", inversedBy="counterProposition", cascade={"persist", "remove"})
     */
    private $counterProposition;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $oldPrice;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $oldDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $state;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $shouldBeDisplayed;

    public function getId()
    {
        return $this->id;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
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

    public function getCounterProposition(): ?self
    {
        return $this->counterProposition;
    }

    public function setCounterProposition(?self $counterProposition): self
    {
        $this->counterProposition = $counterProposition;

        return $this;
    }

    public function getOldPrice(): ?float
    {
        return $this->oldPrice;
    }

    public function setOldPrice(?float $oldPrice): self
    {
        $this->oldPrice = $oldPrice;

        return $this;
    }

    public function getOldDate(): ?\DateTimeInterface
    {
        return $this->oldDate;
    }

    public function setOldDate(?\DateTimeInterface $oldDate): self
    {
        $this->oldDate = $oldDate;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getShouldBeDisplayed(): ?bool
    {
        return $this->shouldBeDisplayed;
    }

    public function setShouldBeDisplayed(?bool $shouldBeDisplayed): self
    {
        $this->shouldBeDisplayed = $shouldBeDisplayed;

        return $this;
    }
}
