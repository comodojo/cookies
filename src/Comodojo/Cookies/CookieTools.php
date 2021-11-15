<?php

namespace Comodojo\Cookies;

use \Exception;

/**
 * Handy tools to build a cookie
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

class CookieTools
{

    /**
     * Set content of $cookie from array $properties
     *
     * @param CookieInterface $cookie
     *
     * @param array $properties
     *  Array of properties cookie should have in the format
     * [
     *      'value' => '',
     *      'expire' => '',
     *      'path' => '',
     *      'domain' => '',
     *      'secure' => '',
     *      'httponly' => ''
     * ]
     *
     * @param boolean $serialize
     *
     * @return CookieInterface
     * @throws Exception
     */
    public static function setCookieProperties(CookieInterface $cookie, array $properties, bool $serialize)
    {
        foreach ($properties as $property => $value) {
            switch ($property) {
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
     * @param string $domain_name
     *  The domain name to check
     *
     * @return  bool
     */
    public static function checkDomain(string $domain_name): bool
    {
        if ($domain_name[0] == '.') {
            $domain_name = substr($domain_name, 1);
        }
        return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name) //valid chars check
            && preg_match("/^.{1,253}$/", $domain_name) //overall length check
            && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name)); //length of each label
    }
}
