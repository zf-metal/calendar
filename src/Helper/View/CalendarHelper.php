<?php

namespace ZfMetal\Calendar\Helper\View;

use ZfMetal\Calendar\Entity\Schedule;

/**
 * CalendarHelper
 *
 *
 *
 * @author
 * @license
 * @link
 */
class CalendarHelper extends \Zend\View\Helper\AbstractHelper
{

    private $calendars;
    private $scheduleCache = array();

    public function __invoke($calendars)
    {
        $this->calendars = $calendars;
        return $this;
    }

    public function mustShow($time, $day)
    {
        $flag= false;
        foreach ($this->calendars as $calendar) {
            $schedule = $this->getScheduleByDay($calendar, $day);
            if($this->isHourActiveInSchedule($schedule,$time)){
                $flag = true;
            }
        }

        return $flag;
    }

    protected function getScheduleByDay($calendar, $day)
    {
        if (!$this->scheduleCache[$calendar->getId()][$day]) {
            $this->scheduleCache[$calendar->getId()][$day] = $calendar->getScheduleByDay($day);
        }
        return $this->scheduleCache[$calendar->getId()][$day];
    }

    /**
     * @param $schedule Schedule
     * @param $time \DateTime
     * @return boolean
     */
    protected function isHourActiveInSchedule($schedule, $time)
    {
//                    echo "<pre>";
//                    var_dump($time);
//                    var_dump($schedule->getStart(true));
//                    echo "</pre>";
        if ($time >= $schedule->getStart(true) && $time < $schedule->getEnd(true) ){
            return true;
        }
        return false;

    }




}

