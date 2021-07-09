<?php

namespace App\Repository;

use App\Entity\Alternativas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Alternativas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Alternativas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Alternativas[]    findAll()
 * @method Alternativas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlternativasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Alternativas::class);
    }

    // /**
    //  * @return Alternativas[] Returns an array of Alternativas objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Alternativas
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
