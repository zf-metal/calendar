<?php

namespace ZfMetal\Calendar;

use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\Console\Adapter\AdapterInterface as Console;
/**
 * Module
 *
 *
 *
 * @author
 * @license
 * @link
 */
class Module  implements
    ConsoleBannerProviderInterface,
    ConsoleUsageProviderInterface
{

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getConsoleBanner(Console $console)
    {
        return "ZfMetal Calendar Module";
    }

    /**
     * This method is defined in ConsoleUsageProviderInterface
     * @param Console $console
     * @return array
     */
    public function getConsoleUsage(Console $console)
    {
        return [
            'initcalendar' => 'Initialize data calendar',
        ];
    }


}

