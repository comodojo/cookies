<?php namespace Comodojo\Cookies\Interface;

/**
 * Object cookie interface
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

interface CookieInterface {

    /**
     * Set cookie name
     *
     * @param   string  $cookieName    The cookie name
     *
     * @return  Object  $this
     */
    public function setName($cookieName);

    /**
     * Get cookie name
     *
     * @return  string
     */
    public function getName();

    /**
     * Set cookie content
     *
     * @param   integer $cookieValue
     *
     * @return  Object  $this
     */
    public function setValue($cookieValue);

    /**
     * Get cookie content
     *
     * @return  integer
     */
    public function getValue();

    /**
     * Set the time the cookie expires
     *
     * @param   string  $time
     *
     * @return  Object  $this
     */
    public function setExpire($time);

    /**
     * Get the time the cookie expires
     *
     * @return  string
     */
    public function getExpire();

    /**
     * Set cookie's path
     *
     * @param   string  $location
     *
     * @return  Object  $this
     */
    public function setPath($location);

    /**
     * Get cookie's path
     *
     * @return  string
     */
    public function getPath();

    /**
     * Set cookie's domain
     *
     * @param   string  $domain
     *
     * @return  ObjectRequest   $this
     */
    public function setDomain($domain);

    /**
     * Get cookie's domain
     *
     * @return  string
     */
    public function getDomain();

    /**
     * Set if the cookie should be transmitted only via https
     *
     * @param   bool  $mode
     */
    public function setSecure($header);

    /**
     * Get the cookie's secure mode
     *
     * @return bool
     */
    public function getSecure();

    /**
     * Set if cookie should be available only to HTTP protocol
     *
     * @return
     */
    public function setHttponly($mode);

    /**
     * Get cookie's httponly mode
     *
     * @return  bool
     */
    public function getHttponly();

    /**
     * Set cookie
     *
     */
    public function set();

    /**
     * Get cookie
     *
     * @return  strinng
     */
    public function get();

    /**
     * Delete cookie
     *
     * @return  bool
     */
    public function delete();

}