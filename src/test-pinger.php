<?php
require "../vendor/autoload.php";
require('../config/config.php');


use ninespinger\lib\Database;
use ninespinger\lib\Pinger;
use ninespinger\mvc\controllers;

/**
 * Create a database connection
 */
$database = Database::getInstance();
$database->setDbAllParams(DB_NAME, DB_HOST, DB_PORT, DB_USER, DB_PASS, 'utf8');
$database->createDbConnection();
$dbConn = $database->getDbConnection();

/**
 * Create Pinger object
 */
$pinger = Pinger::getInstance();

/**
 * Main program execution - ping urls and output results
 */
$urlController = new controllers\Url($dbConn);
$urlsArray = $urlController->getUrlsByUrlGroup(1);
$pingResultsArray = $pinger->pingUrls($urlsArray);
print_r($pingResultsArray);
