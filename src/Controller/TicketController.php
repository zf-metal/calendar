<?php

namespace ZfMetal\Calendar\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * TicketController
 *
 *
 *
 * @author
 * @license
 * @link
 */
class TicketController extends AbstractActionController
{

    const ENTITY = '\\ZfMetal\\Calendar\\Entity\\Calendar';

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

    public function __construct(\Doctrine\ORM\EntityManager $em, \ZfMetal\Datagrid\Grid $grid)
    {
        $this->em = $em; $this->grid = $grid;
    }

    public function scheduleAction()
    {
        return [];
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

        $this->layoutHelper()->setPageTitle("Tickets");
        $this->grid->prepare();
        return array("grid" => $this->grid);
    }


}

