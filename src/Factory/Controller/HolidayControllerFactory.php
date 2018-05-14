<?php

namespace ZfMetal\Calendar\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * HolidayControllerFactory
 *
 *
 *
 * @author
 * @license
 * @link
 */
class HolidayControllerFactory implements FactoryInterface
{

    public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, array $options = null)
    {
        /* @var $em \Doctrine\ORM\EntityManager */
        $em = $container->get("doctrine.entitymanager.orm_default");
        /* @var $grid \ZfMetal\Datagrid\Grid */
        $grid = $container->build("zf-metal-datagrid", ["customKey" => "zfmetal-calendar-entity-holiday"]);
        return new \ZfMetal\Calendar\Controller\HolidayController($em,$grid);
    }


}

