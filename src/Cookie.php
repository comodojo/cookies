<?php namespace Comodojo\Cookies;

use \Comodojo\Cookies\CookieInterface\CookieInterface;
use \Comodojo\Exception\CookieException;

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
     * The cookie name
     *
     * @var string
     */
    private $name = null;

    /*
     * Cookie value (native string or serialized one)
     *
     * @var string
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

    /**
     * Cookie constructor
     *
     * Setup cookie name
     *
     * @param   string   $name
     *
     * @throws \Comodojo\Exception\CookieException
     */
    public function __construct($name) {

        try {

            $this->setName($name);
            
        } catch (CookieException $ce) {
            
            throw $ce;

        }

    }

    /**
     * Set cookie name
     *
     * @param   string  $cookieName    The cookie name
     *
     * @return  Object  $this
     *
     * @throws \Comodojo\Exception\CookieException
     */
    public function setName($name) {

        if ( empty($name) OR !is_scalar($name) ) throw new CookieException("Invalid cookie name");

        $this->name = $name;

        return $this;

    }

    /**
     * Get cookie name
     *
     * @return  string
     */
    public function getName() {

        return $this->name;

    }

    /**
     * Set cookie content
     *
     * @param   mixed   $cookieValue    Cookie content
     * @param   bool    $serialize      If true (default) cookie will be serialized first
     *
     * @return  Object  $this
     *
     * @throws \Comodojo\Exception\CookieException
     */
    public function setValue($value, $serialize=true) {

        if ( !is_scalar($value) AND $serialize !== true ) throw new CookieException("Cannot set non-scalar value without serialization");

        if ( $serialize === true ) $value = serialize($value);

        if ( strlen($value) > 4096 ) throw new CookieException("Cookie size larger than 4KB");

        $this->value = $value;

        return $this;

    }

    /**
     * Get cookie content
     *
     * @param   bool    $unserializes    If true (default) cookie will be unserialized first
     *
     * @return  mixed
     */
    public function getValue($unserialize=true) {

        return ( $unserialize === true ) ? unserialize($this->value) : $this->value;

    }

    /**
     * Set cookie's expiration time
     *
     * @param   int     $timestamp
     *
     * @return  Object  $this
     *
     * @throws \Comodojo\Exception\CookieException
     */
    public function setExpire($timestamp) {

        if ( !is_int($timestamp) ) throw new CookieException("Invalud cookie's expiration time");

        $this->expire = $timestamp;

        return $this;

    }

    /**
     * Get the time the cookie will expire
     *
     * @return  integer
     */
    public function getExpire() {

        return $this->expire;

    }

    /**
     * Set cookie's path
     *
     * @param   string  $location
     *
     * @return  Object  $this
     *
     * @throws \Comodojo\Exception\CookieException
     */
    public function setPath($location) {

        if ( !is_string($location) ) throw new CookieException("Invalid path attribute for a cookie");
        
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
     * @return  Object   $this
     *
     * @throws \Comodojo\Exception\CookieException
     */
    public function setDomain($domain) {

        if ( !filter_var($domain, FILTER_VALIDATE_URL) ) throw new CookieException("Invalid domain attribute for a cookie");

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

    /**
     * Set cookie
     *
     * @return bool
     *
     * @throws \Comodojo\Exception\CookieException
     */
    public function set() {

        if ( setcookie(
            $this->name,
            $this->value,
            $this->expire,
            $this->path,
            $this->domain,
            $this->secure,
            $this->httponly
        ) === false ) throw new CookieException("Cannot set cookie: ".$this->name);

        return true;

    }

    /**
     * Get cookie content from request
     *
     * Other parameters (like expire time) will be erased if cookie exists
     *
     * @return Object $this
     *
     * @throws \Comodojo\Exception\CookieException
     */
    public function get() {

        if ( !isset($_COOKIE[$this->name]) ) throw new CookieException("Cookie cannot be found");

        $this->setValue( $_COOKIE[$this->name] );

        return $this;

    }

    public function delete() {

        if ( setcookie(
            $this->name,
            null,
            time() - 86400,
            null,
            null,
            $this->secure,
            $this->httponly
        ) === false ) throw new CookieException("Cannot delete cookie: ".$this->name);

        return true;

    }

    /**
     * Check if cookie exists
     *
     * @return  bool
     */
    public function exists() {

        reutrn isset( $_COOKIE[$this->name] );

    }

    static public function setCookie($name, $properties=array()) {

        try {

            $cookie = new Cookie($name);

            self::cookieProperties($cookie, $properties);
            
            $value = $cookie->set();

        } catch (CookieException $ce) {
            
            throw new $ce;

        }

        return $value;

    }

    static public function getCookie($name) {

        try {

            $cookie = new Cookie($name);
            
            $value = $cookie->get();

        } catch (CookieException $ce) {
            
            throw new $ce;

        }

        return $value;

    }

    static public function deleteCookie($name) {

        try {

            $cookie = new Cookie($name);
            
            $value = $cookie->delete();

        } catch (CookieException $ce) {
            
            throw new $ce;

        }

        return $value;

    }

    static protected function cookieProperties(\Comodojo\Cookies\CookieInterface\CookieInterface $cookie, $properties) {

        foreach ($properties as $property => $value) {
                
            switch ($property) {

                case 'value':
                    
                    $cookie->setValue($value);

                    break;

                case 'expire':

                    $cookie->setExpire($value);

                    break;

                case 'path':

                    $cookie->setPath($value);

                    break;

                case 'domain':

                    $cookie->setDomain($value);

                    break;

                case 'secure':

                    $cookie->setSecure($value);

                    break;

                case 'httponly':

                    $cookie->setHttponly($value);

                    break;

            }

        }

        return $cookie;

    }

}
