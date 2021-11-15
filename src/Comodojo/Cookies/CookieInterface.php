<?php

namespace Comodojo\Cookies;

/**
 * Object cookie interface
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

interface CookieInterface
{

    /*
     * Cookie max size (the default one, change at your wish)
     *
     * @const int
     */
    public const COOKIE_MAX_SIZE = 4000;

    /**
     * Set cookie name
     *
     * @param string $name
     *   The cookie name.
     *
     * @return self
     *   The invoked object.
     *
     * @throws CookieException
     */
    public function setName(string $name): CookieInterface;

    /**
     * Get cookie name
     *
     * @return string
     *   Name of cookie
     */
    public function getName(): string;

    /**
     * Set value of cookie
     *
     * @param mixed $value
     *   The value of cookie.
     *
     * @param bool $serialize
     *   If true, cookie will be serialized (default)
     *
     * @return self
     *   The invoked object.
     *
     * @throws CookieException
     */
    public function setValue($value, bool $serialize = true): CookieInterface;

    /**
     * Get cookie value
     *
     * @param bool $unserialize
     *   If true, cookie will be unserialized (default)
     *
     * @return mixed
     *   Value of cookie
     */
    public function getValue(bool $unserialize = true);

    /**
     * Set cookie's expiration time
     *
     * @param  integer  $time
     *
     * @return self
     *   The invoked object.
     *
     * @throws CookieException
     */
    public function setExpire(int $time): CookieInterface;

    /**
     * Set cookie's path
     *
     * @param   string  $location
     *
     * @return self
     *   The invoked object.
     *
     * @throws CookieException
     */
    public function setPath(string $location): CookieInterface;

    /**
     * Set cookie's domain
     *
     * @param   string  $domain
     *
     * @return self
     *   The invoked object.
     *
     * @throws CookieException
     */
    public function setDomain(string $domain): CookieInterface;

    /**
     * Set if the cookie should be transmitted only via https
     *
     * @param   bool  $mode
     *
     * @return self
     *   The invoked object.
     */
    public function setSecure(bool $mode): CookieInterface;

    /**
     * Set if cookie should be available only to HTTP protocol
     *
     * @return self
     *   The invoked object.
     */
    public function setHttponly(bool $mode): CookieInterface;

    /**
     * Set cookie
     *
     * @return  boolean
     */
    public function save(): bool;

    /**
     * Get cookie
     *
     * @return self
     *   The invoked object.
     */
    public function load(): CookieInterface;

    /**
     * Delete cookie
     *
     * @return  bool
     */
    public function delete(): bool;

    /**
     * Check if cookie exists
     *
     * @return  bool
     */
    public function exists(): bool;

    /**
     * Static method to quickly delete a cookie
     *
     * @param string $name
     *  The cookie name
     *
     * @return boolean
     * @throws CookieException
     */
    public static function erase(string $name): bool;
}
