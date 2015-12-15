<?php

require __DIR__ . '/../vendor/autoload.php';

use Alexschwarz89\IcecatXML\Api;

$icecat = new Api('ACCOUNT_USERNAME', 'ACCOUNT_PASSWORD');

/* @var SimpleXMLElement $xml */

/*
 * Get Article data by vendor name and (Manufacturer Part Number)
 */
$xml = $icecat->getArticleByMPN('Samsung', 'RL38ECPS');

/*
 * Get Article data by EAN/UPC
 */
$xml = $icecat->getArticleByEAN('0887276007144');
