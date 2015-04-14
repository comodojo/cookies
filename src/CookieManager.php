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

class CookieManager {

	private $cookies = array();

	public function register(CookieInterface $cookie) {

		$this->cookies[$cookie->getName()] = $cookie;

		return $this;

	}

	public function unregister(CookieInterface $cookie) {

		if ( $this->exists($cookie->getName()) ) {

			unset($this->cookies[$cookie->getName()]);

			return true;

		}

		else return false;

	}

	public function exists($cookieName) {

		return array_key_exists($cookie->getName(), $this->cookies);

	}

	public function get($cookieName) {

		if ( $this->exists($cookieName) ) return $this->cookies[$cookieName];

		else throw new CookieException("Cookie ".$cookieName." is not registered");

	}

	public function set($cookies=null) {

		foreach ($this->cookies as $name => $cookie) {
			
			try {
				
				$cookie->set()
				
			} catch (CookieException $ce) {
				
				throw $ce;

			}

		}

	}

}