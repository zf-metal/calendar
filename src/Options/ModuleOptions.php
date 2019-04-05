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

    private $appointmentEmailTitle = "TITLE";
    private $appointmentEmailBackgroundColorTitle = "#000000";
    private $appointmentEmailColorTitle = "#ffffff";
    private $appointmentEmailSignature = "firma";
    private $appointmentEmailUrl = "www";

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

    /**
     * @return string
     */
    public function getAppointmentEmailTitle()
    {
        return $this->appointmentEmailTitle;
    }

    /**
     * @param string $appointmentEmailTitle
     */
    public function setAppointmentEmailTitle($appointmentEmailTitle)
    {
        $this->appointmentEmailTitle = $appointmentEmailTitle;
    }

    /**
     * @return string
     */
    public function getAppointmentEmailBackgroundColorTitle()
    {
        return $this->appointmentEmailBackgroundColorTitle;
    }

    /**
     * @param string $appointmentEmailBackgroundColorTitle
     */
    public function setAppointmentEmailBackgroundColorTitle($appointmentEmailBackgroundColorTitle)
    {
        $this->appointmentEmailBackgroundColorTitle = $appointmentEmailBackgroundColorTitle;
    }

    /**
     * @return string
     */
    public function getAppointmentEmailColorTitle()
    {
        return $this->appointmentEmailColorTitle;
    }

    /**
     * @param string $appointmentEmailColorTitle
     */
    public function setAppointmentEmailColorTitle($appointmentEmailColorTitle)
    {
        $this->appointmentEmailColorTitle = $appointmentEmailColorTitle;
    }

    /**
     * @return string
     */
    public function getAppointmentEmailSignature()
    {
        return $this->appointmentEmailSignature;
    }

    /**
     * @param string $appointmentEmailSignature
     */
    public function setAppointmentEmailSignature($appointmentEmailSignature)
    {
        $this->appointmentEmailSignature = $appointmentEmailSignature;
    }

    /**
     * @return string
     */
    public function getAppointmentEmailUrl()
    {
        return $this->appointmentEmailUrl;
    }

    /**
     * @param string $appointmentEmailUrl
     */
    public function setAppointmentEmailUrl($appointmentEmailUrl)
    {
        $this->appointmentEmailUrl = $appointmentEmailUrl;
    }







}

