<?php

namespace ZfMetal\Calendar\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use ZfMetal\Calendar\Entity\Calendar;
use ZfMetal\Calendar\Entity\Event;
use ZfMetal\Calendar\Entity\Schedule;
use ZfMetal\Calendar\Entity\SpecificSchedule;
use ZfMetal\Calendar\Model\Shift;
use ZfMetal\Calendar\Model\Shifts;
use ZfMetal\Calendar\Service\ShiftService;

/**
 * ShiftController
 *
 *
 *
 * @author
 * @license
 * @link
 */
class ShiftController extends AbstractActionController
{

    const ENTITY = 'ZfMetal\\Calendar\\Entity\\Calendar';

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    public $em = null;

    /**
     * @var ShiftService
     */
    public $shiftService;

    /**
     * ShiftController constructor.
     * @param \Doctrine\ORM\EntityManager $em
     * @param ShiftService $shiftService
     */
    public function __construct(\Doctrine\ORM\EntityManager $em, ShiftService $shiftService)
    {
        $this->em = $em;
        $this->shiftService = $shiftService;
    }

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

    public function getCalendarRepository()
    {
        return $this->getEm()->getRepository(self::ENTITY);
    }

    public function getSpecificScheduleRepository()
    {
        return $this->getEm()->getRepository(SpecificSchedule::class);
    }

    public function getScheduleRepository()
    {
        return $this->getEm()->getRepository(Schedule::class);
    }


    public function getEventRepository()
    {
        return $this->getEm()->getRepository(Event::class);
    }


    public function availableShiftsAction()
    {

        //Obtengo parametros
        $calendarId = $this->params('calendarId');
        $date = $this->params('date');

        $shifts = $this->shiftService->getAvailableShift($calendarId, $date);


        return new JsonModel($shifts->toArray());
    }


    function checkAvailability(Shift $shift)
    {

    }



}

