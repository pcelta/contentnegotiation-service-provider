# Content Negotiation Service Provider
[![Build Status](https://img.shields.io/travis/dafiti/contentnegotiation-service-provider/master.svg?style=flat-square)](https://travis-ci.org/dafiti/contentnegotiation-service-provider)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/dafiti/contentnegotiation-service-provider/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/dafiti/contentnegotiation-service-provider/?branch=master)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/dafiti/contentnegotiation-service-provider/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/dafiti/contentnegotiation-service-provider/?branch=master)
[![HHVM](https://img.shields.io/hhvm/dafiti/contentnegotiation-service-provider.svg)](https://travis-ci.org/dafiti/contentnegotiation-service-provider)
[![Latest Stable Version](https://img.shields.io/packagist/v/dafiti/contentnegotiation-service-provider.svg?style=flat-square)](https://packagist.org/packages/dafiti/contentnegotiation-service-provider)
[![Total Downloads](https://img.shields.io/packagist/dt/dafiti/contentnegotiation-service-provider.svg?style=flat-square)](https://packagist.org/packages/dafiti/contentnegotiation-service-provider)
[![License](https://img.shields.io/packagist/l/dafiti/contentnegotiation-service-provider.svg?style=flat-square)](https://packagist.org/packages/dafiti/contentnegotiation-service-provider)

A [Silex](https://github.com/silexphp/Silex) Service Provider for [Simple Content Negotiation](http://www.w3.org/Protocols/rfc2616/rfc2616-sec12.html).

## Instalation
The package is available on [Packagist](http://packagist.org/packages/dafiti/contentnegotiation-service-provider).
Autoloading is [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md) compatible.

```json
{
    "require": {
        "dafiti/contentnegotiation-service-provider": "dev-master"
    }
}
```


## Usage

```php
use Silex\Application;
use Dafiti\Silex\ContentNegotiationServiceProvider;

$config = [    
    'available_accepts' => [
        'application/json',
        'application/xml'
    ],
    'default_accept'    => 'application/json'
];

$app = new Application();
$app->register(new ContentNegotiationServiceProvider($config));

$app->get("/your-endpoint", function() {
    $data = ["you data to response"];
    
    return new \Dafiti\Silex\Response($data);
});

```



### Request Examples:

----------------------------------------------
----------------------------------------------

#### Request

##### HTTP GET
##### Header: Accept: application/json
##### URL: http://baseurl.com/your-endpoint

----------------------------------------------

####Response

##### Response Header: Content-Type: application/json
##### Status Code: 200
##### Body:
```json
{
    "you data to response"
}
```

----------------------------------------------
----------------------------------------------


####Request

##### HTTP GET
##### Header: Accept: text/html
##### URL: http://baseurl.com/your-endpoint

----------------------------------------------

#### Response

##### Response Header: Content-Type: application/json
##### Status Code: 406
##### Body:
```json
{
    "message":"Accept Type Not Acceptable"
}
```

----------------------------------------------

## License

MIT License
