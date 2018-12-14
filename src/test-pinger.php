<?php
/**
 * Created by PhpStorm.
 * User: mattlam
 * Date: 12/13/2018
 * Time: 10:40 AM
 */
require "../vendor/autoload.php";

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\GuzzleException;

$urls = [
    ['id' => 1, 'url' => 'http://staff.washington.edu/mattlam'],
    ['id' => 2, 'url' => 'http://www.washington.edu/'],
    ['id' => 3, 'url' => 'https://www.washington.edu/research/'],
    ['id' => 4, 'url' => 'https://www.law.uw.edu/'],
    ['id' => 5, 'url' => 'https://www.washington.edu/research/tools/'],
    ['id' => 6, 'url' => 'https://www.washington.edu/research/learning/online/'],
    ['id' => 7, 'url' => 'http://www.lib.washington.edu/'],
    ['id' => 8, 'url' => 'https://foster.uw.edu/'],
    ['id' => 9, 'url' => 'https://www.engr.washington.edu/'],
    ['id' => 10, 'url' => 'http://be.washington.edu/'],
    ['id' => 11, 'url' => 'https://www.health-informatics.uw.edu/'],
    ['id' => 12, 'url' => 'https://artsci.washington.edu/'],
    ['id' => 13, 'url' => 'https://www.uwmedicine.org/'],
    ['id' => 14, 'url' => 'https://globalhealth.washington.edu/'],
    ['id' => 15, 'url' => 'https://www.uwb.edu/'],
    ['id' => 16, 'url' => 'http://www.tacoma.uw.edu/'],
    ['id' => 17, 'url' => 'https://environment.uw.edu/']
];

$requestResultArray = doRequests($urls);
print_r($requestResultArray);

/**
 * @param array $urls
 */
function doRequests(Array $urlArrays = [])
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
