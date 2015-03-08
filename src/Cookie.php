<?php namespace Comodojo\Cookies;

use Comodojo\Cookies\Interface\CookieInterface;
use \Comodojo\Exception\CookiesException;

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

class Cookie implements CookieInterface {

    /*
     *
     * @var
     */
    private $name = null;

    /*
     *
     * @var
     */
    private $value = null;

    /*
     *
     * @var
     */
    private $expire = null;

    /*
     *
     * @var
     */
    private $path = null;

    /*
     *
     * @var
     */
    private $domain = null;

    /*
     *
     * @var
     */
    private $secure = false;

    /*
     *
     * @var
     */
    private $httponly = false;

    public function __construct($name) {

        try {

            $this->setName($name);
            
        } catch (CookiesException $ce) {
            
            throw $ce;

        }

    }

    public function setName($name) {

        if ( empty($name) OR !is_scalar($name) ) throw new CookiesException("Invalid cookie name");

        $this->name = $name;

        return $this;

    }

    public function getName() {

        return $this->name;

    }

    public function setValue($value, $serialize=true) {

        if ( $serialize === true ) $value = serialize($value);

        if ( strlen($value) > 4096 ) throw new CookiesException("Cookie data size is larger than 4KB");

        $this->value = $value;

        return $this;

    }

    public function getValue($unserialize=true) {

        return ( $unserialize === true ) ? unserialize($this->value) : $this->value;

    }

    public function setExpire($timestamp) {

        $this->expire = $timestamp;

        return $this;

    }

    public function getExpire() {

        return $this->expire;

    }

    /**
     * Set cookie's path
     *
     * @param   string  $location
     *
     * @return  Object  $this
     */
    public function setPath($location) {

        if ( !is_string($location) ) throw new CookiesException("Invalid path attribute for a cookie");
        
        $this->path = $path;

        return $this;

    }

    /**
     * Get cookie's path
     *
     * @return  string
     */
    public function getPath() {

        return $this->path;

    }

    /**
     * Set cookie's domain
     *
     * @param   string  $domain
     *
     * @return  ObjectRequest   $this
     */
    public function setDomain($domain) {

        if ( !filter_var($domain, FILTER_VALIDATE_URL) ) throw new CookiesException("Invalid domain attribute for a cookie");

        $this->domain = $domain;

        return $this;

    }

    /**
     * Get cookie's domain
     *
     * @return  string
     */
    public function getDomain() {

        return $this->domain;

    }

    /**
     * Set if the cookie should be transmitted only via https
     *
     * @param   bool  $mode
     */
    public function setSecure($mode) {

        $this->secure = filter_var($mode, FILTER_VALIDATE_BOOLEAN);

        return $this;

    }

    /**
     * Get the cookie's secure mode
     *
     * @return bool
     */
    public function getSecure() {

        return $this->secure;

    }

    /**
     * Set if cookie should be available only to HTTP protocol
     *
     * @return
     */
    public function setHttponly($mode) {

        $this->httponly = filter_var($mode, FILTER_VALIDATE_BOOLEAN);

        return $this;

    }

    /**
     * Get cookie's httponly mode
     *
     * @return  bool
     */
    public function getHttponly() {

        return $this->httponly;

    }


    public function set() {

        return setcookie(
            $this->name,
            $this->value,
            $this->expire,
            $this->path,
            $this->domain,
            $this->secure,
            $this->httponly
        );

    }

    public function get() {

        if ( isset($_COOKIE[$this->name]) ) return $_COOKIE[$this->name];

        else return null;

    }

    public function delete() {

        return setcookie(
            $this->name,
            null,
            time() - 86400,
            null,
            null,
            $this->secure,
            $this->httponly
        );

    }

    static public function set($name, $properties) {

        try {

            $cookie = new Cookie($name);
            
            $value = $cookie->get();

        } catch (CookiesException $ce) {
            
            throw new $ce;

        }

    }

    static public function get($name) {

        try {

            $cookie = new Cookie($name);
            
            $value = $cookie->get();

        } catch (CookiesException $ce) {
            
            throw new $ce;

        }

        return $value;

    }

    static public function delete($name) {

        try {

            $cookie = new Cookie($name);
            
            $value = $cookie->delete();

        } catch (CookiesException $ce) {
            
            throw new $ce;

        }

        return $value;

    }

}
