<?php

namespace App\Repository;

use App\Entity\FoodRecord;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FoodRecord|null find($id, $lockMode = null, $lockVersion = null)
 * @method FoodRecord|null findOneBy(array $criteria, array $orderBy = null)
 * @method FoodRecord[]    findAll()
 * @method FoodRecord[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FoodRecordRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FoodRecord::class);
    }

//    /**
//     * @return FoodRecord[] Returns an array of FoodRecord objects
//     */

    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneBySomeField($value): ?FoodRecord
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
