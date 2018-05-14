<?php

namespace ZfMetal\Calendar\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * TicketRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class TicketRepository extends EntityRepository
{

    public function save(\ZfMetal\Calendar\Entity\Ticket $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Calendar\Entity\Ticket $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

