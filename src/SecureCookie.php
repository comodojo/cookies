<?php namespace Comodojo\Cookies;

use \Comodojo\Cookies\Cookie;
use \Comodojo\Exception\CookieException;
use \Comodojo\Cookies\CookieInterface\CookieInterface;

/**
 * Plain cookie
 * 
 * @package     Comodojo Spare Parts
 * @author      Marco Giovinazzi <info@comodojo.org>
 * @license     GPL-3.0+
 *
 * LICENSE:
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

class SecureCookie extends Cookie implements CookieInterface {

	private $key = null;

	public function __construct($name, $key) {

		if ( empty($key) OR !is_scalar($key) ) throw new CookieException("Invalid secret key");

		$this->key = $key;

		try {
			
			parent::__construct($name);

		} catch (CookieException $ce) {
			
			throw $ce;

		}

	}

	public function setValue($value, $serialize=true) {

        if ( $serialize === true ) $value = serialize($value);

        $cipher = new \Crypt_AES(CRYPT_AES_MODE_ECB);

        $cipher->setKeyLength(256);

        $cipher->setKey( self::clientSpecificKey($this->key) );

        $value = $cipher->encrypt($value);

        return parent::setValue($value, false);

    }

    public function getValue($unserialize = true) {

    	$cipher = new \Crypt_AES(CRYPT_AES_MODE_ECB);

        $cipher->setKeyLength(256);

        $cipher->setKey( self::clientSpecificKey($this->key) );

        $cookie = $cipher->decrypt($this->value);

        if ( $cookie === false ) throw new CookieException("Cookie data cannot be dectypted");

        return ( $unserialize === true ) ? unserialize($cookie) : $cookie;

    }

    static public function setCookie($name, $properties=array(), $key) {

    	try {

            $cookie = new SecureCookie($name, $key);

            self::cookieProperties($cookie, $properties);
            
            $value = $cookie->set();

        } catch (CookieException $ce) {
            
            throw new $ce;

        }

        return $value;

    }

    static public function getCookie($name, $key) {

    	try {

            $cookie = new SecureCookie($name, $key);
            
            $value = $cookie->get();

        } catch (CookieException $ce) {
            
            throw new $ce;

        }

        return $value;

    }

	static private function clientSpecificKey($key) {

        $client_hash = md5($_SERVER['REMOTE_ADDR'] . ( isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : '' ), true);

        $server_hash = md5($key, true);

        return $client_hash . $server_hash;

    }

}