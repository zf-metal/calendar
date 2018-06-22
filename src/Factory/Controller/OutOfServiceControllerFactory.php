<?php

namespace ZfMetal\Calendar\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * OutOfServiceControllerFactory
 *
 *
 *
 * @author
 * @license
 * @link
 */
class OutOfServiceControllerFactory implements FactoryInterface
{

    public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, array $options = null)
    {
        /* @var $em \Doctrine\ORM\EntityManager */
        $em = $container->get("doctrine.entitymanager.orm_default");
        /* @var $grid \ZfMetal\Datagrid\Grid */
        $grid = $container->build("zf-metal-datagrid", ["customKey" => "zfmetal-calendar-entity-outofservice"]);
        return new \ZfMetal\Calendar\Controller\OutOfServiceController($em,$grid);
    }


}

