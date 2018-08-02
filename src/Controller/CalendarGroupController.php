<?php

namespace ZfMetal\Calendar\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * CalendarGroupController
 *
 *
 *
 * @author
 * @license
 * @link
 */
class CalendarGroupController extends AbstractActionController
{

    const ENTITY = \ZfMetal\Calendar\Entity\CalendarGroup::class;

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

    public function getCalendarGroupRepository()
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
        //Bug de ZF o Doctrine. ManyToMany no permite guardar sin elementos dado que llega nulo
        if ($this->getRequest()->getPost('calendars') === null) {

            $this->grid->getSource()->getEventManager()->attach('updateRecord_before', function ($e) {
                $e->getParams()['record']->setCalendars(null);
            });
        }

        $this->grid->prepare();
        return array("grid" => $this->grid);
    }


}

