<?php
/**
 * Created by PhpStorm.
 * User: NathanR
 * Date: 3/29/2019
 * Time: 3:38 PM
 */

namespace App\BL;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Class UuidService
 * @package App\BL
 */
class UuidService
{
    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * UuidService constructor.
     * @param EntityManagerInterface $entityManager
     * @param Security $security
     */
    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->userManager = new UserManager($entityManager, $security);
    }

    /**
     * @param $codeToTest
     * @return User|null
     */
    public function getSponsorFromCode($codeToTest): ?User
    {
        $usersToTest = $this->userManager->getUsersOfClients();
        foreach ($usersToTest as $user)
        {
            if ($user->getSponsorshipCode() == $codeToTest && $user->getSponsorshipCodeState() != true)
            {
                return $user;
            }
        }
        return null;
    }

    /**
     * @param User $user
     * @throws Exception
     */
    public function setUserSponsorship(User $user): void
    {
        $user->setSponsorshipCode($this->createUuid());
        $user->setSponsorshipCodeState(false);
    }

    /**
     * @return UuidInterface
     * @throws Exception
     */
    public function createUuid()
    {
        try {
            return Uuid::uuid4();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
