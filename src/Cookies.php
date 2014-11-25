<?php namespace Comodojo\Cookies;

use \Comodojo\Exception\CookiesException;

/**
 * Plain and secure (AES) simple cookies
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

class Cookies {

    /**
     * Default static content for cookie
     *
     * @var array
     */
    static private $data = array(
        "name"      =>  "comodojo_cookie",
        "value"     =>  null,
        "expire"    =>  null,
        "path"      =>  null,
        "domain"    =>  null,
        "secure"    =>  false,
        "httponly"  =>  false
    );

    static public function set($cookie, $key=null) {

        $cookie_parameters = is_array($cookie) ? array_replace(self::$data, $cookie) : array_replace(self::$data, array('value' => $cookie) );

        if ( !is_null($key) ) {

            $cipher = new \Crypt_AES(CRYPT_AES_MODE_ECB);

            $cipher->setPassword($key);

            $cookie_parameters['value'] = $cipher->encrypt( serialize($cookie_parameters['value']) );

        } else {

            $cookie_parameters['value'] = serialize($cookie_parameters['value']);

        }

        return self::setCookie($cookie_parameters);

    }

    static public function get($name=null, $key=null) {

        $cookie = self::getCookie( is_null($name) ? self::$data['name'] : $name );

        if ( !is_null($key) AND !is_null($cookie) ) {

            $cipher = new \Crypt_AES(CRYPT_AES_MODE_ECB);

            $cipher->setPassword($key);

            $cookie = $cipher->decrypt($cookie);

        }

        return is_null($cookie) ? null : unserialize($cookie);

    }

    static public function delete($cookie=null) {

        $cookie_parameters = is_array($cookie) ? array_replace(self::$data, $cookie) : array_replace(self::$data, array('value' => $cookie) );

        $cookie_parameters['expire'] = time() - 86400;

        return self::setCookie($cookie_parameters);

    }

    static private function setCookie($cookie) {

        if ( strlen($cookie["value"]) > 4096 ) throw new CookiesException("Cookie data size is larger than 4KB");
        
        return setcookie(
            $cookie["name"],
            $cookie["value"],
            $cookie["expire"],
            $cookie["path"],
            $cookie["domain"],
            $cookie["secure"],
            $cookie["httponly"]
        );

    }

    static private function getCookie($name) {
        
        if ( isset($_COOKIE[$name]) ) return $_COOKIE[$name];

        else return null;

    }

}