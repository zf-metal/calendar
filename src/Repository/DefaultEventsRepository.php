<?php

namespace ZfMetal\Calendar\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * DefaultEventsRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class DefaultEventsRepository extends EntityRepository
{

    public function save(\ZfMetal\Calendar\Entity\DefaultEvents $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Calendar\Entity\DefaultEvents $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

