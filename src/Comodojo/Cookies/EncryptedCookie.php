<?php namespace Comodojo\Cookies;

use \phpseclib\Crypt\AES;
use \Comodojo\Exception\CookieException;

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

class EncryptedCookie extends AbstractCookie {

    /*
     * AES key
     *
     * @var int
     */
    private $key = null;

    /**
     * Encrypted cookie constructor
     *
     * Setup cookie name and key
     *
     * @param   string   $name
     *
     * @param   string   $key
     *
     * @throws \Comodojo\Exception\CookieException
     */
    public function __construct($name, $key, $max_cookie_size = null) {

        if ( empty($key) OR !is_scalar($key) ) throw new CookieException("Invalid secret key");

        parent::__construct($name, $max_cookie_size);

    }

    /**
     * Set cookie content
     *
     * @param   mixed   $value      Cookie content
     * @param   bool    $serialize  If true (default) cookie will be serialized first
     *
     * @return  \Comodojo\Cookies\EncryptedCookie
     *
     * @throws  \Comodojo\Exception\CookieException
     */
    public function setValue($value, $serialize = true) {

        if ( !is_scalar($value) && $serialize === false ) throw new CookieException("Cannot set non-scalar value without serialization");

        if ( $serialize === true ) $value = serialize($value);

        $cipher = new AES(AES::MODE_ECB);

        $cipher->setKeyLength(256);

        $cipher->setKey(self::encryptKey($this->key));

        // added base64 encoding to avoid problems with binary data

        $cookie_value = base64_encode($cipher->encrypt($value));

        if ( strlen($cookie_value) > $this->max_cookie_size ) throw new CookieException("Cookie size larger than ".$this->max_cookie_size." bytes");

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
    public function getValue($unserialize = true) {

        $cipher = new AES(AES::MODE_ECB);

        $cipher->setKeyLength(256);

        $cipher->setKey(self::encryptKey($this->key));

        // added base64 encoding to avoid problems with binary data

        $encoded_cookie = base64_decode($this->value);

        if ( $encoded_cookie === false ) throw new CookieException("Cookie data cannot be decoded");

        $cookie = $cipher->decrypt($encoded_cookie);

        if ( $cookie === false ) throw new CookieException("Cookie data cannot be dectypted");

        return ($unserialize === true) ? unserialize($cookie) : $cookie;

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
     * @return  \Comodojo\Cookies\EncryptedCookie
     *
     * @throws  \Comodojo\Exception\CookieException
     */
    public static function create($name, $key, $properties = [], $serialize = true) {

        try {

            $class = get_called_class();

            $cookie = new $class($name, $key);

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
     * @return  \Comodojo\Cookies\EncryptedCookie
     *
     * @throws  \Comodojo\Exception\CookieException
     */
    public static function retrieve($name, $key) {

        try {

            $class = get_called_class();

            $cookie = new $class($name, $key);

            $return = $cookie->load();

        } catch (CookieException $ce) {

            throw $ce;

        }

        return $return;

    }

    /**
     * Hash the key to generate a valid aes key value
     *
     * @param   string   $key
     *
     * @return  string
     */
    protected static function encryptKey($key) {

        return hash('sha256', $key);

    }

}
