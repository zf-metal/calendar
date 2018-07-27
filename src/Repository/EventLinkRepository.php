<?php

namespace ZfMetal\Calendar\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * EventLinkRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class EventLinkRepository extends EntityRepository
{

    public function save(\ZfMetal\Calendar\Entity\EventLink $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Calendar\Entity\EventLink $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

