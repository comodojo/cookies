## comodojo/cookies

[![Build Status](https://api.travis-ci.org/comodojo/cookies.png)](http://travis-ci.org/comodojo/cookies) [![Latest Stable Version](https://poser.pugx.org/comodojo/cookies/v/stable)](https://packagist.org/packages/comodojo/cookies) [![Total Downloads](https://poser.pugx.org/comodojo/cookies/downloads)](https://packagist.org/packages/comodojo/cookies) [![Latest Unstable Version](https://poser.pugx.org/comodojo/cookies/v/unstable)](https://packagist.org/packages/comodojo/cookies) [![License](https://poser.pugx.org/comodojo/cookies/license)](https://packagist.org/packages/comodojo/cookies)

Minimalist and extensible library to manage cookies

## Introduction

This library provides methods to manage different kind of cookies as well a manager class to set/get multiple cookies.

It could be easily extended defining a custom cookie class that implements the `` \Comodojo\Cookies\CookieInterface\CookieInterface `` interface.

## Installation

Install [composer](https://getcomposer.org/), then:

`` composer require comodojo/cookies 1.0.* ``

## Plain cookies

To setup a cookie:

```php

// create an instance of \Comodojo\Cookies\Cookie
$cookie = new \Comodojo\Cookies\Cookie('my_cookie');

// Set cookie's properties (optional) then save it
$result = $cookie->setValue( "Lorem ipsum dolor" )
                 ->setExpire( time()+3600 )
                 ->setPath( "/myapp" )
                 ->setDomain( "example.com" )
                 ->setSecure()
                 ->setHttponly()
                 ->save();

```

Alternatively, use the static method `` Cookie::create() `` (parameters are optional):

```php

// define a new cookie
$cookie = Cookie::create('my_cookie', array(
    'value'   => 'cookie-2'
    'value'   => "Lorem ipsum dolor"
    'expire'  => time()+3600
    'path'    => "/myapp"
    'domain'  => "example.com"
    'secure'  => true
    'httponly'=> true
    )
);

// save it
$result = $cookie->save();

```

## Secure cookies

The class `` \Comodojo\Cookies\SecureCookie `` provides an extension of plain cookie in which:

- Cookie content is encrypted using a 256bit AES key
- Key should be provided to class contructor
- To ensure a minimum protection from cookie spoofing, the crypto key is calculated using both user defined secret and IP informations from S_SERVER superglobal

To setup a SecureCookie:

```php

// create an instance of \Comodojo\Cookies\SecureCookie
$cookie = new \Comodojo\Cookies\SecureCookie('my_secure_cookie', 'myverycomplexsecretkey');

// Set cookie's properties (optional) then save it
$result = $cookie->setValue( "Lorem ipsum dolor" )
                 ->setExpire( time()+3600 )
                 ->setPath( "/myapp" )
                 ->setDomain( "example.com" )
                 ->setSecure()
                 ->setHttponly()
                 ->save();

```

Alternatively, use the static method `` SecureCookie::create() `` (parameters are optional):

```php

// define a new cookie
$cookie = SecureCookie::create('my_secure_cookie', 'myverycomplexsecretkey', array(
    'value'   => 'cookie-2'
    'value'   => "Lorem ipsum dolor"
    'expire'  => time()+3600
    'path'    => "/myapp"
    'domain'  => "example.com"
    'secure'  => true
    'httponly'=> true
    )
);

// save it
$result = $cookie->save();

```

## CookieManager

Cookie manager is a class that accepts objects that implement the `` \Comodojo\Cookies\CookieInterface\CookieInterface `` and provides methods to manage multiple cookies at a time.

For example, to save multiple cookies:

```php

// init a new cookie manager
$manager = new \Comodojo\Cookies\CookieManager();

// register a Cookie
$manager->register( Cookie::create('cookie_1',array('value'=>'cookie-1')) );

// register a SecureCookie
$manager->register( SecureCookie::create('cookie_2',"thisismyverycomplexpassword",array('value'=>'cookie-2')) );

// save them all
$result = $manager->save();

```

To get multiple cookies:

```php

// init a new cookie manager
$manager = new \Comodojo\Cookies\CookieManager();

// register a Cookie
$manager->register( Cookie::create('cookie_1') );

// register a SecureCookie
$manager->register( SecureCookie::create('cookie_2',"thisismyverycomplexpassword") );

// get them all
$result = $manager->load()->getValues();

```

## Notes

- By default, cookie content is serialized; this behaviour can be changed using last (optional) parameter of `` setValue() ``, `` getValue() `` and `` create() `` methods.

- This library DOES NOT implement the [RFC 6896 KoanLogic's Secure Cookie Sessions for HTTP](https://tools.ietf.org/html/rfc6896).

- For compatibility reasons, the max cookie lenght is limited to 4000 chars; this parameter could be modified defining the constant `` COMODOJO_COOKIE_MAX_SIZE ``.

- The maximum size of cookie can be <4KB due to serialization and (in case) encryption. In case of cookie > 4KB, a `` \Comodojo\Exception\CookieException `` is raised.
