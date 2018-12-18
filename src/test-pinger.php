<?php
require "../vendor/autoload.php";
require('../config/config.php');

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\GuzzleException;
use ninespinger\lib\Database;

/**
 * Create a database connection
 */
$database = Database::getInstance();
$database->setDbAllParams(DB_NAME, DB_HOST, DB_PORT, DB_USER, DB_PASS, 'utf8');
$database->createDbConnection();
$dbConn = $database->getDbConnection();

/**
 * Main program execution - ping urls and output results
 */
$urlsArray = getUrls($dbConn);
$pingResultsArray = pingUrls($urlsArray);
print_r($pingResultsArray);


function getUrls($dbConn)
{
    $urls = array();

    try {

        $query = "
            SELECT u.id, u.url
            FROM urls u
            JOIN urlgroups ug
            ON ug.id = u.urlgroup_id
            WHERE ug.id = 1";

        $stmt = $dbConn->prepare( $query );

        $result = $stmt->execute();

        // Try to fetch the results
        if ( $result ) {
            $stmt->setFetchMode( \PDO::FETCH_ASSOC );
            $urls = $stmt->fetchAll();
        }

    } catch(Exception $e) {

        // Catch generic Exceptions
        print_r($e);
    }

    return $urls;
}

function pingUrls(Array $urlArrays = [])
{
    $requestResultArray = [];

    if (count($urlArrays) > 0) {

        foreach($urlArrays as $urlArray) {

            $responseArray = sendHeadRequest($urlArray['url']);
            $responseArray['url'] = $urlArray['url'];
            $responseArray['url_id'] = $urlArray['id'];
            $requestResultArray[] = $responseArray;
        }
    }

    return $requestResultArray;
}

/**
 * @param string $url
 * @return array
 */
function sendHeadRequest($url = '')
{
    if (is_string($url) && !empty($url)) {

        $client = new Client();
        $responseArray = [];
        $responseArray['url'] = $url;

        try {
            $response = $client->request('HEAD', $url, ['verify' => false]);
            $headers[] = $response->getHeaders();
            $responseArray['datetime'] = $headers[0]['Date'][0];
            $responseArray['statusCode'] = $response->getStatusCode();
        } catch (ClientException $exception) {
            $headers[] = $exception->getResponse()->getHeaders();
            $responseArray['datetime'] = $headers[0]['Date'][0];
            $responseArray['statusCode'] = $exception->getResponse()->getStatusCode();
        } catch (ServerException $exception) {
            $headers[] = $exception->getResponse()->getHeaders();
            $responseArray['datetime'] = $headers[0]['Date'][0];
            $responseArray['statusCode'] = $exception->getResponse()->getStatusCode();
        } catch (GuzzleException $exception) {
            $responseArray['error'] = $exception->getMessage();
        }
    }

    return $responseArray;
}
