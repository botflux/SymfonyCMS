<?php

namespace App\Repository;

use App\Entity\ApplicationSettings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ApplicationSettings|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApplicationSettings|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApplicationSettings[]    findAll()
 * @method ApplicationSettings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApplicationSettingsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ApplicationSettings::class);
    }

    /**
     * Returns the application settings, I create this method because there is only one settings row in database
     * @return ApplicationSettings|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findSettings() : ?ApplicationSettings
    {
        return $this->createQueryBuilder('a')
            ->getQuery()
            ->getOneOrNullResult();
    }

    // /**
    //  * @return ApplicationSettings[] Returns an array of ApplicationSettings objects
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
    public function findOneBySomeField($value): ?ApplicationSettings
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
