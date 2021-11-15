<?php

namespace Comodojo\Cookies;

use \phpseclib3\Crypt\AES;
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

class EncryptedCookie extends AbstractCookie
{

    /*
     * AES cipher
     *
     * @var AES
     */
    private AES $cipher;

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
    public function __construct(string $name, string $key, int $max_cookie_size = null)
    {
        if (empty($key) or empty($key)) {
            throw new CookieException("Invalid secret key");
        }
        $this->cipher = self::setupCipher($key);
        parent::__construct($name, $max_cookie_size);
    }

    /**
     * {@inheritdoc}
     */
    public function setValue($value, bool $serialize = true): CookieInterface
    {
        if (!is_scalar($value) && $serialize === false) {
            throw new CookieException("Cannot set non-scalar value without serialization");
        }

        if ($serialize === true) {
            $value = serialize($value);
        }

        // base64 encoding to avoid problems with binary data
        $this->value = base64_encode($this->cipher->encrypt($value));
        if (strlen($this->value) > $this->max_cookie_size) {
            throw new CookieException("Cookie size larger than " . $this->max_cookie_size . " bytes");
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue(bool $unserialize = true)
    {
        $decoded_cookie = base64_decode($this->value);
        if ($decoded_cookie === false) {
            throw new CookieException("Cookie data cannot be decoded");
        }

        $cookie = $this->cipher->decrypt($decoded_cookie);
        if ($cookie === false) {
            throw new CookieException("Cookie data cannot be dectypted");
        }

        return $unserialize === true ? unserialize($cookie) : $cookie;
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
     * @return  CookieInterface
     * @throws  CookieException
     */
    public static function create($name, $key, array $properties = [], $serialize = true): CookieInterface
    {
        $class = get_called_class();
        $cookie = new $class($name, $key);
        CookieTools::setCookieProperties($cookie, $properties, $serialize);
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
     * @return CookieInterface
     * @throws CookieException
     */
    public static function retrieve(string $name, string $key): CookieInterface
    {
        $class = get_called_class();
        $cookie = new $class($name, $key);
        return $cookie->load();
    }

    /**
     * Setup the AES cipher
     *
     * @param string $key
     *
     * @return AES
     */
    protected static function setupCipher(string $key): AES {
        $cipher = new AES('ecb');
        $cipher->setKeyLength(256);
        $cipher->setKey(hash('md5', $key));
        return $cipher;
    }
}
