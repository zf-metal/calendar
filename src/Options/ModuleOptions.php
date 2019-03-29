<?php

namespace ZfMetal\Calendar\Options;

/**
 * ModuleOptions
 *
 *
 *
 * @author
 * @license
 * @link
 */
class ModuleOptions extends \Zend\Stdlib\AbstractOptions
{

    private $routeTicketList = '';

    private $ticketEntity = '';

    private $appointmentConfigEnable = true;


    private $appointmentEmailNotify = false;

    public function getTicketEntity()
    {
        return $this->ticketEntity;
    }

    public function setTicketEntity($ticketEntity)
    {
        $this->ticketEntity= $ticketEntity;
    }

    public function getRouteTicketList()
    {
        return $this->routeTicketList;
    }

    public function setRouteTicketList($routeTicketList)
    {
        $this->routeTicketList= $routeTicketList;
    }

    public function getPreEventEnable()
    {
        return $this->appointmentConfigEnable;
    }

    public function setPreEventEnable($preEventEnable)
    {
        $this->appointmentConfigEnable= $preEventEnable;
    }

    /**
     * @return bool
     */
    public function getAppointmentConfigEnable()
    {
        return $this->appointmentConfigEnable;
    }

    /**
     * @param bool $appointmentConfigEnable
     */
    public function setAppointmentConfigEnable($appointmentConfigEnable)
    {
        $this->appointmentConfigEnable = $appointmentConfigEnable;
    }

    /**
     * @return bool
     */
    public function getAppointmentEmailNotify()
    {
        return $this->appointmentEmailNotify;
    }

    /**
     * @param bool $appointmentEmailNotify
     */
    public function setAppointmentEmailNotify($appointmentEmailNotify)
    {
        $this->appointmentEmailNotify = $appointmentEmailNotify;
    }





}

