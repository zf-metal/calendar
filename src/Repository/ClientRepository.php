<?php

namespace ZfMetal\Calendar\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ClientRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class ClientRepository extends EntityRepository
{

    public function save(\ZfMetal\Calendar\Entity\Client $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Calendar\Entity\Client $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

