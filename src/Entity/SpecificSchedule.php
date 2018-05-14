<?php

namespace ZfMetal\Calendar\Entity;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Zend\Form\Annotation as Annotation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * SpecificSchedule
 *
 *
 *
 * @author
 * @license
 * @link
 * @ORM\Table(name="cal_specific_schedule")
 * @ORM\Entity(repositoryClass="ZfMetal\Calendar\Repository\SpecificScheduleRepository")
 */
class SpecificSchedule
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
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({"label":"calendar","empty_option": "",
     * "target_class":"\ZfMetal\Calendar\Entity\Calendar", "description":""})
     * @ORM\ManyToOne(targetEntity="\ZfMetal\Calendar\Entity\Calendar")
     * @ORM\JoinColumn(name="calendar_id", referencedColumnName="id", nullable=true)
     */
    public $calendar = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Date")
     * @Annotation\Attributes({"type":"date"})
     * @Annotation\Options({"label":"date", "description":"", "addon":""})
     * @ORM\Column(type="date", unique=false, nullable=true, name="date")
     */
    public $date = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Time")
     * @Annotation\Attributes({"type":"time"})
     * @Annotation\Options({"label":"start", "description":"", "addon":""})
     * @ORM\Column(type="time", unique=false, nullable=true, name="start")
     */
    public $start = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Time")
     * @Annotation\Attributes({"type":"time"})
     * @Annotation\Options({"label":"end", "description":"", "addon":""})
     * @ORM\Column(type="time", unique=false, nullable=true, name="end")
     */
    public $end = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Time")
     * @Annotation\Attributes({"type":"time"})
     * @Annotation\Options({"label":"startBreak", "description":"", "addon":""})
     * @ORM\Column(type="time", unique=false, nullable=true, name="start_break")
     */
    public $startBreak = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Time")
     * @Annotation\Attributes({"type":"time"})
     * @Annotation\Options({"label":"endBreak", "description":"", "addon":""})
     * @ORM\Column(type="time", unique=false, nullable=true, name="end_break")
     */
    public $endBreak = null;

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

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setStart($start)
    {
        $this->start = $start;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function setEnd($end)
    {
        $this->end = $end;
    }

    public function getStartBreak()
    {
        return $this->startBreak;
    }

    public function setStartBreak($startBreak)
    {
        $this->startBreak = $startBreak;
    }

    public function getEndBreak()
    {
        return $this->endBreak;
    }

    public function setEndBreak($endBreak)
    {
        $this->endBreak = $endBreak;
    }

    public function __toString()
    {
        return (string) $this->date;
    }


}

