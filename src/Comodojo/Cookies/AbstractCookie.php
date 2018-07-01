<?php namespace Comodojo\Cookies;

use \Comodojo\Exception\CookieException;

/**
 * Base class, to be estended implementing a CookieInterface
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

abstract class AbstractCookie implements CookieInterface {

    /**
     * The cookie name
     *
     * @var string
     */
    protected $name;

    /**
     * Cookie value (native string or serialized one)
     *
     * @var string
     */
    protected $value;

    /**
     * Expiration time
     *
     * @var integer
     */
    protected $expire;

    /**
     * Path of cookie
     *
     * @var string
     */
    protected $path;

    /**
     * Domain of cookie
     *
     * @var string
     */
    protected $domain;

    /**
     * Secure flag
     *
     * @var bool
     */
    protected $secure = false;

    /**
     * Httponly flag
     *
     * @var bool
     */
    protected $httponly = false;

    /*
     * Max cookie size
     *
     * Should be 4096 max
     *
     * @var int
     */
    protected $max_cookie_size;

    /**
     * Default cookie's constructor
     *
     * @param string $name
     * @param int $max_cookie_size
     *
     * @throws CookieException
     */
    public function __construct($name, $max_cookie_size = null) {

        try {

            $this->setName($name);

        } catch (CookieException $ce) {

            throw $ce;

        }

        $this->max_cookie_size = filter_var($max_cookie_size, FILTER_VALIDATE_INT, [
            'options' => [
                'default' => CookieInterface::COOKIE_MAX_SIZE
            ]
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function setName($name) {

        if ( empty($name) || !is_scalar($name) ) throw new CookieException("Invalid cookie name");

        $this->name = $name;

        return $this;

    }

    /**
     * {@inheritdoc}
     */
    public function getName() {

        return $this->name;

    }

    /**
     * {@inheritdoc}
     */
    abstract function setValue($value, $serialize);

    /**
     * {@inheritdoc}
     */
    abstract function getValue($unserialize);

    /**
     * {@inheritdoc}
     */
    public function setExpire($timestamp) {

        if ( !is_int($timestamp) ) throw new CookieException("Invalud cookie's expiration time");

        $this->expire = $timestamp;

        return $this;

    }

    /**
     * {@inheritdoc}
     */
    public function setPath($location) {

        if ( !is_string($location) ) throw new CookieException("Invalid path attribute");

        $this->path = $location;

        return $this;

    }

    /**
     * {@inheritdoc}
     */
    public function setDomain($domain) {

        if ( !is_scalar($domain) || !CookieTools::checkDomain($domain) ) throw new CookieException("Invalid domain attribute");

        $this->domain = $domain;

        return $this;

    }

    /**
     * {@inheritdoc}
     */
    public function setSecure($mode = true) {

        $this->secure = filter_var($mode, FILTER_VALIDATE_BOOLEAN);

        return $this;

    }

    /**
     * {@inheritdoc}
     */
    public function setHttponly($mode = true) {

        $this->httponly = filter_var($mode, FILTER_VALIDATE_BOOLEAN);

        return $this;

    }

    /**
     * {@inheritdoc}
     */
    public function save() {

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
     * {@inheritdoc}
     */
    public function load() {

        if ( !$this->exists() ) throw new CookieException("Cookie does not exists");

        $this->value = $_COOKIE[$this->name];

        return $this;

    }

    /**
     * {@inheritdoc}
     */
    public function delete() {

        if ( !$this->exists() ) return true;

        if ( setcookie(
            $this->name,
            null,
            time() - 86400,
            null,
            null,
            $this->secure,
            $this->httponly
        ) === false ) throw new CookieException("Cannot delete cookie");

        return true;

    }

    /**
     * {@inheritdoc}
     */
    public function exists() {

        return isset($_COOKIE[$this->name]);

    }

    /**
     * Static method to quickly delete a cookie
     *
     * @param string $name
     *  The cookie name
     *
     * @return boolean
     * @throws CookieException
     */
    public static function erase($name) {

        try {

            $class = get_called_class();

            $cookie = new $class($name);

            return $cookie->delete();

        } catch (CookieException $ce) {

            throw $ce;

        }

    }

}
