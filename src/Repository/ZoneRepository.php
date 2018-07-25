<?php

namespace ZfMetal\Calendar\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ZoneRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class ZoneRepository extends EntityRepository
{

    public function save(\ZfMetal\Calendar\Entity\Zone $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Calendar\Entity\Zone $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

