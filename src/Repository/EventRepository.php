<?php

namespace ZfMetal\Calendar\Repository;

use Doctrine\ORM\EntityRepository;
use ZfMetal\Calendar\Entity\Event;

/**
 * EventRepository
 * 
 * 
 * 
 * @author
 * @license
 * @link
 */
class EventRepository extends EntityRepository
{

    public function save(\ZfMetal\Calendar\Entity\Event $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Calendar\Entity\Event $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


    /**
     * @return array
     */
    public function exportDaily($from,$to)
    {
        return $this->getEntityManager()->createQueryBuilder('u')
            ->select('u')
            ->from(Event::class, 'u')
            ->where('u.start >= :from')
            ->andWhere('u.start <= :to')
            ->andWhere('u.calendar is not null')
            ->setParameter("from",$from)
            ->setParameter("to",$to)
            ->getQuery()
            ->getResult();
    }


}

