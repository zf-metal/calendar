<?php

namespace ZfMetal\Calendar\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * BranchOfficeRepository
 * 
 * 
 * 
 * @author
 * @license
 * @link
 */
class BranchOfficeRepository extends EntityRepository
{

    public function save(\ZfMetal\Calendar\Entity\BranchOffice $entity)
    {
        $this->getEntityManager()->persist($entity); $this->getEntityManager()->flush();
    }

    public function remove(\ZfMetal\Calendar\Entity\BranchOffice $entity)
    {
        $this->getEntityManager()->remove($entity); $this->getEntityManager()->flush();
    }


}

