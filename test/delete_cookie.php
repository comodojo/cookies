<?php

use Comodojo\Cookies\Cookies;

require '../vendor/autoload.php';

ob_start();

echo '<h1>Comodojo::Cookies tests - DELETE</h1>';

echo '<p>Deleting all cookies...';

Cookies::delete();

Cookies::delete(array("name" => "comodojo_encrypted"));

Cookies::delete(array("name" => "comodojo_array"));

Cookies::delete(array("name" => "comodojo_encrypted_array"));

echo '<span style="color: green;"> done!</span>';

ob_end_flush();