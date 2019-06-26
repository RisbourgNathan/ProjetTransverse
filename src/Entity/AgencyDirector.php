<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AgencyDirectorRepository")
 */
class AgencyDirector
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="agencyDirectors")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Agency", inversedBy="agencyDirectors")
     */
    private $agency;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return AgencyDirector
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Agency|null
     */
    public function getAgency(): ?Agency
    {
        return $this->agency;
    }

    /**
     * @param Agency|null $agency
     * @return AgencyDirector
     */
    public function setAgency(?Agency $agency): self
    {
        $this->agency = $agency;

        return $this;
    }
}
