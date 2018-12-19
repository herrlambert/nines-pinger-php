<?php
/**
 * Created by PhpStorm.
 * User: mattlam
 * Date: 12/19/2018
 * Time: 10:22 AM
 */

namespace ninespinger\lib;


class GutenTag
{
    private $message = '';
    private $name = null;

    public function __construct($name)
    {
        $this->name = $name;
        $this->setMessage('Guten Tag');
    }

    private function setMessage($message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getName()
    {
        return $this->name;
    }
}
