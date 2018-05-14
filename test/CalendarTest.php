<?php
namespace ZfMetal\CalendarTest;


use PHPUnit\Framework\TestCase;

class CalendarTest extends TestCase
{

    public function testSomething($scheme)
    {
        $uri = new FileUri;
        $uri->setScheme($scheme);
        $this->assertEquals($scheme, $uri->getScheme());
    }


}