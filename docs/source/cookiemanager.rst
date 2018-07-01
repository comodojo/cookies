Cookie Manager
==============

Cookie manager is a class that can handle multiple cookies at the same time.

Each managed cookie object must implement the `\\Comodojo\\Cookies\\CookieInterface`.

Saving multiple cookies
-----------------------

.. code-block:: php
   :linenos:

    <?php

    use \Comodojo\Cookies\Cookie;
    use \Comodojo\Cookies\CookieManager;

    // create two different cookies
    $first_cookie = new Cookie('first_cookie');
    $second_cookie = new Cookie('second_cookie');

    // init the manager
    $manager = new CookieManager();

    // add cookies to the manager
    $manager
        ->add($first_cookie)
        ->add($second_cookie);

    // save them all
    $result = $manager->save();

Loading multiple cookies
------------------------

.. code-block:: php
   :linenos:

    <?php

    use \Comodojo\Cookies\Cookie;
    use \Comodojo\Cookies\CookieManager;

    // create two different cookies
    $first_cookie = new Cookie('first_cookie');
    $second_cookie = new Cookie('second_cookie');

    // init the manager
    $manager = new CookieManager();

    // add cookies to the manager
    $manager
        ->add($first_cookie)
        ->add($second_cookie);

    // load cookies and retrieve contents
    $result = $manager->load()->getValues();
