<?php

use Comodojo\Cookies\Cookies;

require '../vendor/autoload.php';

ob_start();

echo '<h1>Comodojo::Cookies tests - GET</h1>';

echo '<p>Getting plain cookie:</p>';

$result = Cookies::get();

echo '<pre style="color: green;"> '.$result.'</pre>';

echo '</p>';

echo '<p>Getting encrypted cookie:</p>';

$result = Cookies::get("comodojo_encrypted", "thisismyverycomplexpassword");

echo '<pre style="color: green;"> '.$result.'</pre>';

echo '<p>Getting array in plain cookie:</p>';

$result = Cookies::get("comodojo_array");

echo '<pre style="color: green;">';

var_export($result);

echo '</pre>';

echo '<p>Getting array in encrypted cookie:</p>';

$result = Cookies::get("comodojo_encrypted_array", "thisismyverycomplexpassword");

echo '<pre style="color: green;">';

var_export($result);

echo '</pre>';

echo '<p>Getting 10 seconds valid cookie:</p>';

$result = Cookies::get("comodojo_short_cookie");

echo '<pre style="color: green;">';

var_export($result);

echo '</pre>';

echo '<p>Getting invalid cookie</p>';

$result = Cookies::get("comodojo_fake_cookie");

echo '<pre style="color: red;">'. (is_null($result) ? 'NULL' : $result) .'</pre>';

ob_end_flush();
