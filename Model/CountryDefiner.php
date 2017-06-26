<?php
namespace Custom\Training1_Review\Model;

use Custom\Training1_Review\Api\CountryDefinerInterface;

/**
 * Class CountryDefiner
 *
 * @package Custom\Training1_Review\Model
 */
class CountryDefiner implements CountryDefinerInterface
{
    /**
     * @var \Magento\Framework\HTTP\ZendClientFactory
     */
    private $zendClientFactory;

    /**
     * Country Definer Api Url
     */
    const API_URL = 'http://freegeoip.net/json/';

    public function __construct(\Magento\Framework\HTTP\ZendClientFactory $zendClientFactory)
    {
        $this->zendClientFactory = $zendClientFactory;
    }

    /**
     * @param string $ip
     * @return false|array
     */
    public function defineCountry($ip)
    {
        $response = $this->sendRequest($ip);
        if ($response->getStatus() === 200) {
            $responseArray = json_decode($response->getBody(), true);
            if (isset($responseArray['country_name']) && isset($responseArray['city'])) {
                return array('country' => $responseArray['country_name'], 'city' => $responseArray['city']);
            }
        }
        return false;
    }

    /**
     * @param $ip
     * @return \Zend_Http_Response
     */
    protected function sendRequest($ip)
    {
        $client = $this->zendClientFactory->create();
        $client->setHeaders(array(
                        'Accept-encoding' => 'gzip,deflate',
                        'X-Powered-By' => 'Zend Framework',
                        'Content-Type' => 'application/json')
        );
        $client->setUri(self::API_URL . $ip);

        return $client->request('GET');
    }
}
