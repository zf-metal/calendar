<?php

namespace ZfMetal\Calendar\Entity;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Zend\Form\Annotation as Annotation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;
use ZfMetal\Restful\Transformation;

/**
 * Event
 *
 *
 *
 * @author
 * @license
 * @link
 * @ORM\Table(name="cal_events")
 * @ORM\Entity(repositoryClass="ZfMetal\Calendar\Repository\EventRepository")
 */
class Event
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
     * @Annotation\Options({"label":"title", "description":"", "addon":""})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true,
     * name="title")
     */
    public $title = null;

    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({"label":"Estado","empty_option": "",
     * "target_class":"\ZfMetal\Calendar\Entity\EventState", "description":""})
     * @ORM\ManyToOne(targetEntity="\ZfMetal\Calendar\Entity\EventState")
     * @ORM\JoinColumn(name="state_id", referencedColumnName="id", nullable=true)
     * @Transformation\Policy\Custom(transform= "\ZfMetal\Calendar\PolicyHandler\EntityId::transform")
     */
    public $state = null;


    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({"label":"calendar","empty_option": "",
     * "target_class":"\ZfMetal\Calendar\Entity\Calendar", "description":""})
     * @ORM\ManyToOne(targetEntity="\ZfMetal\Calendar\Entity\Calendar")
     * @ORM\JoinColumn(name="calendar_id", referencedColumnName="id", nullable=true)
     * @Transformation\Policy\Custom(transform= "\ZfMetal\Calendar\PolicyHandler\EntityId::transform")
     */
    public $calendar = null;


    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Servicio", "description":"", "addon":""})
     * @ORM\Column(type="integer", length=11, unique=false, nullable=true,
     * name="service_id")
     */
    public $service = null;


    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Ticket", "description":"", "addon":""})
     * @ORM\Column(type="integer", length=11, unique=false, nullable=true,
     * name="ticket_id")
     */
    public $ticket = null;

    /**
     * @Transformation\Policy\FormatDateTime(format="Y-m-d H:i")
     * @Annotation\Type("Zend\Form\Element\DateTimeLocal")
     * @Annotation\Attributes({"type":"datetime"})
     * @Annotation\Options({"label":"start", "description":"", "addon":"", "format" : "Y-m-d H:i"})
     * @Annotation\Validator({"name":"Date", "options": {"format":"Y-m-d H:i",
     * "messages": {"dateInvalidDate": "Fecha no válida. Formato: Año-Mes-Dia Hora:Minuto (Ej: 1985-12-31 23:59)",
     * "dateFalseFormat":"Fecha no válida. Formato: Año-Mes-Dia Hora:Minuto (Ej: 1985-12-31 23:59)"}}})
     * @ORM\Column(type="datetime", unique=false, nullable=true, name="start")
     */
    public $start = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Duracion", "description":"Duración en Minutos",
     * "addon":""})
     * @ORM\Column(type="integer", length=5, unique=false, nullable=true,
     * name="duration")
     */
    public $duration = null;

    /**
     * @Transformation\Policy\FormatDateTime(format="Y-m-d H:i")
     * @Annotation\Type("Zend\Form\Element\DateTimeLocal")
     * @Annotation\Attributes({"type":"datetime"})
     * @Annotation\Options({"label":"end", "description":"", "addon":"", "format" : "Y-m-d H:i"})
     * @Annotation\Validator({"name":"Date", "options": {"format":"Y-m-d H:i",
     * "messages": {"dateInvalidDate": "Fecha no válida. Formato: Año-Mes-Dia Hora:Minuto (Ej: 1985-12-31 23:59)",
     * "dateFalseFormat":"Fecha no válida. Formato: Año-Mes-Dia Hora:Minuto (Ej: 1985-12-31 23:59)"}}})
     * @ORM\Column(type="datetime", unique=false, nullable=true, name="end")
     */
    public $end = null;


    /**
     * @Annotation\Type("Zend\Form\Element\Textarea")
     * @Annotation\Attributes({"type":"textarea"})
     * @Annotation\Options({"label":"description", "description":""})
     * @ORM\Column(type="string", length=500, unique=false, nullable=true,
     * name="description")
     */
    public $description = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Ubicacion", "description":"", "addon":""})
     * @ORM\Column(type="string", length=120, unique=false, nullable=true,
     * name="location")
     */
    public $location = null;


    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Latitud", "description":"", "addon":""})
     * @ORM\Column(type="decimal",  scale=6, precision=11, unique=false, nullable=true,
     * name="lat")
     */
    public $lat = 0;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Longitud", "description":"", "addon":""})
     * @ORM\Column(type="decimal",  scale=6, precision=11, unique=false, nullable=true,
     * name="lng")
     */
    public $lng = 0;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Codigo Postal", "description":"", "addon":""})
     * @ORM\Column(type="string", length=15, unique=false, nullable=true,
     * name="postal_code")
     */
    public $postalCode = null;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
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
     * @return mixed
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * @param mixed $ticket
     */
    public function setTicket($ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param mixed $start
     */
    public function setStart($start)
    {
        $this->start = $start;
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

    /**
     * @return mixed
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param mixed $end
     */
    public function setEnd($end)
    {
        $this->end = $end;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param mixed $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return mixed
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @param mixed $lng
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    }

    /**
     * @return mixed
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param mixed $postalCode
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return mixed
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param mixed $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }




    public function __toString()
    {
        return (string)$this->title;
    }


}

