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
     * @Annotation\Options({"label":"startBreak", "description":"", "addon":""})
     * @ORM\Column(type="time", unique=false, nullable=true, name="start_break")
     * @Transformation\Policy\KeepDateTime
     */
    public $startBreak = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Time")
     * @Annotation\Attributes({"type":"time"})
     * @Annotation\Options({"label":"endBreak", "description":"", "addon":""})
     * @ORM\Column(type="time", unique=false, nullable=true, name="end_break")
     * @Transformation\Policy\KeepDateTime
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
        if(is_a($this->start,"DateTime")){
            if($formatDate){
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
        if(is_a($this->end,"DateTime")){
            if($formatDate){
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

    public function getStartBreak($formatDate = false)
    {
        if(is_a($this->startBreak,"DateTime")){
            if($formatDate){
                return $this->startBreak;
            }
            return $this->startBreak->format("H:i");
        }
        return null;
    }

    public function setStartBreak($startBreak)
    {
        $this->startBreak = $startBreak;
    }

    public function getEndBreak($formatDate = false){

        if(is_a($this->endBreak,"DateTime")){
            if($formatDate){
                return $this->endBreak;
            }
         return $this->endBreak->format("H:i");
        }
        return null;
    }

    public function setEndBreak($endBreak)
    {
        $this->endBreak = $endBreak;
    }

    public function __toString()
    {
        return (string) $this->day;
    }




}

