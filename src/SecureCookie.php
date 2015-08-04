<?php namespace Comodojo\Cookies;

use \Comodojo\Cookies\CookieInterface\CookieInterface;
use \Comodojo\Exception\CookieException;
use \Comodojo\Cookies\CookieBase;

/**
 * AES-encrypted cookie
 * 
 * @package     Comodojo Spare Parts
 * @author      Marco Giovinazzi <marco.giovinazzi@comodojo.org>
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
     * @param   mixed   $value      Cookie content
     * @param   bool    $serialize  If true (default) cookie will be serialized first
     *
     * @return  \Comodojo\Cookies\SecureCookie
     *
     * @throws  \Comodojo\Exception\CookieException
     */
    public function setValue($value, $serialize=true) {

        if ( !is_scalar($value) AND $serialize === false ) throw new CookieException("Cannot set non-scalar value without serialization");

        if ( $serialize === true ) $value = serialize($value);

        $cipher = new \Crypt_AES(CRYPT_AES_MODE_ECB);

        $cipher->setKeyLength(256);

        $cipher->setKey( self::clientSpecificKey($this->key) );

        // added base64 encoding to avoid problems with binary data

        $encrypted_value = $cipher->encrypt($value);

        $cookie_value = base64_encode($encrypted_value);

        if ( strlen($cookie_value) > $this->max_cookie_size ) throw new CookieException("Cookie size larger than 4KB");

        $this->value = $cookie_value;

        return $this;

    }

    /**
     * Get cookie content
     *
     * @param   bool    $unserialize    If true (default) cookie will be unserialized first
     *
     * @return  mixed
     */
    public function getValue($unserialize=true) {

        $cipher = new \Crypt_AES(CRYPT_AES_MODE_ECB);

        $cipher->setKeyLength(256);

        $cipher->setKey( self::clientSpecificKey($this->key) );

        // added base64 encoding to avoid problems with binary data

        $encoded_cookie = base64_decode($this->value);

        if ( $encoded_cookie === false ) throw new CookieException("Cookie data cannot be decoded");

        $cookie = $cipher->decrypt($encoded_cookie);

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
     * @return  \Comodojo\Cookies\SecureCookie
     *
     * @throws  \Comodojo\Exception\CookieException
     */
    public static function create($name, $key, $properties=array(), $serialize=true) {

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
     * @return  \Comodojo\Cookies\SecureCookie
     *
     * @throws  \Comodojo\Exception\CookieException
     */
    public static function retrieve($name, $key) {

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
    private static function clientSpecificKey($key) {

        if ( isset($_SERVER['REMOTE_ADDR']) ) {

            $client_hash = md5($_SERVER['REMOTE_ADDR'] . ( isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : '' ), true);

            $server_hash = md5($key, true);

            $cookie_key = $client_hash . $server_hash;

        } else {

            $cookie_key = hash('sha256', $key);

        }

        return $cookie_key;

    }

}