<?php

namespace Comodojo\Cookies;

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

class CookieManager
{

    /*
     * Cookie storage :)
     *
     * @var array
     */
    private array $cookies = [];

    /**
     * Add a cookie to the stack
     *
     * @param CookieInterface $cookie
     *
     * @return CookieManager
     */
    public function add(CookieInterface $cookie): CookieManager
    {
        $this->cookies[$cookie->getName()] = $cookie;
        return $this;
    }

    /**
     * Delete a cookie from the stack
     *
     * @param CookieInterface|string $cookie
     *
     * @return CookieManager
     * @throws CookieException
     */
    public function delete($cookie): CookieManager
    {
        $name = ($cookie instanceof CookieInterface) ? $cookie->getName() : $cookie;
        if (empty($name)) {
            throw new CookieException("Invalid cookie object or name");
        }

        if ($this->has($name)) {
            unset($this->cookies[$name]);
        } else {
            throw new CookieException("Cookie $name is not registered");
        }

        return $this;
    }

    /**
     * Check if a cookie is into the stack
     *
     * @param CookieInterface|string $cookie
     *
     * @return CookieManager
     * @throws CookieException
     */
    public function has($cookie)
    {
        $name = ($cookie instanceof CookieInterface) ? $cookie->getName() : $cookie;
        if (empty($name)) {
            throw new CookieException("Invalid cookie object or name");
        }

        return array_key_exists($name, $this->cookies);
    }

    /**
     * Get cookie from $cookie_name
     *
     * @param string $cookie_name
     *
     * @return CookieInterface
     * @throws CookieException
     */
    public function get(string $cookie_name): CookieInterface
    {
        if ($this->has($cookie_name)) {
            return $this->cookies[$cookie_name];
        }
        throw new CookieException("Cookie $cookie_name is not registered");
    }

    /**
     * Get the whole cookies' archive
     *
     * @return array
     */
    public function getAll(): array
    {
        return $this->cookies;
    }

    /**
     * Get values from all registered cookies and dump as an associative array
     *
     * @return array
     * @throws CookieException
     */
    public function getValues(): array
    {
        return array_map(fn(CookieInterface $cookie) => $cookie->getValue(), $this->cookies);
    }

    /**
     * Save all registered cookies
     *
     * @return bool
     * @throws CookieException
     */
    public function save(): bool
    {
        foreach ($this->cookies as $c) {
            $c->save();
        }
        return true;
    }

    /**
     * Load all registered cookies
     *
     * @return CookieManager
     * @throws CookieException
     */
    public function load(): CookieManager
    { 
        foreach ($this->cookies as $c) {
            $c->load();
        }
        return $this;
    }
}
