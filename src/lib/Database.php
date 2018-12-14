<?php
namespace zweig\lib;

/**
 * Class Database
 *
 * Uses the singleton pattern to provide a database connection using PDO
 *
 * @package oris\nines-pinger
 */
class Database
{
    // Store a single instance of this class
    private static $_instance = NULL;

    // Array for storing database connection parameters
    private $_dbConnectionParms = array();

    // Store database connection
    private $_connection = NULL;

    // Declare empty private methods to prevent users from trying to do anything
    // via these method calls
    private function __construct() {}
    private function __clone() {}

    // Method for returning instance
    public static function getInstance()
    {
        if (self::$_instance == NULL) {
            self::$_instance = new Database();
        }
        return self::$_instance;
    }

    // Set database connection parameter: name
    public function setDbName($dbName)
    {
        $this->_dbConnectionParms['dbName'] = $dbName;
    }

    // Set database connection parameter: host
    public function setDbHost($dbHost)
    {
        $this->_dbConnectionParms['dbHost'] = $dbHost;
    }

    // Set the database connection parameter: port
    public function setDbPort($dbPort)
    {
        $this->_dbConnectionParms['dbPort'] = $dbPort;
    }

    // Set database connection parameter: user
    public function setDbUser($dbUser)
    {
        $this->_dbConnectionParms['dbUser'] = $dbUser;
    }

    // Set database connection parameter: user password
    public function setDbPass($dbPass)
    {
        $this->_dbConnectionParms['dbPass'] = $dbPass;
    }

    // Set database connection parameter: character set
    public function setDbCharSet($dbCharSet)
    {
        $this->_dbConnectionParms['dbCharSet'] = $dbCharSet;
    }

    // Set database connection parameters: all
    public function setDbAllParams($dbName, $dbHost, $dbPort, $dbUser, $dbPass, $dbCharSet) {
        if (isset($dbName)) $this->setDbName($dbName);
        if (isset($dbHost)) $this->setDbHost($dbHost);
        if (isset($dbPort)) $this->setDbPort($dbPort);
        if (isset($dbUser)) $this->setDbUser($dbUser);
        if (isset($dbPass)) $this->setDbPass($dbPass);
        if (isset($dbCharSet)) $this->setDbCharSet($dbCharSet);
    }

    // Get database all connection parameters (returns array)
    public function getDbAllParams()
    {
        return $this->_dbConnectionParms;
    }

    // Method to create a database connection
    public function createDbConnection()
    {
        // Create database connection using PDO
        try {
            // Add the database name and host to connection parameters
            $dbNamePortHost =  "mysql:dbname={$this->_dbConnectionParms['dbName']};";
            $dbNamePortHost .= "host={$this->_dbConnectionParms['dbHost']};";

            // If Port and Character Set have been specified, then add them too
            if (isset($this->_dbConnectionParms['dbPort'])) {
                $dbNamePortHost .= "port={$this->_dbConnectionParms['dbPort']};";
            }
            if (isset($this->_dbConnectionParms['dbCharSet'])) {
                $dbNamePortHost .= "charset=utf8";
            }

            // Create the PDO connection object
            $this->_connection = new \PDO(
                $dbNamePortHost,
                $this->_dbConnectionParms['dbUser'],
                $this->_dbConnectionParms['dbPass']);

        } catch(PDOException $e) {

            // Report database connection error
            $pageTitle = 'Error!';
            include('includes/header.php');
            include('includes/error.php');
            include('includes/footer.php');
            exit();

        }
    }

    // Method to retrieve database connection
    public function getDbConnection()
    {
        // Return the connection if it has been created
        if (isset($this->_connection)) {

            return $this->_connection;

        // Attempt to create the connection and return it if connection has not yet been created
        } else {

            $this->createDbConnection();

            if (isset($this->_connection)) {
                return $this->_connection;
            } else {
                return NULL;
            }

        }
    }
}
