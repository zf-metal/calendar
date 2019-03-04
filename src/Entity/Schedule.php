<?php

namespace ZfMetal\Calendar\Entity;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Zend\Form\Annotation as Annotation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;
use ZfMetal\Restful\Transformation;

/**
 * Schedule
 *
 *
 *
 * @author
 * @license
 * @link
 * @ORM\Table(name="cal_schedule")
 * @ORM\Entity(repositoryClass="ZfMetal\Calendar\Repository\ScheduleRepository")
 * @Annotation\Instance("\ZfMetal\Calendar\Entity\Schedule")
 */
class Schedule
{


    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"ID", "description":"", "addon":""})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", length=11, unique=false, nullable=false, name="id")
     */
    public $id = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Hidden")
     * @Annotation\Attributes({"type":"hidden"})
     * @Annotation\Type("Zend\Form\Element\Hidden")
     * @ORM\ManyToOne(targetEntity="\ZfMetal\Calendar\Entity\Calendar")
     * @ORM\JoinColumn(name="calendar_id", referencedColumnName="id", nullable=true)
     * @Transformation\Policy\Skip
     */
    public $calendar = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Hidden")
     * @Annotation\Attributes({"type":"hidden"})
     * @Annotation\Type("Zend\Form\Element\Hidden")
     * @ORM\Column(type="integer", length=1, unique=false, nullable=false, name="day")
     */
    public $day = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Time")
     * @Annotation\Attributes({"type":"time"})
     * @Annotation\Options({"label":"start", "description":"", "addon":"", "format": "H:i"})
     * @ORM\Column(type="time", unique=false, nullable=true, name="start")
     * @Transformation\Policy\KeepDateTime
     */
    public $start = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Time")
     * @Annotation\Attributes({"type":"time"})
     * @Annotation\Options({"label":"end", "description":"", "addon":"", "format": "H:i"})
     * @ORM\Column(type="time", unique=false, nullable=true, name="end")
     * @Transformation\Policy\KeepDateTime
     */
    public $end = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Time")
     * @Annotation\Attributes({"type":"time"})
     * @Annotation\Options({"label":"Start 2", "description":"", "addon":"", "format": "H:i"})
     * @ORM\Column(type="time", unique=false, nullable=true, name="start_2")
     * @Transformation\Policy\KeepDateTime
     */
    public $start2 = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Time")
     * @Annotation\Attributes({"type":"time"})
     * @Annotation\Options({"label":"End 2", "description":"", "addon":"", "format": "H:i"})
     * @ORM\Column(type="time", unique=false, nullable=true, name="end_2")
     * @Transformation\Policy\KeepDateTime
     */
    public $end2 = null;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCalendar()
    {
        return $this->calendar;
    }

    public function setCalendar($calendar)
    {
        $this->calendar = $calendar;
    }

    public function getDay()
    {
        return $this->day;
    }

    public function setDay($day)
    {
        $this->day = $day;
    }

    public function getStart($formatDate = false)
    {
        if (is_a($this->start, "DateTime")) {
            if ($formatDate) {
                return $this->start;
            }
            return $this->start->format("H:i");
        }
        return null;
    }

    public function setStart($start)
    {
        $this->start = $start;
    }

    public function getEnd($formatDate = false)
    {
        if (is_a($this->end, "DateTime")) {
            if ($formatDate) {
                return $this->end;
            }
            return $this->end->format("H:i");
        }
        return null;
    }

    public function setEnd($end)
    {
        $this->end = $end;
    }

    public function getStart2($formatDate = false)
    {
        if (is_a($this->start2, "DateTime")) {
            if ($formatDate) {
                return $this->start2;
            }
            return $this->start2->format("H:i");
        }
        return null;
    }

    public function setStart2($start2)
    {
        $this->start2 = $start2;
    }

    public function getEnd2($formatDate = false)
    {

        if (is_a($this->end2, "DateTime")) {
            if ($formatDate) {
                return $this->end2;
            }
            return $this->end2->format("H:i");
        }
        return null;
    }

    public function setEnd2($end2)
    {
        $this->end2 = $end2;
    }

    public function __toString()
    {
        return (string)$this->day;
    }


/*    public function getArrayCopy()
    {
        $a = [
            "id" => $this->getId(),
            "calendar" => $this->getCalendar(),
            "day" => $this->getDay(),
            "start" => $this->getStart()

        ];

        return $a;

    }*/


}

