<?php

namespace Alexschwarz89\IcecatXML;
use Alexschwarz89\IcecatXML\Exception\IcecatException;
use GuzzleHttp\Exception\RequestException;

/**
 * Class Api
 *
 * PHP Interface to the Icecat XML Interface
 *
 * @package Alexschwarz89\IcecatXML
 */
class Api
{
    /**
     * The base URL used for all requests
     *
     * @var string
     */
    protected $apiBaseUrl = 'https://data.icecat.biz';


    /**
     * The endpoint relative to base URL for all XML requests
     *
     * @var string
     */
    protected $xmlEndpoint = 'xml_s3/xml_server3.cgi';

    /**
     * The endpoint relative to base URL for direct ID request
     *
     * @var string
     */
    protected $idEndpoint  = 'export/level4';

    /**
     * @var \GuzzleHttp\Client
     */
    protected $guzzle     = null;
    /**
     * @var array
     */
    protected $headers = array(
        'Accept-Encoding: gzip'
    );
    /**
     * @var bool
     */
    protected $debug = false;

    /**
     * @var
     */
    private $username;
    /**
     * @var
     */
    private $password;

    /**
     * Constructor with Icecat Username and Password
     *
     * @param $username
     * @param $password
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;

        $this->init();
    }
    /**
     * Init Guzzle Instance
     */
    protected function init()
    {
        $this->guzzle = new \GuzzleHttp\Client(array(
            'base_url' => $this->apiBaseUrl,
            'defaults' => array(
                'auth' => [$this->username, $this->password]
            ),
            'headers'        => $this->headers,
            'decode_content' => true
        ));
    }

    /**
     * @param $params
     * @return bool|\SimpleXMLElement
     */
    protected function request($endpoint, $params)
    {
        try {
            $response = $this->guzzle->get($endpoint,
                array(
                    'query' => $params
                ));
        } catch (RequestException $e) {
            if ($this->debug) {
                print $e->getRequest() . "\n";
                if ($e->hasResponse()) {
                    print $e->getResponse() . "\n";
                }
            }

            return false;
        }

        return $response->xml();
    }

    /**
     * @param $ean
     * @return bool|\SimpleXMLElement
     */
    public function getArticleByEAN($ean, $lang='DE')
    {
        $params = array(
            'ean_upc' => $ean,
            'lang' => $lang
        );

        return $this->request($this->xmlEndpoint, $params);
    }

    /**
     * @param $vendor
     * @param $mpn
     * @param string $lang
     * @return bool|\SimpleXMLElement
     */
    public function getArticleByMPN($vendor, $mpn, $lang='DE')
    {
        $params = array(
            'prod_id' => $mpn,
            'vendor' => $vendor,
            'lang' => $lang,
            'output' => 'productxml'
        );

        return $this->request($this->xmlEndpoint, $params);
    }

    /**
     * Queries article by icecat ID
     *
     * @param $icecatId
     * @param string $lang
     * @return bool|\SimpleXMLElement
     */
    public function getArticleById($icecatId, $lang='DE') {

        $icecatId   = trim($icecatId);
        $lang       = trim($lang);
        $url = $this->idEndpoint . "/$lang/$icecatId.xml";

        return $this->request($url, []);
    }

    public function isValidArticle($response)
    {
        if (isset($response->Product->attributes()->ErrorMessage)) {
            $code = isset($response->Product->attributes()->Code) ? (int)$response->Product->attributes()->Code : null;
            throw new IcecatException((string)$response->Product->attributes()->ErrorMessage, $code);
        }

        return true;
    }
}
