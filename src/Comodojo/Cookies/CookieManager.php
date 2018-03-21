<?php namespace Comodojo\Cookies;

use \Comodojo\Exception\CookieException;

/**
 * Manage multiple cookies of different types at one time
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

class CookieManager {

    /*
     * Cookie storage :)
     *
     * @var array
     */
    private $cookies = array();

    /**
     * Add a cookie to the stack
     *
     * @param CookieInterface $cookie
     *
     * @return static
     */
    public function add(CookieInterface $cookie) {

        $this->cookies[$cookie->getName()] = $cookie;

        return $this;

    }

    /**
     * @deprecated 2.1.0
     * @see CookieManager::add()
     */
    public function register(CookieInterface $cookie) {
        return $this->add($cookie);
    }

    /**
     * Delete a cookie from the stack
     *
     * @param CookieInterface|string $cookie
     *
     * @return static
     */
    public function del($cookie) {

        if ( empty($cookie) ) throw new CookieException("Invalid cookie object or name");

        $name = ($cookie instanceof CookieInterface) ? $cookie->getName() : $cookie;

        if ( $this->isRegistered($name) ) unset($this->cookies[$name]);

        else throw new CookieException("Cookie is not registered");

        return $this;

    }

    /**
     * @deprecated 2.1.0
     * @see CookieManager::del()
     */
    public function unregister($cookie) {
        return $this->del($cookie);
    }

    /**
     * Check if cookie is into the stack
     *
     * @param CookieInterface|string $cookie
     *
     * @return static
     */
    public function has($cookie) {

        if ( empty($cookie) ) throw new CookieException("Invalid cookie object or name");

        $name = ($cookie instanceof CookieInterface) ? $cookie->getName() : $cookie;

        return array_key_exists($name, $this->cookies);

    }

    /**
     * @deprecated 2.1.0
     * @see CookieManager::has()
     */
    public function isRegistered($cookie) {
        return $this->has($cookie);
    }

    /**
     * Get cookie from $cookie_name
     *
     * @param string $cookie_name
     *
     * @return CookieInterface
     */
    public function get($cookie_name) {

        if ( $this->isRegistered($cookie_name) ) return $this->cookies[$cookie_name];

        else throw new CookieException("Cookie is not registered");

    }

    /**
     * Get the whole cookies' archive
     *
     * @return array
     */
    public function getAll() {

        return $this->cookies;

    }

    /**
     * Get values from all registered cookies and dump as an associative array
     *
     * @return  array
     */
    public function getValues() {

        $cookies = array();

        try {

            foreach ( $this->cookies as $name=>$cookie ) {

                $cookies[$name] = $cookie->getValue();

            }

        } catch (CookieException $ce) {

            throw $ce;

        }

        return $cookies;

    }

    /**
     * Save all registered cookies
     *
     * @return static
     */
    public function save() {

        try {

            foreach ( $this->cookies as $c ) {

                $c->save();

            }

        } catch (CookieException $ce) {

            throw $ce;

        }

        return true;

    }

    /**
     * Load all registered cookies
     *
     * @return static
     */
    public function load() {

        try {

            foreach ( $this->cookies as $c ) {

                $c->load();

            }

        } catch (CookieException $ce) {

            throw $ce;

        }

        return $this;

    }

}
