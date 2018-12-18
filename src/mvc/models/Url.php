<?php
/**
 * Created by PhpStorm.
 * User: mattlambert
 * Date: 12/17/18
 * Time: 1:59 PM
 */

namespace ninespinger\mvc\models;


class Url
{
    private $dbConn;

    // Disallow cloning of this class
    private function __clone() {}

    public function __construct($dbConn)
    {
        $this->dbConn = $dbConn;
    }

    public
}