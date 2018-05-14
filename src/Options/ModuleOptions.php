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

    private $ticketEntity = '\\ZfMetal\\Calendar\\Entity\\Ticket';

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


}

