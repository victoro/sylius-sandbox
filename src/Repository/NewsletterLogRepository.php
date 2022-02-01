<?php

namespace App\Repository;

use App\Entity\NewsletterLog;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * @method NewsletterLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsletterLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsletterLog[]    findAll()
 * @method NewsletterLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsletterLogRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, new ClassMetadata(NewsletterLog::class));
    }

    // /**
    //  * @return NewletterLog[] Returns an array of NewletterLog objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NewletterLog
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
