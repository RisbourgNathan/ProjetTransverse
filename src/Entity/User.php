<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Index;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="useracc", indexes={@Index(name="email_idx", columns={"email"})})
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $zip_code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Agent", mappedBy="user")
     */
    private $agents;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Client", mappedBy="user")
     */
    private $clients;
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Administrator", mappedBy="user")
     */
    private $administrators;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AgencyDirector", mappedBy="user")
     */
    private $agencyDirectors;

    /**
     * @ORM\Column(type="uuid", nullable=true)
     */
    private $sponsorshipCode;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $sponsorshipCodeState;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $notifications;

    public function __construct()
    {
        $this->agents = new ArrayCollection();
        $this->clients = new ArrayCollection();
        $this->administrators = new ArrayCollection();
        $this->agencyDirectors = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zip_code;
    }

    public function setZipCode(?string $zip_code): self
    {
        $this->zip_code = $zip_code;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

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
            $agent->setUser($this);
        }

        return $this;
    }

    public function removeAgent(Agent $agent): self
    {
        if ($this->agents->contains($agent)) {
            $this->agents->removeElement($agent);
            // set the owning side to null (unless already changed)
            if ($agent->getUser() === $this) {
                $agent->setUser(null);
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
            $client->setUser($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->contains($client)) {
            $this->clients->removeElement($client);
            // set the owning side to null (unless already changed)
            if ($client->getUser() === $this) {
                $client->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Administrator[]
     */
    public function getAdministrators(): Collection
    {
        return $this->administrators;
    }

    public function addAdministrator(Administrator $administrator): self
    {
        if (!$this->administrators->contains($administrator)) {
            $this->administrators[] = $administrator;
            $administrator->setUser($this);
        }

        return $this;
    }

    public function removeAdministrator(Administrator $administrator): self
    {
        if ($this->administrators->contains($administrator)) {
            $this->administrators->removeElement($administrator);
            // set the owning side to null (unless already changed)
            if ($administrator->getUser() === $this) {
                $administrator->setUser(null);
            }
        }

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
            $agencyDirector->setUser($this);
        }

        return $this;
    }

    public function removeAgencyDirector(AgencyDirector $agencyDirector): self
    {
        if ($this->agencyDirectors->contains($agencyDirector)) {
            $this->agencyDirectors->removeElement($agencyDirector);
            // set the owning side to null (unless already changed)
            if ($agencyDirector->getUser() === $this) {
                $agencyDirector->setUser(null);
            }
        }

        return $this;
    }

    public function getSponsorshipCode()
    {
        return $this->sponsorshipCode;
    }

    public function setSponsorshipCode($sponsorshipCode): self
    {
        $this->sponsorshipCode = $sponsorshipCode;

        return $this;
    }

    public function getSponsorshipCodeState(): ?bool
    {
        return $this->sponsorshipCodeState;
    }

    public function setSponsorshipCodeState(?bool $sponsorshipCodeState): self
    {
        $this->sponsorshipCodeState = $sponsorshipCodeState;

        return $this;
    }

    public function getNotifications(): ?int
    {
        return $this->notifications;
    }

    public function setNotifications(?int $notifications): self
    {
        $this->notifications = $notifications;

        return $this;
    }
}
