<?php

namespace Comodojo\Cookies\Tests\Utils;

class Request {

	public static function send(string $url, string $cookieJar, bool $loadCookies = false)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_PORT, 8000);
        if ($loadCookies) {
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);    
        } else {
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,  1);

        $request = curl_exec($ch);
        $result = json_decode($request, true);

        curl_close($ch);
		return $result;
    }
}

