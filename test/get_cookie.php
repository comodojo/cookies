<?php

use Comodojo\Cookies\Cookies;

require '../vendor/autoload.php';

ob_start();


echo '<h1>Comodojo::Cookies tests - GET</h1>';

echo '<p>Getting plain cookie:</p>';

try {

	$result = Cookies::get(); 
	
	echo '<pre style="color: green;">';

	var_export($result);

	echo '</pre>';

} catch (\Exception $e) {

	echo '<pre style="color: red;">'.$e->getMessage().'</pre>'; 

}


echo '<p>Getting encrypted cookie:</p>';

try { 

	$result = Cookies::get("comodojo_encrypted", "thisismyverycomplexpassword"); 

	echo '<pre style="color: green;">';

	var_export($result);

	echo '</pre>';

} catch (\Exception $e) { 

	echo '<pre style="color: red;">'.$e->getMessage().'</pre>';

}


echo '<p>Getting array in plain cookie:</p>';

try { 

	$result = Cookies::get("comodojo_array"); 

	echo '<pre style="color: green;">';

	var_export($result);

	echo '</pre>';

} catch (\Exception $e) { 

	echo '<pre style="color: red;">'.$e->getMessage().'</pre>';

}


echo '<p>Getting array in encrypted cookie:</p>';

try { 

	$result = Cookies::get("comodojo_encrypted_array", "thisismyverycomplexpassword"); 

		echo '<pre style="color: green;">';

	var_export($result);

	echo '</pre>';

} catch (\Exception $e) { 

	echo '<pre style="color: red;">'.$e->getMessage().'</pre>';

}


echo '<p>Getting 10 seconds valid cookie:</p>';

try { 

	$result = Cookies::get("comodojo_short_cookie"); 

	echo '<pre style="color: green;">';

	var_export($result);

	echo '</pre>';

} catch (\Exception $e) { 

	echo '<pre style="color: red;">'.$e->getMessage().'</pre>';

}


echo '<p>Getting invalid cookie</p>';

try {

	$result = Cookies::get("comodojo_fake_cookie"); 

	echo '<pre style="color: green;">'. (is_null($result) ? 'NULL' : $result) .'</pre>';

}
catch (\Exception $e) { 

	echo '<pre style="color: red;">'.$e->getMessage().'</pre>';

}

ob_end_flush();
