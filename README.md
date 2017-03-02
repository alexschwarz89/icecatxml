[![SensioLabsInsight](https://insight.sensiolabs.com/projects/bdc4649b-7a9c-42ab-9e23-ac49f683af00/mini.png)](https://insight.sensiolabs.com/projects/bdc4649b-7a9c-42ab-9e23-ac49f683af00)

icecatxml
============

An easy-to-use Wrapper for the Ieceat API to access product data provided by Icecat. 
It should be compatible from PHP 5.3.3+

## Install

Install via [composer](https://getcomposer.org):

```javascript
{
    "require": {
        "alexschwarz89/icecatxml"
    }
}
```

Run `composer install`.

## Example usage

#### Get product data with EAN/UPC

```php
use Alexschwarz89\IcecatXML\Api;
$icecat = new Api('ACCOUNT_USERNAME', 'ACCOUNT_PASSWORD');
$xml = $icecat->getArticleByEAN('EAN');
```

#### Get product data by vendor name and MPN

```php
use Alexschwarz89\IcecatXML\Api;
$icecat = new Api('ACCOUNT_USERNAME', 'ACCOUNT_PASSWORD');
$xml = $icecat->getArticleByMPN('ExampleVendor', 'AA12345');
```

#### Get product data by Icecat ID

```php
use Alexschwarz89\IcecatXML\Api;
$icecat = new Api('ACCOUNT_USERNAME', 'ACCOUNT_PASSWORD');
$xml = $icecat->getArticleById('27260205');
```

### Specifying the language (optional)
The default langauge is "DE", to change this, set the optional parameter $lang, e.g.

```php
use Alexschwarz89\IcecatXML\Api;
$icecat = new Api('ACCOUNT_USERNAME', 'ACCOUNT_PASSWORD');
$xml = $icecat->getArticleById('27260205', 'US');
```

