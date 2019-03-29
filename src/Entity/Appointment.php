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

    const STATUS_LAPSED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_CANCEL_USER = 2;
    const STATUS_CANCEL_ADMIN = 3;
    const STATUS_ABSENT = 4;

    const STATUS = [
        self::STATUS_LAPSED => "Caducado",
        self::STATUS_ACTIVE => "Activo",
        self::STATUS_CANCEL_USER => "Cancelado",
        self::STATUS_CANCEL_ADMIN => "Cancelado",
        self::STATUS_ABSENT => "Ausente",
    ];

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
     * @Transformation\Policy\Custom(transform="ZfMetal\Restful\Transformation\Policy\Common\IdName::transform")
     */
    public $user = null;

    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({"label":"Agenda","empty_option": "",
     * "target_class":"\ZfMetal\Calendar\Entity\Calendar", "description":""})
     * @ORM\ManyToOne(targetEntity="\ZfMetal\Calendar\Entity\Calendar")
     * @ORM\JoinColumn(name="calendar_id", referencedColumnName="id", nullable=true)
     * @Transformation\Policy\Custom(transform="ZfMetal\Restful\Transformation\Policy\Common\IdName::transform")
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

    /**
     * @var integer
     * @Annotation\Exclude()
     * @ORM\Column(type="integer",  length=1, unique=false, nullable=true, name="status")
     */
    public $status = self::STATUS_ACTIVE;

    public $statusName;

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

    /**
     * @return Calendar
     */
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
        return (string)$this->getId();
    }

    public function toArray()
    {

        return [
            'id' => $this->getId(),
            'user' => $this->getUser()->getId(),
            'calendar' => ["id" => $this->getCalendar()->getId(), "name" => $this->getCalendar()->getName()],
            'start' => $this->getStart()->format("Y-m-d H:i"),
            'end' => $this->getEnd()->format("Y-m-d H:i"),
            'duration' => $this->getDuration(),
            'status' => $this->getStatus(),
            'statusName' => $this->getStatusName()
        ];

    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {

        if (is_string($status) && in_array($status, self::STATUS)) {
            $key = array_search($status, self::STATUS);
            $this->status = self::STATUS[$key];
        }

        if (is_int($status) && key_exists($status, self::STATUS)) {
            $this->status = $status;
        }

    }

    /**
     * @return mixed
     */
    public function getStatusName()
    {
        return self::STATUS[$this->status];
    }


    public function cancelByUser()
    {
        $this->status = self::STATUS_CANCEL_USER;
    }


}

