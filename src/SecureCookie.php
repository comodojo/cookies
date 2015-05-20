<?php namespace Comodojo\Cookies;

use \Comodojo\Cookies\CookieInterface\CookieInterface;
use \Comodojo\Exception\CookieException;
use \Comodojo\Cookies\CookieBase;

/**
 * AES-encrypted cookie
 * 
 * @package     Comodojo Spare Parts
 * @author      Marco Giovinazzi <info@comodojo.org>
 * @license     MIT
 *
 * LICENSE:
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

class SecureCookie extends CookieBase implements CookieInterface {

    /*
     * AES key
     *
     * @var int
     */
    private $key = null;

    /**
     * Secure cookie constructor
     *
     * Setup cookie name and key
     *
     * @param   string   $name
     *
     * @param   string   $key
     *
     * @throws \Comodojo\Exception\CookieException
     */
    public function __construct($name, $key) {

        if ( empty($key) OR !is_scalar($key) ) throw new CookieException("Invalid secret key");

        $this->key = $key;

        try {
            
            $this->setName($name);

        } catch (CookieException $ce) {
            
            throw $ce;

        }

        if ( defined("COMODOJO_COOKIE_MAX_SIZE") ) {

            $this->max_cookie_size = filter_var(COMODOJO_COOKIE_MAX_SIZE, FILTER_VALIDATE_INT, array(
                'options' => array(
                    'default' => 4000
                )
            ));

        }

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

        if ( !is_scalar($value) AND $serialize === false ) throw new CookieException("Cannot set non-scalar value without serialization");

        if ( $serialize === true ) $value = serialize($value);

        $cipher = new \Crypt_AES(CRYPT_AES_MODE_ECB);

        $cipher->setKeyLength(256);

        $cipher->setKey( self::clientSpecificKey($this->key) );

        $cookie_value = $cipher->encrypt($value);

        if ( strlen($cookie_value) > $this->max_cookie_size ) throw new CookieException("Cookie size larger than 4KB");

        $this->value = $cookie_value;

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

        $cipher = new \Crypt_AES(CRYPT_AES_MODE_ECB);

        $cipher->setKeyLength(256);

        $cipher->setKey( self::clientSpecificKey($this->key) );

        $cookie = $cipher->decrypt($this->value);

        if ( $cookie === false ) throw new CookieException("Cookie data cannot be dectypted");

        return ( $unserialize === true ) ? unserialize($cookie) : $cookie;

    }

    /**
     * Static method to create a cookie quickly
     *
     * @param   string   $name  The cookie name
     *
     * @param   string   $key
     * 
     * @param   array    $properties    Array of properties cookie should have
     *
     * @return  Object \Comodojo\Cookies\Cookie
     *
     * @throws  \Comodojo\Exception\CookieException
     */
    static public function create($name, $key, $properties=array(), $serialize=true) {

        try {

            $cookie = new SecureCookie($name, $key);

            self::cookieProperties($cookie, $properties, $serialize);

        } catch (CookieException $ce) {
            
            throw $ce;

        }

        return $cookie;

    }

    /**
     * Static method to get a cookie quickly
     *
     * @param   string   $name  The cookie name
     *
     * @param   string   $key
     *
     * @return  Object \Comodojo\Cookies\Cookie
     *
     * @throws  \Comodojo\Exception\CookieException
     */
    static public function retrieve($name, $key) {

        try {

            $cookie = new SecureCookie($name, $key);

            $return = $cookie->load();

        } catch (CookieException $ce) {
            
            throw $ce;

        }

        return $return;

    }

    /**
     * Create a client-specific key using provided key,
     * the client remote address and (in case) the value of
     * HTTP_X_FORWARDED_FOR header
     *
     * @param   string   $key
     *
     * @return  string
     */
    static private function clientSpecificKey($key) {

        $client_hash = md5($_SERVER['REMOTE_ADDR'] . ( isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : '' ), true);

        $server_hash = md5($key, true);

        return $client_hash . $server_hash;

    }

}