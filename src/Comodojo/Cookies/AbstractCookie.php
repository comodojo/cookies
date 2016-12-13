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
    protected $name = null;

    /**
     * Cookie value (native string or serialized one)
     *
     * @var string
     */
    protected $value = null;

    /**
     * Expiration time
     *
     * @var integer
     */
    protected $expire = null;

    /**
     * Path of cookie
     *
     * @var string
     */
    protected $path = null;

    /**
     * Domain of cookie
     *
     * @var string
     */
    protected $domain = null;

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
    protected $max_cookie_size = 4000;

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

        if ( is_int($max_cookie_size) ) {

            $this->max_cookie_size = filter_var($max_cookie_size, FILTER_VALIDATE_INT, array(
                'options' => array(
                    'default' => 4000
                )
            ));

        }

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

        if ( !is_scalar($domain) || !self::checkDomain($domain) ) throw new CookieException("Invalid domain attribute");

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
     * Static method to delete a cookie quickly
     *
     * @param   string   $name  The cookie name
     *
     * @return  boolean
     *
     * @throws  \Comodojo\Exception\CookieException
     */
    public static function erase($name) {

        try {

            $cookie = new Cookie($name);

            $return = $cookie->delete();

        } catch (CookieException $ce) {

            throw $ce;

        }

        return $return;

    }

    /**
     * Set content of $cookie from array $properties
     *
     * @param   \Comodojo\Cookies\CookieInterface\CookieInterface   $cookie
     *
     * @param   array    $properties    Array of properties cookie should have
     *
     * @param   boolean  $serialize
     *
     * @return  \Comodojo\Cookies\CookieBase
     */
    protected static function cookieProperties(CookieInterface $cookie, $properties, $serialize) {

        foreach ( $properties as $property => $value ) {

            switch ( $property ) {

                case 'value':

                    $cookie->setValue($value, $serialize);

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

    /**
     * Check if domain is valid
     *
     * Main code from: http://stackoverflow.com/questions/1755144/how-to-validate-domain-name-in-php
     *
     * @param   string   $domain_name  The domain name to check
     *
     * @return  bool
     */
    protected static function checkDomain($domain_name) {

        if ( $domain_name[0] == '.' ) $domain_name = substr($domain_name, 1);

        return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name) //valid chars check
                && preg_match("/^.{1,253}$/", $domain_name) //overall length check
                && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name)); //length of each label

    }

}
