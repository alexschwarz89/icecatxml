icecatxml
============

An easy-to-use PHP library to access product data provided by Icecat.

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
