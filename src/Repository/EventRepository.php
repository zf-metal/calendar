<?php

namespace ZfMetal\Calendar\Repository;

use Doctrine\ORM\EntityRepository;

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


}

