<?php

namespace App\Repository;

use App\Entity\Questao;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Questao|null find($id, $lockMode = null, $lockVersion = null)
 * @method Questao|null findOneBy(array $criteria, array $orderBy = null)
 * @method Questao[]    findAll()
 * @method Questao[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestaoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Questao::class);
    }

    // /**
    //  * @return Questao[] Returns an array of Questao objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Questao
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
