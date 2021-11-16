General Usage
=============

.. _this site: http://browsercookielimits.squawky.net/
.. _rfc6265: https://tools.ietf.org/html/rfc6265#section-6.1

Creating a new cookie
---------------------

A cookie can be defined creating a new instance of `Comodojo\\Cookies\\Cookie`, or one of the other :ref:`cookie-types`.

Once defined, additional methods can be used to set/get cookie properties, but cookie is just a server-side object.

Nothing is passed to the client until the `Cookie::save()` method is invoked.

.. code-block:: php
   :linenos:

    <?php

    use \Comodojo\Cookies\Cookie;

    // create a new cookie instance
    $cookie = new Cookie('my-cookie');

    // set cookie's properties
    $cookie->setValue( "Lorem ipsum dolor" )
        ->setExpire( time()+3600 )
        ->setPath( "/myapp" )
        ->setDomain( "example.com" )
        ->setSecure()
        ->setHttponly();

    // persist the cookie
    $result = $cookie->save();

Alternatively, the static constructor `Cookie::create` is available to quikly create a cookie.

.. code-block:: php
   :linenos:

    <?php

    use \Comodojo\Cookies\Cookie;

    // define a new cookie
    $cookie = Cookie::create('my_cookie', array(
        'value' => "Lorem ipsum dolor"
        'expire' => time()+3600
        'path' => "/myapp"
        'domain' => "example.com"
        'secure' => true
        'httponly' => true
        )
    );

    // persist the cookie
    $result = $cookie->save();

Loading a cookie
----------------

An existent cookie can be easily loaded using the `Cookie::load()` method.

.. code-block:: php
   :linenos:

    <?php

    use \Comodojo\Cookies\Cookie;

    // create a new cookie instance
    $cookie = new Cookie('my-cookie');

    // load cookie
    $cookie->load();

    // read the cookie value
    $value = $cookie->getValue();

The static constructor `Cookie::retrieve` can be used to speed up operation.

.. code-block:: php
   :linenos:

    <?php

    use \Comodojo\Cookies\Cookie;

    // create a new cookie instance
    $cookie = Cookie::retrieve('my-cookie');

    // read the cookie value
    $value = $cookie->getValue();

Cookie size
-----------

By default maximum allowed lenght for a cookie is 4000 bytes, to allow it to work in all major browsers.

.. note:: General informations about cookie limits is available in the `rfc6265`_. See also `this site`_ for more informations.

Maximum cookie size can be overridden when creating a cookie.

.. code-block:: php
   :linenos:

    <?php

    use \Comodojo\Cookies\Cookie;

    // create a new cookie instance with m-size of approximately 3k
    $cookie = new Cookie('my-cookie', 3000);

.. note:: The real available size of cookie can <4KB due to serialization and (in case) encryption. In case of cookie > 4KB, a `\\Comodojo\\Exception\\CookieException` is raised.
