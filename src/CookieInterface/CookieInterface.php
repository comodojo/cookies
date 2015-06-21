<?php namespace Comodojo\Cookies\CookieInterface;

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

    /**
     * Set cookie name
     *
     * @param   string  $cookieName    The cookie name
     *
     * @return  Object  $this
     */
    public function setName($cookieName);

    /**
     * Get cookie name
     *
     * @return  string
     */
    public function getName();

    /**
     * Set cookie content
     *
     * @param   string $cookieValue
     *
     * @return  Object  $this
     */
    public function setValue($cookieValue);

    /**
     * Get cookie content
     *
     * @return  string
     */
    public function getValue();

    /**
     * Set cookie's expiration time
     *
     * @param   string  $time
     *
     * @return  Object  $this
     */
    public function setExpire($time);

    /**
     * Set cookie's path
     *
     * @param   string  $location
     *
     * @return  Object  $this
     */
    public function setPath($location);

    /**
     * Set cookie's domain
     *
     * @param   string  $domain
     *
     * @return  ObjectRequest   $this
     */
    public function setDomain($domain);

    /**
     * Set if the cookie should be transmitted only via https
     *
     * @param   bool  $mode
     */
    public function setSecure($header);

    /**
     * Set if cookie should be available only to HTTP protocol
     *
     * @return
     */
    public function setHttponly($mode);

    /**
     * Set cookie
     *
     */
    public function save();

    /**
     * Get cookie
     *
     * @return  strinng
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