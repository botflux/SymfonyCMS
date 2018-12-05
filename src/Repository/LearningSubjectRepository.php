<?php

namespace App\Repository;

use App\Entity\LearningSubject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LearningSubject|null find($id, $lockMode = null, $lockVersion = null)
 * @method LearningSubject|null findOneBy(array $criteria, array $orderBy = null)
 * @method LearningSubject[]    findAll()
 * @method LearningSubject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LearningSubjectRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LearningSubject::class);
    }

    /**
     * @return LearningSubject[]|null
     */
    public function findMostImportant () : ?array
    {
        return $this->createQueryBuilder('l')
            ->orderBy('l.priority', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return LearningSubject[] Returns an array of LearningSubject objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LearningSubject
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
