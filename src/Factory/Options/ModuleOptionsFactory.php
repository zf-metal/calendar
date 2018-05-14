<?php

namespace ZfMetal\Calendar\Factory\Options;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * ModuleOptionsFactory
 *
 *
 *
 * @author
 * @license
 * @link
 */
class ModuleOptionsFactory implements FactoryInterface
{

    public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
         return new \ZfMetal\Calendar\Options\ModuleOptions(isset($config['ZfMetal\Calendar.options']) ? $config['ZfMetal\Calendar.options'] : array());
    }


}

