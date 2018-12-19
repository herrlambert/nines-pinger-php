<?php
/**
 * Created by PhpStorm.
 * User: mattlam
 * Date: 12/19/2018
 * Time: 10:40 AM
 */

namespace ninespinger\tests;

use PHPUnit\Framework\TestCase;
use ninespinger\lib\GutenTag;

class GutenTagTest extends TestCase
{

    protected $gutentag;

    // Create an object to use:
    function setUp()
    {
        // Create instance of class to test
        $this->gutentag = new GutenTag("matt");
    }

    public function testGetName()
    {
        $name = $this->gutentag->getName();
        $this->assertTrue( $name === 'matt' );
    }

    public function testGetMessage()
    {
        $message = $this->gutentag->getMessage();
        $this->assertEquals($message, 'Guten Tag');
    }
}
