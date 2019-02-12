<?php

namespace ZfMetal\Calendar\Entity;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Zend\Form\Annotation as Annotation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;
use ZfMetal\Restful\Transformation;
/**
 * Appointment
 *
 *
 *
 * @author
 * @license
 * @link
 * @ORM\Table(name="cal_appointment")
 * @ORM\Entity(repositoryClass="ZfMetal\Calendar\Repository\AppointmentRepository")
 */
class Appointment
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
     * @Annotation\Options({"label":"Usuario","empty_option": "",
     * "target_class":"\ZfMetal\Security\Entity\User", "description":""})
     * @ORM\ManyToOne(targetEntity="\ZfMetal\Security\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    public $user = null;

    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({"label":"Agenda","empty_option": "",
     * "target_class":"\ZfMetal\Calendar\Entity\Calendar", "description":""})
     * @ORM\ManyToOne(targetEntity="\ZfMetal\Calendar\Entity\Calendar")
     * @ORM\JoinColumn(name="calendar_id", referencedColumnName="id", nullable=true)
     */
    public $calendar = null;

    /**
     * @Annotation\Type("Zend\Form\Element\DateTime")
     * @Annotation\Attributes({"type":"datetime"})
     * @Annotation\Options({"label":"Desde", "description":"", "addon":""})
     * @ORM\Column(type="datetime", unique=false, nullable=true, name="start")
     * @Transformation\Policy\FormatDateTime(format="Y-m-d H:i")
     */
    public $start = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Duración", "description":"", "addon":""})
     * @ORM\Column(type="integer", length=11, unique=false, nullable=true,
     * name="duration")
     */
    public $duration = null;

    /**
     * @Annotation\Type("Zend\Form\Element\DateTime")
     * @Annotation\Attributes({"type":"datetime"})
     * @Annotation\Options({"label":"Hasta", "description":"", "addon":""})
     * @ORM\Column(type="datetime", unique=false, nullable=true, name="end")
     * @Transformation\Policy\FormatDateTime(format="Y-m-d H:i")
     */
    public $end = null;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getCalendar()
    {
        return $this->calendar;
    }

    public function setCalendar($calendar)
    {
        $this->calendar = $calendar;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setStart($start)
    {
        $this->start = $start;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function setEnd($end)
    {
        $this->end = $end;
    }

    public function __toString()
    {
        return (string) $this->getId();
    }

    public function toArray(){

        return [
            'id' => $this->getId(),
            'user' => $this->getUser()->getId(),
            'calendar' => $this->getCalendar()->getId(),
            'start' => $this->getStart()->format("Y-m-d H:i"),
            'end' => $this->getEnd()->format("Y-m-d H:i"),
            'duration' => $this->getDuration(),
        ];

    }
}

