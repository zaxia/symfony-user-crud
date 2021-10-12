<?php
namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return User[]
     */
    public function findAll(): array
    {
        // automatically knows to select Products
        // the "u" is an alias you'll use in the rest of the query
        $qb = $this->createQueryBuilder('u')->orderBy('u.login', 'ASC');

        $query = $qb->getQuery();

        return $query->execute();
    }

    // /**
    //  * @return User
    //  */
    // public function findByLogin($login): User
    // {
    //     $qb = $this->createQueryBuilder('u')
    //     ->where('u.login > :login')
    //     ->setParameter('login', $login);

    //     $query = $qb->getQuery();

    //     return $query->setMaxResults(1)->getOneOrNullResult();
    // }
}