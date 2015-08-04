<?php namespace Comodojo\Cookies;

use \Comodojo\Cookies\CookieInterface\CookieInterface;
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
     * Register cookie in manager
     *
     * @param   \Comodojo\Cookies\CookieInterface\CookieInterface     $cookie
     *
     * @return  Object   $this
     */
    public function register(CookieInterface $cookie) {

        $this->cookies[$cookie->getName()] = $cookie;

        return $this;

    }

    /**
     * Register cookie in manager
     *
     * @param   mixed    $cookie
     *
     * @return  \Comodojo\Cookies\CookieManager
     */
    public function unregister($cookie) {

        if ( empty($cookie) ) throw new CookieException("Invalid cookie object or name");

        $name = ($cookie instanceof CookieInterface) ? $cookie->getName() : $cookie;

        if ( $this->isRegistered($name) ) unset($this->cookies[$name]);

        else throw new CookieException("Cookie is not registered");

        return $this;

    }

    /**
     * Check if cookie has been registered in manager
     *
     * @param   mixed    $cookie
     *
     * @return  \Comodojo\Cookies\CookieManager
     */
    public function isRegistered($cookie) {

        if ( empty($cookie) ) throw new CookieException("Invalid cookie object or name");

        $name = ($cookie instanceof CookieInterface) ? $cookie->getName() : $cookie;

        return array_key_exists($name, $this->cookies);

    }

    /**
     * Get cookie from $cookie_name
     *
     * @param   string   $cookie_name
     *
     * @return  \Comodojo\Cookies\CookieInterface\CookieInterface
     */
    public function get($cookie_name) {

        if ( $this->isRegistered($cookie_name) ) return $this->cookies[$cookie_name];

        else throw new CookieException("Cookie is not registered");

    }

    /**
     * Get values from all registered cookies and dump as an associative array
     *
     * @return  array
     */
    public function getValues() {

        $cookies = array();

        try {
            
            foreach ($this->cookies as $name=>$cookie) {
                
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
     * @return  \Comodojo\Cookies\CookieManager
     */
    public function save() {

        try {

            foreach ($this->cookies as $c) {
                
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
     * @return  \Comodojo\Cookies\CookieManager
     */
    public function load() {

        try {

            foreach ($this->cookies as $c) {
                
                $c->load();

            }
            
        } catch (CookieException $ce) {
            
            throw $ce;

        }

        return $this;

    }

}