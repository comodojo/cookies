.. _cookie-types:

Cookie types
============

Plain cookie
------------

Plain cookies are just an OO implementation of standard cookies. As an option, cookie content can be serialized on the client side.

.. code-block:: php
   :linenos:

    <?php

    use \Comodojo\Cookies\Cookie;

    // create a new cookie instance with m-size of approximately 3k
    $cookie = new Cookie('my-cookie');

Encrypted cookie
----------------

The class `\\Comodojo\\Cookies\\EncryptedCookie` provides an extension of plain cookie in which cookie content is encrypted using a 256bit AES key, that should be provided to class contructor.

To setup a EncryptedCookie:

.. code-block:: php
   :linenos:

    <?php

    use \Comodojo\Cookies\EncryptedCookie;

    // create a new cookie instance with m-size of approximately 3k
    $cookie = new EncryptedCookie('my-cookie', 'my-super-secret-key');

Secure cookie
-------------

The class `\\Comodojo\\Cookies\\SecureCookie` provides an extension of Encrypted Cookie to ensure a minimum protection from cookie spoofing.

The crypto key is calculated using both user defined secret and *IP informations* from `$_SERVER` superglobal (if available).

This can be useful in internal networks or where clients does not often change IP address.

To setup a SecureCookie:

.. code-block:: php
   :linenos:

    <?php

    use \Comodojo\Cookies\SecureCookie;

    // create a new cookie instance with m-size of approximately 3k
    $cookie = new SecureCookie('my-cookie', 'my-super-secret-key');

Extending
---------

A custom cookie can be easily created implementing the `\\Comodojo\\Cookies\\CookieInterface` interface.

Additionally, the abstract class `\\Comodojo\\Cookies\\AbstractCookie` can be used to reuse common cookie methods.
