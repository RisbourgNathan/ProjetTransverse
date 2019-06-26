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
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @param int $price
     * @return Proposition
     */
    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param \DateTimeInterface $date
     * @return Proposition
     */
    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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
     * @return Proposition
     */
    public function setPossession(?Possession $possession): self
    {
        $this->possession = $possession;

        return $this;
    }

    /**
     * @return Client|null
     */
    public function getClient(): ?Client
    {
        return $this->client;
    }

    /**
     * @param Client|null $client
     * @return Proposition
     */
    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Proposition|null
     */
    public function getCounterProposition(): ?self
    {
        return $this->counterProposition;
    }

    /**
     * @param null|self $counterProposition
     * @return Proposition
     */
    public function setCounterProposition(?self $counterProposition): self
    {
        $this->counterProposition = $counterProposition;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getOldPrice(): ?float
    {
        return $this->oldPrice;
    }

    /**
     * @param float|null $oldPrice
     * @return Proposition
     */
    public function setOldPrice(?float $oldPrice): self
    {
        $this->oldPrice = $oldPrice;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getOldDate(): ?\DateTimeInterface
    {
        return $this->oldDate;
    }

    /**
     * @param \DateTimeInterface|null $oldDate
     * @return Proposition
     */
    public function setOldDate(?\DateTimeInterface $oldDate): self
    {
        $this->oldDate = $oldDate;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param null|string $state
     * @return Proposition
     */
    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getShouldBeDisplayed(): ?bool
    {
        return $this->shouldBeDisplayed;
    }

    /**
     * @param bool|null $shouldBeDisplayed
     * @return Proposition
     */
    public function setShouldBeDisplayed(?bool $shouldBeDisplayed): self
    {
        $this->shouldBeDisplayed = $shouldBeDisplayed;

        return $this;
    }
}
