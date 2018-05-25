<?php

namespace ZfMetal\Calendar\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * HomeController
 *
 *
 *
 * @author
 * @license
 * @link
 */
class HomeController extends AbstractActionController
{

    public function indexAction()
    {
        $this->layoutHelper()->setPageTitle("");
        return [];
    }


}

