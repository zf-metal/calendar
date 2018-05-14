<?php

namespace ZfMetal\Calendar\Controller;

use Zend\Mvc\Controller\AbstractActionController;


/**
 * TicketScheduleController
 *
 *
 *
 * @author
 * @license
 * @link
 */
class TicketScheduleController extends AbstractActionController
{

    const ENTITY = '\\ZfMetal\\Calendar\\Entity\\Calendar';

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    public $em = null;

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

    public function getTicketRepository()
    {
        $entity = $this->ZfMetalCalendarOptions()->getTicketEntity();
        return $this->getEm()->getRepository($entity);
    }

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    public function scheduleAction()
    {

        //@TODO change method findall
        $tickets = $this->getTicketRepository()->findAll();

        $calendars = $this->getEntityRepository()->findAll();

        $this->layoutHelper()->setPageTitle("Programación de tickets");
        return ["tickets" => $tickets,"calendars" => $calendars];
    }


}

