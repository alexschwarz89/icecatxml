<?php

namespace Alexschwarz89\IcecatXML;
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
    protected $apiBaseUrl = 'https://data.icecat.biz/xml_s3/xml_server3.cgi';
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
    protected function request($params)
    {
        try {
            $response = $this->guzzle->get(null,
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
    public function getArticleByEAN($ean)
    {
        $params = array('ean_upc' => $ean);

        return $this->request($params);
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

        return $this->request($params);
    }
}