<?php

namespace ZfMetal\Calendar\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * OutOfServiceRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class OutOfServiceRepository extends EntityRepository
{

    public function save(\ZfMetal\Calendar\Entity\OutOfService $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Calendar\Entity\OutOfService $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

