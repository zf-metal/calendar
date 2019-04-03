<?php
/**
 * Created by IntelliJ IDEA.
 * User: crist
 * Date: 5/2/2019
 * Time: 12:12
 */

namespace ZfMetal\Calendar\Service;

use ZfMetal\Calendar\Entity\Appointment;
use ZfMetal\Calendar\Entity\Calendar;
use ZfMetal\Calendar\Entity\Event;
use ZfMetal\Calendar\Entity\Holiday;
use ZfMetal\Calendar\Entity\OutOfService;
use ZfMetal\Calendar\Entity\Schedule;
use ZfMetal\Calendar\Entity\SpecificSchedule;
use ZfMetal\Calendar\Form\AppointmentForm;
use ZfMetal\Calendar\Model\Shift;
use ZfMetal\Calendar\Model\Shifts;
use ZfMetal\Calendar\Repository\AppointmentRepository;


class AppointmentService
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    public $em = null;

    /**
     * @var Shifts
     */
    protected $shifts;

    public function getEm()
    {
        return $this->em;
    }

    public function setEm(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    public function getCalendarRepository()
    {
        return $this->getEm()->getRepository(Calendar::class);
    }

    public function getSpecificScheduleRepository()
    {
        return $this->getEm()->getRepository(SpecificSchedule::class);
    }

    public function getScheduleRepository()
    {
        return $this->getEm()->getRepository(Schedule::class);
    }

    public function getOutOfServiceRepository()
    {
        return $this->getEm()->getRepository(OutOfService::class);
    }


    public function getHolidayRepository()
    {
        return $this->getEm()->getRepository(Holiday::class);
    }


    public function getEventRepository()
    {
        return $this->getEm()->getRepository(Event::class);
    }

    /**
     * @return AppointmentRepository
     */
    public function getAppointmentRepository()
    {
        return $this->getEm()->getRepository(Appointment::class);
    }


    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
        $this->shifts = new Shifts();
    }


    /**
     * @param $calendarId
     * @param $date
     * @throws \Exception
     */
    public function getAvailableShift($calendarId, $date)
    {


        if (!$calendarId || !$date) {
            throw new \Exception("Faltan Parametros CalendarId & date o estan nulos");
        }


        if (!$this->validateDate($date, "Y-m-d")) {
            throw new \Exception("El parametro Date no es una fecha Valida");

        }

        $date = \DateTime::createFromFormat("!Y-m-d", $date);


        /** @var Calendar $calendar */
        $calendar = $this->getCalendarRepository()->find($calendarId);

        if (!$calendar) {
            throw new \Exception("No se Obtuvo un calendario valido");
        }


        $schedule = $this->findSchedule($date, $calendar);

        if($schedule) {
            $this->generateShifts($date, $schedule, $calendar);
            $this->checkAppointments($calendar, $date);
        }

        return $this->shifts;

    }

    /**
     * Obtengo el schedule que corresponde segun calendario y fecha
     * @param $date
     * @param Calendar $calendar
     * @return object|null
     */
    public function findSchedule($date, Calendar $calendar)
    {

        //OurOfService
        $outOfService = $this->getOutOfServiceRepository()->findByDate($date);
        if($outOfService){
            return null;
        }

        //specific schedule
        $schedule = $this->getSpecificScheduleRepository()->findOneBy(['calendar' => $calendar->getId(), 'date' => $date]);

        if (!$schedule) {


            //Holiday Schedule
            $holiday = $this->getHolidayRepository()->findOneBy(['date' => $date]);

            if($holiday){
                $schedule = $this->getScheduleRepository()->findOneBy(['calendar' => $calendar->getId(), 'day' => 8]);
            }else{
                $day = $date->format("N");
                $schedule = $this->getScheduleRepository()->findOneBy(['calendar' => $calendar->getId(), 'day' => $day]);

            }
        }


        return $schedule;
    }

    /**
     * @param $date
     * @param $schedule
     * @param Calendar $calendar
     */
    public function generateShifts($date, $schedule, Calendar $calendar)
    {


        if ($schedule->getStart() && $schedule->getEnd()) {
            $this->generateShiftsByRange($date, $calendar, $schedule->getStart(), $schedule->getEnd());
        }

        if ($schedule->getStart2() && $schedule->getEnd2()) {
            $this->generateShiftsByRange($date, $calendar, $schedule->getStart2(), $schedule->getEnd2());
        }

    }


    /**
     * @param $date
     * @param Calendar $calendar
     * @param $scheduleStart
     * @param $scheduleEnd
     * @param Shifts $shifts
     */
    public function generateShiftsByRange($date, Calendar $calendar, $scheduleStart, $scheduleEnd)
    {
        $start = \DateTime::createFromFormat("H:i", $scheduleStart);
        $end = \DateTime::createFromFormat("H:i", $scheduleEnd);

        $rangeDurationInMinutes = $this->calculateDiffTimeInMinutes($end, $start);


        if ($calendar->getAppointmentConfig()) {
            $duration = $calendar->getAppointmentConfig()->getDuration();
            $breakDuration = $calendar->getAppointmentConfig()->getBreak();
            if ($duration) {
                $quantityShifts = floor($rangeDurationInMinutes / $duration);


                for ($i = 0; $i < $quantityShifts; $i++) {
                    $shift = new Shift($calendar->getId(), $date, $start->format("H:i"), $duration);
                    $this->shifts->add($shift);
                    $start->modify('+' . $duration . ' minutes');
                    if ($breakDuration > 0) {
                        $start->modify('+' . $breakDuration . ' minutes');
                    }
                }
            } else {
                throw new \Exception("The calendar has not duration");
            }
        } else {
            throw new \Exception("The calendar has not config");
        }
    }

    /**
     * Calcula la diferencia en minutos entre la hora de inicio y fin
     * @param $end
     * @param $start
     * @return float|int
     */
    public function calculateDiffTimeInMinutes($end, $start)
    {
        $diff = $end->diff($start);
        $minutes = $diff->days * 24 * 60;
        $minutes += $diff->h * 60;
        $minutes += $diff->i;
        return $minutes;
    }


    protected function validateDate($date, $format = 'Y-m-d')
    {
        $d = \DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }

    private function checkAppointments(Calendar $calendar, \DateTime $date)
    {
        $appointments = $this->getAppointmentRepository()->findByCalendarAndDate($calendar, $date);

        /**
         * @var  $key
         * @var Shift $shift
         */
        foreach ($this->shifts->getCollection() as $key => $shift) {
            /** @var Appointment $appointment */
            foreach ($appointments as $appointment) {

                //TODO: Ampliar la verificacion a rango de tiempo en vez de solo el start
                if ($shift->getStart() == $appointment->getStart()) {
                 $this->shifts->remove($key);
                }
            }
        }


    }


}