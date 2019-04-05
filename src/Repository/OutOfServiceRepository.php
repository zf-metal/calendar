<?php

namespace ZfMetal\Calendar\Repository;

use Doctrine\ORM\EntityRepository;
use ZfMetal\Calendar\Entity\OutOfService;

/**
 * OutOfServiceRepository
 * 
 * 
 * 
 * @author
 * @license
 * @link
 */
class OutOfServiceRepository extends EntityRepository
{

    public function save(\ZfMetal\Calendar\Entity\OutOfService $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Calendar\Entity\OutOfService $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }

    public function findByDate($date)
    {
        return  $this->getEntityManager()->createQueryBuilder('u')
            ->select('u')
            ->from(OutOfService::class, 'u')
            ->where('u.start <= :date')
            ->andWhere('u.end >= :date')
            ->setParameter("date", $date)
            ->getQuery()
            ->getOneOrNullResult();

    }

}

