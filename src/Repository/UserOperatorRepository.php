<?php

namespace App\Repository;

use App\Entity\UserOperator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserOperator>
 *
 * @method UserOperator|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserOperator|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserOperator[]    findAll()
 * @method UserOperator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserOperatorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserOperator::class);
    }

    public function save(UserOperator $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserOperator $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return UserOperator[] Returns an array of a user allowed operators IDs
     */
   public function findUserAllowedOperators($user_id): array
   {
        return $this->createQueryBuilder('u')
            ->select('u.operator_id')
            ->andWhere('u.user_id = :user_id')
            ->setParameter('user_id', $user_id)
            ->getQuery()
            ->getResult()
        ;
  }

//    public function findOneBySomeField($value): ?UserOperator
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
