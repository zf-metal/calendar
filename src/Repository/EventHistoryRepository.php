<?php

namespace ZfMetal\Calendar\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * EventHistoryRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class EventHistoryRepository extends EntityRepository
{

    public function save(\ZfMetal\Calendar\Entity\EventHistory $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Calendar\Entity\EventHistory $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

