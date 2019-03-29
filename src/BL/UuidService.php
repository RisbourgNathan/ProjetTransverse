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
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Security;

class UuidService
{

    private $userManager;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->userManager = new UserManager($entityManager, $security);
    }

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

    public function setUserSponsorship(User $user): void
    {
        $user->setSponsorshipCode($this->createUuid());
        $user->setSponsorshipCodeState(false);
    }

    public function createUuid()
    {
        try {
            return Uuid::uuid4();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}