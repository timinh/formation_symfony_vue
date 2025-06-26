<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CasUserProvider implements UserProviderInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->em->getRepository(User::class)->findOneBy(['username' => $identifier]);
        if($user) {
            return $user;
        }
        $user = (new User)
                ->setUsername($identifier)
                ->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordHasher->hashPassword($user, $identifier));
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if(!$user instanceof User) {
            throw new \InvalidArgumentException('The user must be an instance of ' . User::class);
        }
        return $user;
    }

    public function supportsClass(string $class): bool
    {
        return User::class === $class;
    }
}
