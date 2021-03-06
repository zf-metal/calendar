<?php
/**
 * Created by IntelliJ IDEA.
 * User: crist
 * Date: 4/2/2019
 * Time: 16:08
 */

namespace ZfMetal\Calendar\Model;


class Shift
{

    /**
     * @var \DateTime
     */
    protected $date;
    protected $calendar;
    protected $hour;
    protected $duration;
    protected $start;

    /**
     * Shift constructor.
     * @param $date
     * @param $calendar
     * @param $hour
     * @param $duration
     */
    public function __construct($calendar, \DateTime $date, $hour, $duration)
    {
        $this->setDate($date);
        $this->setCalendar($calendar);
        $this->setHour($hour);
        $this->setDuration($duration);
        $this->setStart($date,$hour);
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getCalendar()
    {
        return $this->calendar;
    }

    /**
     * @param mixed $calendar
     */
    public function setCalendar($calendar)
    {
        $this->calendar = $calendar;
    }


    /**
     * @return \DateTime
     */
    public function getDay()
    {
        return $this->getDate()->format('N');

    }

    /**
     * @return \DateTime
     */
    public function getStart()
    {
      return $this->start;
    }

    /**
     * @return mixed
     */
    public function getEnd()
    {
        $end = clone $this->getStart();
        $end->modify('+' . $this->getDuration() . ' minutes');
        return $end;
    }


    /**
     * @return mixed
     */
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * @param mixed $hour
     */
    public function setHour($hour)
    {
        if (preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $hour)) {
            $this->hour = $hour;
        } else {
            throw new \Exception("Invalid Hour Format");
        }
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param mixed $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }


    public function toArray()
    {
        return [
            'calendar' => $this->getCalendar(),
            'date' => $this->getDate()->format("Y-m-d"),
            'hour' => $this->getHour(),
            'duration' => $this->getDuration(),
            'start' => $this->getStart()->format("Y-m-d H:i"),
            'end' => $this->getEnd()->format("Y-m-d H:i"),
            'day' => $this->getDay()
        ];
    }

    private function setStart(\DateTime $date, $hour)
    {
        $this->start =  \DateTime::createFromFormat("!Y-m-d H:i", $date->format('Y-m-d') . ' ' . $hour);
    }

}