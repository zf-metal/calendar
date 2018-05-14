<?php

namespace ZfMetal\Calendar\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * TicketStateController
 *
 *
 *
 * @author
 * @license
 * @link
 */
class TicketStateController extends AbstractActionController
{

    const ENTITY = '\\ZfMetal\\Calendar\\Entity\\TicketState';

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
        $this->layoutHelper()->setPageTitle("Estados de Ticket");
        $this->grid->prepare();
        return array("grid" => $this->grid);
    }


}

