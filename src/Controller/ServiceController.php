<?php

namespace ZfMetal\Calendar\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * ServiceController
 *
 *
 *
 * @author
 * @license
 * @link
 */
class ServiceController extends AbstractActionController
{

    const ENTITY = \ZfMetal\Calendar\Entity\Service::class;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    public $em = null;

    /**
     * @var \ZfMetal\Datagrid\Grid
     */
    public $grid = null;

    public function getEm()
    {
        return $this->em;
    }

    public function setEm(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    public function getEntityRepository()
    {
        return $this->getEm()->getRepository(self::ENTITY);
    }

    public function getServiceRepository()
    {
        return $this->getEm()->getRepository(self::ENTITY);
    }

    public function __construct(\Doctrine\ORM\EntityManager $em, \ZfMetal\Datagrid\Grid $grid)
    {
        $this->em = $em;
         $this->grid = $grid;
    }

    public function getGrid()
    {
        return $this->grid;
    }

    public function setGrid(\ZfMetal\Datagrid\Grid $grid)
    {
        $this->grid = $grid;
    }

    public function gridAction()
    {
        $this->grid->prepare();
        return array("grid" => $this->grid);
    }


}

