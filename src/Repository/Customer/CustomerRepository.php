<?php

namespace App\Repository\Customer;

use App\Entity\Customer\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends EntityRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, new ClassMetadata(Customer::class));
    }

    public function createListQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('o')
            ->addSelect('newsletter')
            ->leftJoin('o.newsletter', 'newsletters')
            ->andWhere('newsletter.isActive > 0');
    }

    // /**
    //  * @return Newsletter[] Returns an array of Newsletter objects
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
    public function findOneBySomeField($value): ?Newsletter
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
