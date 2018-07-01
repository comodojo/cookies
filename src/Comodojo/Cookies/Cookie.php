<?php namespace Comodojo\Cookies;

use \Comodojo\Exception\CookieException;

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

class Cookie extends AbstractCookie {

    /**
     * {@inheritdoc}
     */
    public function setValue($value, $serialize = true) {

        if ( !is_scalar($value) && $serialize === false ) throw new CookieException("Cannot set non-scalar value without serialization");

        $cookie_value = $serialize === true ? serialize($value) : $value;

        if ( strlen($cookie_value) > $this->max_cookie_size ) throw new CookieException("Cookie size larger than ".$this->max_cookie_size." bytes");

        $this->value = $cookie_value;

        return $this;

    }

    /**
     * {@inheritdoc}
     */
    public function getValue($unserialize = true) {

        return $unserialize ? unserialize($this->value) : $this->value;

    }

    /**
     * Static method to quickly create a cookie
     *
     * @param string $name
     *  The cookie name
     *
     * @param array $properties
     *  Array of properties cookie should have
     *
     * @return self
     * @throws CookieException
     */
    public static function create($name, array $properties = [], $serialize = true) {

        try {

            $class = get_called_class();

            $cookie = new $class($name);

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
     * @return self
     * @throws CookieException
     */
    public static function retrieve($name) {

        try {

            $class = get_called_class();

            $cookie = new $class($name);

            return $cookie->load();

        } catch (CookieException $ce) {

            throw $ce;

        }

    }

}
