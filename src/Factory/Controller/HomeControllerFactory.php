<?php

namespace ZfMetal\Calendar\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * HomeControllerFactory
 *
 *
 *
 * @author
 * @license
 * @link
 */
class HomeControllerFactory implements FactoryInterface
{

    public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, array $options = null)
    {
        return new \ZfMetal\Calendar\Controller\HomeController();
    }


}

