<?php

namespace ZfMetal\Calendar\Controller;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;
/**
 * ClienteController
 *
 *
 *
 * @author
 * @license
 * @link
 */
class InitController extends AbstractActionController
{


    /**
     * @var \Doctrine\ORM\EntityManager
     */
    public $em = null;

    /**
     * @var \ZfMetal\Datagrid\Grid
     */
    public $grid = null;

    public function getEm()
    {
        return $this->em;
    }

    public function setEm(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }


    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    public function initAction(){


        $request = $this->getRequest();

        if (!$request instanceof ConsoleRequest) {
            throw new RuntimeException('You can only use this action from a console!');
        }


        try {
            $loader = new Loader();
            $loader->addFixture(new \ZfMetal\Calendar\DataFixture\EventStateLoader());


            $purger = new ORMPurger();
            $executor = new ORMExecutor($this->getEm(), $purger);
            $executor->execute($loader->getFixtures(), true);
        }catch (\Exception $e){
            return "Exception. Message: ".$e->getMessage(). "trace: ".$e->getTraceAsString();
        }
        return "ok";
    }


}

