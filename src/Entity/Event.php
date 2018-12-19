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
     * @Annotation\Options({"label":"Visita Reprogramada", "description":"", "addon":""})
     * @ORM\OneToOne(targetEntity="\ZfMetal\Calendar\Entity\Event")
     * @ORM\JoinColumn(name="reschedule_visit_id", referencedColumnName="id", unique=false, nullable=true)
     */
    public $rescheduledVisit = null;

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
     * @Transformation\Policy\Custom(transform="ZfMetal\Restful\Transformation\Policy\Common\Id::transform")
     */
    public $state = null;


    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({"label":"Tipo","empty_option": "",
     * "target_class":"\ZfMetal\Calendar\Entity\EventType", "description":""})
     * @ORM\ManyToOne(targetEntity="\ZfMetal\Calendar\Entity\EventType")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", nullable=true)
     * @Transformation\Policy\Custom(transform="ZfMetal\Restful\Transformation\Policy\Common\Id::transform")
     */
    public $type = null;


    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({"label":"calendar","empty_option": "",
     * "target_class":"\ZfMetal\Calendar\Entity\Calendar", "description":""})
     * @ORM\ManyToOne(targetEntity="\ZfMetal\Calendar\Entity\Calendar")
     * @ORM\JoinColumn(name="calendar_id", referencedColumnName="id", nullable=true)
     * @Transformation\Policy\Custom(transform="ZfMetal\Restful\Transformation\Policy\Common\Id::transform")
     */
    public $calendar = null;


    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Servicio", "description":"", "addon":""})
     * @ORM\Column(type="integer", length=11, unique=false, nullable=true,
     * name="service_id")
     * @Annotation\Exclude()
     * @Transformation\Policy\Custom(transform="ZfMetal\Restful\Transformation\Policy\Common\Id::transform")
     */
    public $service = null;

    /**
     * @Annotation\Exclude()
     * @ORM\Column(type="string", length=2000, unique=false, nullable=true,
     * name="service_description")
     */
    public $serviceDescription = null;


    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Ticket", "description":"", "addon":""})
     * @ORM\Column(type="integer", length=11, unique=false, nullable=true,
     * name="ticket_id")
     */
    public $ticket = null;

    /**
     * @Transformation\Policy\FormatDateTime(format="Y-m-d")
     * @Annotation\Type("Zend\Form\Element\Date")
     * @Annotation\Attributes({"type":"datetime"})
     * @Annotation\Options({"label":"Date From", "description":"Fecha que indica desde cuando es posible agendar este evento", "addon":"", "format" : "Y-m-d"})
     * @Annotation\Validator({"name":"Date", "options": {"format":"Y-m-d",
     * "messages": {"dateInvalidDate": "Fecha no válida. Formato: Año-Mes-Dia  (Ej: 1985-12-31)",
     * "dateFalseFormat":"Fecha no válida. Formato: Año-Mes-Dia  (Ej: 1985-12-31)"}}})
     * @ORM\Column(type="date", unique=false, nullable=true, name="date_from")
     */
    public $dateFrom = null;

    /**
     * @Transformation\Policy\FormatDateTime(format="Y-m-d")
     * @Annotation\Type("Zend\Form\Element\Date")
     * @Annotation\Attributes({"type":"datetime"})
     * @Annotation\Options({"label":"Date To", "description":"Fecha que indica hasta cuando es posible agendar este evento", "addon":"", "format" : "Y-m-d"})
     * @Annotation\Validator({"name":"Date", "options": {"format":"Y-m-d",
     * "messages": {"dateInvalidDate": "Fecha no válida. Formato: Año-Mes-Dia  (Ej: 1985-12-31)",
     * "dateFalseFormat":"Fecha no válida. Formato: Año-Mes-Dia  (Ej: 1985-12-31)"}}})
     * @ORM\Column(type="date", unique=false, nullable=true, name="date_to")
     */
    public $dateTo = null;

    /**
     * @Transformation\Policy\FormatDateTime(format="H:i")
     * @Annotation\Type("Zend\Form\Element\Time")
     * @Annotation\Attributes({"type":"datetime"})
     * @Annotation\Options({"label":"Date From", "description":"Hora que indica desde cuando es posible agendar este evento", "addon":"", "format" : "H:i"})
     * @Annotation\Validator({"name":"Date", "options": {"format":"H:i",
     * "messages": {"dateInvalidDate": "Fecha no válida. Formato: Hora:Minuto  (Ej: 18:30)",
     * "dateFalseFormat":"Fecha no válida. Formato: Hora:Minuto (Ej: 18:30)"}}})
     * @ORM\Column(type="time", unique=false, nullable=true, name="time_from")
     */
    public $timeFrom = null;

    /**
     * @Transformation\Policy\FormatDateTime(format="H:i")
     * @Annotation\Type("Zend\Form\Element\Time")
     * @Annotation\Attributes({"type":"datetime"})
     * @Annotation\Options({"label":"Date To", "description":"Hora que indica hasta cuando es posible agendar este evento", "addon":"", "format" : "H:i"})
     * @Annotation\Validator({"name":"Date", "options": {"format":"H:i",
     * "messages": {"dateInvalidDate": "Fecha no válida. Formato: Hora:Minuto  (Ej: 18:30)",
     * "dateFalseFormat":"Fecha no válida. Formato: Hora:Minuto (Ej: 18:30)"}}})
     * @ORM\Column(type="time", unique=false, nullable=true, name="time_to")
     */
    public $timeTo = null;

    /**
     * @Transformation\Policy\FormatDateTime(format="Y-m-d H:i")
     * @Annotation\Type("Zend\Form\Element\DateTimeLocal")
     * @Annotation\Attributes({"type":"datetime","class":"datetimepicker"})
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
     * @Annotation\Attributes({"type":"datetime","class":"datetimepicker"})
     * @Annotation\Options({"label":"end", "description":"", "addon":"", "format" : "Y-m-d H:i"})
     * @Annotation\Validator({"name":"Date", "options": {"format":"Y-m-d H:i",
     * "messages": {"dateInvalidDate": "Fecha no válida. Formato: Año-Mes-Dia Hora:Minuto (Ej: 1985-12-31 23:59)",
     * "dateFalseFormat":"Fecha no válida. Formato: Año-Mes-Dia Hora:Minuto (Ej: 1985-12-31 23:59)"}}})
     * @ORM\Column(type="datetime", unique=false, nullable=true, name="end")
     */
    public $end = null;


    /**
     * @Annotation\Exclude()
     * @ORM\Column(type="string", length=300, unique=false, nullable=true,
     * name="description")
     */
    public $description = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Textarea")
     * @Annotation\Attributes({"type":"textarea"})
     * @Annotation\Options({"label":"Comentario", "description":""})
     * @ORM\Column(type="string", length=500, unique=false, nullable=true,
     * name="comments")
     */
    public $comments = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Textarea")
     * @Annotation\Attributes({"type":"textarea"})
     * @Annotation\Options({"label":"Comentario Final", "description":""})
     * @ORM\Column(type="string", length=500, unique=false, nullable=true,
     * name="final_comment")
     */
    public $finalComment = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Cliente", "description":"", "addon":""})
     * @ORM\Column(type="string", length=120, unique=false, nullable=true,
     * name="client")
     */
    public $client = null;

    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Sucursal", "description":"", "addon":""})
     * @ORM\Column(type="string", length=100, unique=false, nullable=true,
     * name="branch_office")
     */
    public $branchOffice = null;

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
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({"label":"Zonas","empty_option": "",
     * "target_class":"\ZfMetal\Calendar\Entity\Zone", "description":""})
     * @ORM\ManyToOne(targetEntity="\ZfMetal\Calendar\Entity\Zone")
     * @ORM\JoinColumn(name="zone_id", referencedColumnName="id", nullable=true)
     * @Transformation\Policy\Custom(transform="\ZfMetal\Restful\Transformation\Policy\Common\IdName::transform")
     */
    public $zone = null;


    /**
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({"label":"Zonas","empty_option": "",
     * "target_class":"\ZfMetal\Calendar\Entity\EventLink", "description":""})
     * @ORM\ManyToOne(targetEntity="\ZfMetal\Calendar\Entity\EventLink")
     * @ORM\JoinColumn(name="link_id", referencedColumnName="id", nullable=true)
     * @Transformation\Policy\Custom(transform="ZfMetal\Restful\Transformation\Policy\Common\Id::transform")
     */
    public $link = null;

    /**
     * @Annotation\Exclude()
     * @ORM\Column(type="string", length=1000, unique=false, nullable=true,
     * name="config")
     * @Transformation\Policy\Custom(format="\ZfMetal\Restful\Transformation\Policy\Common\Json::format")
     */
    public $config = null;


    /**
     * @Annotation\Exclude()
     * @ORM\ManyToOne(targetEntity="\ZfMetal\Security\Entity\User")
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id", nullable=true)
     */
    public $updatedBy = null;

    /**
     * @Annotation\Exclude()
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", unique=false, nullable=true,
     * name="updated_at")
     */
    public $updatedAt = null;


    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Remito", "description":"", "addon":""})
     * @ORM\Column(type="string", length=20, unique=false, nullable=true,
     * name="delivery_note")
     */
    public $deliveryNote = null;


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
     * @return \ZfMetal\Calendar\Entity\EventState
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

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }




    public function __toString()
    {
        return (string)$this->title;
    }

    /**
     * @return mixed
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * @param mixed $dateFrom
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;
    }

    /**
     * @return mixed
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }

    /**
     * @param mixed $dateTo
     */
    public function setDateTo($dateTo)
    {
        $this->dateTo = $dateTo;
    }

    /**
     * @return mixed
     */
    public function getTimeFrom()
    {
        return $this->timeFrom;
    }

    /**
     * @param mixed $timeFrom
     */
    public function setTimeFrom($timeFrom)
    {
        $this->timeFrom = $timeFrom;
    }

    /**
     * @return mixed
     */
    public function getTimeTo()
    {
        return $this->timeTo;
    }

    /**
     * @param mixed $timeTo
     */
    public function setTimeTo($timeTo)
    {
        $this->timeTo = $timeTo;
    }

    /**
     * @return mixed
     */
    public function getZone()
    {
        return $this->zone;
    }

    /**
     * @param mixed $zone
     */
    public function setZone($zone)
    {
        $this->zone = $zone;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @return mixed
     */
    public function getServiceDescription()
    {
        return $this->serviceDescription;
    }

    /**
     * @param mixed $serviceDescription
     */
    public function setServiceDescription($serviceDescription)
    {
        $this->serviceDescription = $serviceDescription;
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }


    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function getBranchOffice()
    {
        return $this->branchOffice;
    }

    /**
     * @param mixed $branchOffice
     */
    public function setBranchOffice($branchOffice)
    {
        $this->branchOffice = $branchOffice;
    }

    /**
     * @return mixed
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * @param mixed $updatedBy
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getDeliveryNote()
    {
        return $this->deliveryNote;
    }

    /**
     * @param mixed $deliveryNote
     */
    public function setDeliveryNote($deliveryNote)
    {
        $this->deliveryNote = $deliveryNote;
    }

    /**
     * @return mixed
     */
    public function getRescheduledVisit()
    {
        return $this->rescheduledVisit;
    }

    /**
     * @param mixed $rescheduledVisit
     */
    public function setRescheduledVisit($rescheduledVisit)
    {
        $this->rescheduledVisit = $rescheduledVisit;
    }


    public function __clone() {
        $this->id = null;
    }

    /**
     * @return mixed
     */
    public function getFinalComment()
    {
        return $this->finalComment;
    }

    /**
     * @param mixed $finalComment
     */
    public function setFinalComment($finalComment)
    {
        $this->finalComment = $finalComment;
    }




}

