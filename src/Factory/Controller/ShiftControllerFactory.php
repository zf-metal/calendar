<?php

namespace ZfMetal\Calendar\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZfMetal\Calendar\Service\AppointmentService;

/**
 * ShiftControllerFactory
 *
 *
 *
 * @author
 * @license
 * @link
 */
class ShiftControllerFactory implements FactoryInterface
{

    public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, array $options = null)
    {
        /* @var $em \Doctrine\ORM\EntityManager */
        $em = $container->get("doctrine.entitymanager.orm_default");

        $shiftService =  $container->get(AppointmentService::class);


        return new \ZfMetal\Calendar\Controller\ShiftController($em,$shiftService);
    }


}

