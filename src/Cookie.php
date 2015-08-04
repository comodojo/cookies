<?php namespace Comodojo\Cookies;

use \Comodojo\Cookies\CookieInterface\CookieInterface;
use \Comodojo\Exception\CookieException;
use \Comodojo\Cookies\CookieBase;

/**
 * Plain cookie
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

class Cookie extends CookieBase implements CookieInterface {

    /**
     * Cookie constructor
     *
     * Setup cookie name
     *
     * @param  string   $name
     *
     * @throws \Comodojo\Exception\CookieException
     */
    public function __construct($name) {

        try {

            $this->setName($name);
            
        } catch (CookieException $ce) {
            
            throw $ce;

        }

        if ( defined("COMODOJO_COOKIE_MAX_SIZE") ) {

            $this->max_cookie_size = filter_var(COMODOJO_COOKIE_MAX_SIZE, FILTER_VALIDATE_INT, array(
                'options' => array(
                    'default' => 4000
                )
            ));

        }

    }

    /**
     * Set cookie content
     *
     * @param   mixed   $value      Cookie content
     * @param   bool    $serialize  If true (default) cookie will be serialized first
     *
     * @return  \Comodojo\Cookies\Cookie
     *
     * @throws  \Comodojo\Exception\CookieException
     */
    public function setValue($value, $serialize = true) {

        if ( !is_scalar($value) AND $serialize === false ) throw new CookieException("Cannot set non-scalar value without serialization");

        $cookie_value = $serialize === true ? serialize($value) : $value;

        if ( strlen($cookie_value) > $this->max_cookie_size ) throw new CookieException("Cookie size larger than 4KB");

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

        return $unserialize ? unserialize($this->value) : $this->value;

    }

    /**
     * Static method to create a cookie quickly
     *
     * @param   string   $name  The cookie name
     * 
     * @param   array    $properties    Array of properties cookie should have
     *
     * @return  \Comodojo\Cookies\Cookie
     *
     * @throws  \Comodojo\Exception\CookieException
     */
    public static function create($name, $properties = array(), $serialize = true) {

        try {

            $cookie = new Cookie($name);

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
     * @return  \Comodojo\Cookies\Cookie
     *
     * @throws  \Comodojo\Exception\CookieException
     */
    public static function retrieve($name) {

        try {

            $cookie = new Cookie($name);

            $return = $cookie->load();

        } catch (CookieException $ce) {
            
            throw $ce;

        }

        return $return;

    }

}
