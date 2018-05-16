<?php

namespace ZfMetal\Calendar\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * EventStateRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class EventStateRepository extends EntityRepository
{

    public function save(\ZfMetal\Calendar\Entity\EventState $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Calendar\Entity\EventState $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

