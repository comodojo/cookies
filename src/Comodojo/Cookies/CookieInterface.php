<?php namespace Comodojo\Cookies;

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

interface CookieInterface {

    /*
     * Cookie max size (the default one, change at your wish)
     *
     * @const int
     */
    const COOKIE_MAX_SIZE = 4000;

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
    public function setName($name);

    /**
     * Get cookie name
     *
     * @return string
     *   Name of cookie
     */
    public function getName();

    /**
     * Set value of cookie
     *
     * @param string $value
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
    public function setValue($value, $serialize);

    /**
     * Get cookie value
     *
     * @param bool $unserialize
     *   If true, cookie will be unserialized (default)
     *
     * @return string
     *   Value of cookie
     */
    public function getValue($unserialize);

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
    public function setExpire($time);

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
    public function setPath($location);

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
    public function setDomain($domain);

    /**
     * Set if the cookie should be transmitted only via https
     *
     * @param   bool  $mode
     *
     * @return self
     *   The invoked object.
     */
    public function setSecure($mode);

    /**
     * Set if cookie should be available only to HTTP protocol
     *
     * @return self
     *   The invoked object.
     */
    public function setHttponly($mode);

    /**
     * Set cookie
     *
     * @return  boolean
     */
    public function save();

    /**
     * Get cookie
     *
     * @return self
     *   The invoked object.
     */
    public function load();

    /**
     * Delete cookie
     *
     * @return  bool
     */
    public function delete();

    /**
     * Check if cookie exists
     *
     * @return  bool
     */
    public function exists();

}
