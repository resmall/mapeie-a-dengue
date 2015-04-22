<?php

class TesteTest extends PHPUnit_Framework_TestCase
{
    
    protected function setUp()
    {
    }
    
    protected function tearDown()
    {
    }
   
    public function testHelloWorld()
    {
        $this->assertEquals('Hello World', 'Hello World');
    }
}