<?php

namespace ZfMetal\Calendar\Entity;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Zend\Form\Annotation as Annotation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;
use ZfMetal\Restful\Transformation;

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
     * @Transformation\Policy\Custom(transform="ZfMetal\Restful\Transformation\Policy\Common\IdName::transform")
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
     * @Transformation\Policy\KeepDateTime
     */
    public $start = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Time")
     * @Annotation\Attributes({"type":"time"})
     * @Annotation\Options({"label":"end", "description":"", "addon":""})
     * @ORM\Column(type="time", unique=false, nullable=true, name="end")
     * @Transformation\Policy\KeepDateTime
     */
    public $end = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Time")
     * @Annotation\Attributes({"type":"time"})
     * @Annotation\Options({"label":"Start 2", "description":"", "addon":""})
     * @ORM\Column(type="time", unique=false, nullable=true, name="start_2")
     * @Transformation\Policy\KeepDateTime
     */
    public $start2 = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Time")
     * @Annotation\Attributes({"type":"time"})
     * @Annotation\Options({"label":"End 2", "description":"", "addon":""})
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

    /**
     * @return mixed
     */
    public function getStart2()
    {
        return $this->start2;
    }

    /**
     * @param mixed $start2
     */
    public function setStart2($start2)
    {
        $this->start2 = $start2;
    }

    /**
     * @return mixed
     */
    public function getEnd2()
    {
        return $this->end2;
    }

    /**
     * @param mixed $end2
     */
    public function setEnd2($end2)
    {
        $this->end2 = $end2;
    }

    public function __toString()
    {
        return (string) $this->date;
    }


}

