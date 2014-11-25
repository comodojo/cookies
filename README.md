comodojo/cookies
================

This small library provides simple, static methods to manage plain or encrypted cookies.

It's content agnositc: values are serialized before becoming a cookie, so set method accepts arrays, strings, objects, ...

In case of encrypted cookies, a minimum protection from cookie spoofing is made by composing the crypto key using both a user defined secret and IP informations from S_SERVER superglobal.

## Usage

### Setup cookies

	```php

	// Plain cookie: no encryption and predefined name (comodojo_cookie)
	$plain_cookie = Cookies::set("Lorem ipsum dolor sit amet...");

	// Plain cookie with extra parameters
	$plain_extra = Cookies::set( array(
		"name"  => "comodojo_plain_extra_cookie",
		"value" => "Lorem ipsum dolor sit amet",
		"expire"=> time() + 3600
	));

	// Encrypted cookie with predefined name (comodojo_cookie)
	$encrypted_cookie = Cookies::set("Lorem ipsum dolor sit amet...", "thisismyverycomplexpassword");

	// Encrypted cookie with extra parameters
	$encrypted_extra = Cookies::set( array(
		"name"  => "comodojo_encrypted_extra_cookie",
		"value" => "Lorem ipsum dolor sit amet",
		"expire"=> time() + 3600
	), "thisismyverycomplexpassword");

	// Storing an array
	$plain_cookie = Cookies::set( array(
		"name"  => "comodojo_array_in_cookie",
		"value" => array(
			"sed", 
			"aliqua", 
			"mentor", 
			"partum", 
			"differo"
		)
	));

	```

### Retrieving cookies

	```php

	// Plain cookie with predefined name (comodojo_cookie)
	$plain_cookie = Cookies::get();

	// Plain cookie with custom name
	$plain_cookie_custom_name = Cookies::get("my_cookie");

	// Encrypted cookie
	$encrypted_cookie = Cookies::get("comodojo_encrypted", "thisismyverycomplexpassword");

	```

### Deleting cookies

	```php

	// Cookie with predefined name (comodojo_cookie)
	Cookies::delete();

	// Cookie with custom name
	Cookies::delete("comodojo_encrypted");

	// Cookie with custom parameters
	Cookies::delete( array(
		"name"	=> "comodojo_encrypted",
		"domain"=> "example.org"
	));

	```

## Notes

- This library DOES NOT implement the [RFC 6896 KoanLogic's Secure Cookie Sessions for HTTP](https://tools.ietf.org/html/rfc6896).

- The maximum size of cookie is <4KB due to serialization and (in case) encryption.