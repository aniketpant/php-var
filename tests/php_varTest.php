<?php

namespace PHP_Var\Tests;

use PHP_Var\PHP_Var;

class PHP_VarTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInteger()
    {
        PHP_Var::set('foo', 1);
        PHP_Var::set('bar', 0);
        $this->assertEquals(PHP_Var::get('foo'), "var foo = 1;");
        $this->assertEquals(PHP_Var::get('bar'), "var bar = 0;");
    }

    public function testGetDouble()
    {
        PHP_Var::set('foo', 1.01);
        $this->assertEquals(PHP_Var::get('foo'), "var foo = 1.01;");
    }

    public function testGetString()
    {
        PHP_Var::set('foo', 'bar');
        $this->assertEquals(PHP_Var::get('foo'), "var foo = 'bar';");
    }

    public function testGetBool()
    {
        PHP_Var::set('foo', true);
        PHP_Var::set('bar', false);
        $this->assertEquals(PHP_Var::get('foo'), "var foo = 1;");
        $this->assertEquals(PHP_Var::get('bar'), "var bar = 0;");
    }

    public function testGetArray()
    {
        PHP_Var::set('foo', array(1, 2, 3));
        $this->assertEquals(PHP_Var::get('foo'), "var foo = [1,2,3];");
    }

    public function testGetAssocArray()
    {
        PHP_Var::set('foo', array('fuu' => 1, 'baz' => 2));
        $this->assertEquals(PHP_Var::get('foo'), "var foo = JSON.parse({\"fuu\":1,\"baz\":2});");
    }

    public function testGetObject()
    {
        $testClass = new \StdClass();
        $testClass->fuu = 'baz';
        PHP_Var::set('foo', $testClass);
        $this->assertEquals(PHP_Var::get('foo'), "var foo = JSON.parse({\"fuu\":\"baz\"});");
    }
}
