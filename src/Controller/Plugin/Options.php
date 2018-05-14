<?php

namespace ZfMetal\Calendar\Controller\Plugin;

/**
 * Options
 *
 * @author
 * @license
 * @link
 */
class Options extends \Zend\Mvc\Controller\Plugin\AbstractPlugin
{

    private $moduleOptions = null;

    public function __construct(\ZfMetal\Calendar\Options\ModuleOptions $moduleOptions)
    {
        $this->moduleOptions = $moduleOptions;
    }

    public function __invoke()
    {
        return $this->moduleOptions;
    }


}

