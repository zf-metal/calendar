<?php

namespace ZfMetal\Calendar\Entity;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Zend\Form\Annotation as Annotation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * OutOfService
 *
 *
 *
 * @author
 * @license
 * @link
 * @ORM\Table(name="cal_out_of_service")
 * @ORM\Entity(repositoryClass="ZfMetal\Calendar\Repository\OutOfServiceRepository")
 */
class OutOfService
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
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Razon", "description":"", "addon":""})
     * @ORM\Column(type="string", length=50, unique=false, nullable=true,
     * name="reason")
     */
    public $reason = null;

    /**
     * @Annotation\Type("Zend\Form\Element\DateTime")
     * @Annotation\Attributes({"type":"datetime","class":"datetimepicker"})
     * @Annotation\Options({"label":"Desde", "description":"", "addon":""})
     * @ORM\Column(type="datetime", unique=false, nullable=false, name="start")
     */
    public $start = null;

    /**
     * @Annotation\Type("Zend\Form\Element\DateTime")
     * @Annotation\Attributes({"type":"datetime","class":"datetimepicker"})
     * @Annotation\Options({"label":"Hasta", "description":"", "addon":""})
     * @ORM\Column(type="datetime", unique=false, nullable=false, name="end")
     */
    public $end = null;

    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({"label":"Calendario","empty_option": "",
     * "target_class":"\ZfMetal\Calendar\Entity\Calendar", "description":""})
     * @ORM\ManyToOne(targetEntity="\ZfMetal\Calendar\Entity\Calendar")
     * @ORM\JoinColumn(name="calendar_id", referencedColumnName="id", nullable=true)
     */
    public $calendar = null;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getReason()
    {
        return $this->reason;
    }

    public function setReason($reason)
    {
        $this->reason = $reason;
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

    public function getCalendar()
    {
        return $this->calendar;
    }

    public function setCalendar($calendar)
    {
        $this->calendar = $calendar;
    }

    public function __toString()
    {
        return (string) $this->reason;
    }


}

