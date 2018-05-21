<?php


namespace ZfMetal\Calendar\Entity;

interface TicketInterface{

    function getId();

    function getEvent();

    function getSubject();

    function getLocation();
}