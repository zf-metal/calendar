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


    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    public function availableShiftsAction()
    {

        //Obtengo parametros
        $calendarId = $this->params('calendarId');
        $date = $this->params('date');


        //Verifico Parametros
        if (!$calendarId || !$date) {
            //Missing parameters
        }

        //Valido Fecha
        if (!$this->validateDate($date, "Y-m-d")) {
            //Invalid Parameters

        }

        $date = \DateTime::createFromFormat("Y-m-d", $date);

        //Obtengo Calendar
        /** @var Calendar $calendar */
        $calendar = $this->getCalendarRepository()->find($calendarId);

        //Valido Calendar ok
        if (!$calendar) {
            //Invalid Parameters
        }


        //busco Specific Schedule

        $schedule = $this->getSpecificScheduleRepository()->findOneBy(['calendar' => $calendar->getId(), 'date' => $date]);

        //Si no hay SpecificSchedule busco en el General
        if (!$schedule) {
            $day = $date->format("N");
            $schedule = $this->getScheduleRepository()->findOneBy(['calendar' => $calendar->getId(), 'day' => $day]);
        }


        if ($schedule->getStart()) {

            $start = \DateTime::createFromFormat("H:i", $schedule->getStart());
            $end = \DateTime::createFromFormat("H:i", $schedule->getEnd());
            $diff = $end->diff($start);
            $minutes = $diff->days * 24 * 60;
            $minutes += $diff->h * 60;
            $minutes += $diff->i;


            $duration = $calendar->getPredefinedEvents()->getDuration();
            $quantityShifts = floor($minutes / $duration);
            $shifts = new Shifts();


            for ($i = 0; $i < $quantityShifts; $i++) {
                $shift = new Shift($calendar->getId(), $date, $start->format("H:i"), $duration);
                $shifts->add($shift);
                $start->modify('+' . $duration . ' minutes');
            }


        }


        return new JsonModel($shifts->toArray());
    }


    function checkAvailability(Shift $shift)
    {

    }

    function validateDate($date, $format = 'Y-m-d')
    {
        $d = \DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }

}

