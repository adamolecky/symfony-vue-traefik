<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use function gettype;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    #[ArrayShape(['id' => 'int|null', 'fullName' => 'null|string', 'password' => 'null|string', 'email' => 'null|string', 'role' => 'null|string'])]
    // TODO: $user could be User entity, but because of Request helper (which is dynamic for every entity), we need to pass Object or use dynamic hinting of return types in request helper.
    public function getUserAsArray(object $user): array
    {
        return [
            'id' => $user->getId(),
            'fullName' => $user->getFullName(),
            'password' => $user->getPassword(),
            'email' => $user->getEmail(),
            'role' => $user?->getRole()?->getType() ?? '',
        ];
    }
}
