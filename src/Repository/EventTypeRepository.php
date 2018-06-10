<?php

namespace ZfMetal\Calendar\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * EventTypeRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class EventTypeRepository extends EntityRepository
{

    public function save(\ZfMetal\Calendar\Entity\EventType $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Calendar\Entity\EventType $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

