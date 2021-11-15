<?php

namespace Comodojo\Cookies;

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

abstract class AbstractCookie implements CookieInterface
{

    /**
     * The cookie name
     *
     * @var string
     */
    protected string $name = '';

    /**
     * Cookie value (native string or serialized one)
     *
     * @var string
     */
    protected string $value = '';

    /**
     * Expiration time
     *
     * @var integer
     */
    protected int $expire = 0;

    /**
     * Path of cookie
     *
     * @var string
     */
    protected string $path = '';

    /**
     * Domain of cookie
     *
     * @var string
     */
    protected string $domain = '';

    /**
     * Secure flag
     *
     * @var bool
     */
    protected bool $secure = false;

    /**
     * Httponly flag
     *
     * @var bool
     */
    protected bool $httponly = false;

    /*
     * Max cookie size
     *
     * Should be 4096 max
     *
     * @var int
     */
    protected int $max_cookie_size;

    /**
     * Default cookie's constructor
     *
     * @param string $name
     * @param int $max_cookie_size
     *
     * @throws CookieException
     */
    public function __construct(string $name, int $max_cookie_size = null)
    {
        $this->setName($name);
        $this->max_cookie_size = filter_var($max_cookie_size, FILTER_VALIDATE_INT, [
            'options' => [
                'default' => CookieInterface::COOKIE_MAX_SIZE
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function setName(string $name): CookieInterface
    {
        if (empty($name)) {
            throw new CookieException("Invalid cookie name");
        }

        $this->name = $name;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    abstract function setValue($value, bool $serialize = true): CookieInterface;

    /**
     * {@inheritdoc}
     */
    abstract function getValue(bool $unserialize = true);

    /**
     * {@inheritdoc}
     */
    public function setExpire(int $timestamp): CookieInterface
    {
        $this->expire = $timestamp;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setPath(string $location): CookieInterface
    {
        $this->path = $location;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setDomain(string $domain): CookieInterface
    {
        if (!CookieTools::checkDomain($domain)) {
            throw new CookieException("Invalid cookie domain");
        }

        $this->domain = $domain;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setSecure(bool $mode = true): CookieInterface
    {
        $this->secure = $mode;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setHttponly(bool $mode = true): CookieInterface
    {
        $this->httponly = $mode;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function save(): bool
    {
        if (setcookie(
            $this->name,
            $this->value,
            $this->expire,
            $this->path,
            $this->domain,
            $this->secure,
            $this->httponly
        ) === false) {
            throw new CookieException("Cannot set cookie: " . $this->name);
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function load(): CookieInterface
    {
        if (!$this->exists()) {
            throw new CookieException("Cookie ".$this->name." does not exists");
        }
        $this->value = $_COOKIE[$this->name];
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(): bool
    {
        if (!$this->exists()) {
            return true;
        }
        if (setcookie(
            $this->name,
            null,
            time() - 86400,
            null,
            null,
            $this->secure,
            $this->httponly
        ) === false) {
            throw new CookieException("Cannot delete cookie");
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function exists(): bool
    {
        return isset($_COOKIE[$this->name]);
    }

    /**
     * {@inheritdoc}
     */
    public static function erase(string $name): bool
    {
        $class = get_called_class();
        $cookie = new $class($name);
        return $cookie->delete();
    }
}
