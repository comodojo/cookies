<?php namespace Comodojo\Cookies;

use phpseclib3\Crypt\AES;
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
     * Only keys of sizes 16, 24 or 32 supported
     *
     * @var int
     */
    private $key = null;

    /**
     * Encrypted cookie constructor
     *
     * Setup cookie name and key
     *
     * @param string $name
     * @param string $key
     * @param int $max_cookie_size
     *
     * @throws CookieException
     */
    public function __construct($name, $key, $max_cookie_size = null) {

        if ( empty($key) OR !is_scalar($key) ) throw new CookieException("Invalid secret key");

        parent::__construct($name, $max_cookie_size);

    }

    /**
     * {@inheritdoc}
     */
    public function setValue($value, $serialize = true) {

        if ( !is_scalar($value) && $serialize === false ) throw new CookieException("Cannot set non-scalar value without serialization");

        if ( $serialize === true ) $value = serialize($value);

        $cipher = new AES('ecb');

        $cipher->setKey($this->key);

        // added base64 encoding to avoid problems with binary data

        $cookie_value = base64_encode($cipher->encrypt($value));

        if ( strlen($cookie_value) > $this->max_cookie_size ) throw new CookieException("Cookie size larger than ".$this->max_cookie_size." bytes");

        $this->value = $cookie_value;

        return $this;

    }

    /**
     * {@inheritdoc}
     */
    public function getValue($unserialize = true) {

        $cipher = new AES('ecb');

        $cipher->setKey($this->key);

        // added base64 encoding to avoid problems with binary data

        $encoded_cookie = base64_decode($this->value);

        if ( $encoded_cookie === false ) throw new CookieException("Cookie data cannot be decoded");

        $cookie = $cipher->decrypt($encoded_cookie);

        if ( $cookie === false ) throw new CookieException("Cookie data cannot be dectypted");

        return ($unserialize === true) ? unserialize($cookie) : $cookie;

    }

    /**
     * Static method to quickly create a cookie
     *
     * @param string $name
     *  The cookie name
     *
     * @param string $key
     *
     * @param array $properties
     *  Array of properties cookie should have
     *
     * @return  EncryptedCookie
     * @throws  CookieException
     */
    public static function create($name, $key, array $properties = [], $serialize = true) {

        try {

            $class = get_called_class();

            $cookie = new $class($name, $key);

            CookieTools::setCookieProperties($cookie, $properties, $serialize);

        } catch (CookieException $ce) {

            throw $ce;

        }

        return $cookie;

    }

    /**
     * Static method to quickly get a cookie
     *
     * @param string $name
     *  The cookie name
     *
     * @param string $key
     *
     * @return EncryptedCookie
     * @throws CookieException
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


}
