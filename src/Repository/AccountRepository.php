<?php

namespace ZfMetal\Calendar\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * AccountRepository
 *
 *
 *
 * @author
 * @license
 * @link
 */
class AccountRepository extends EntityRepository
{

    public function save(\ZfMetal\Calendar\Entity\Account $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Calendar\Entity\Account $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

