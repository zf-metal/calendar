<?php

namespace ZfMetal\Calendar\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * TicketStateRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class TicketStateRepository extends EntityRepository
{

    public function save(\ZfMetal\Calendar\Entity\TicketState $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Calendar\Entity\TicketState $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

