<?php namespace Comodojo\Cookies;

/**
 * AES-encrypted cookie
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

class SecureCookie extends EncryptedCookie {

    /**
     * Create a client-specific key using provided key,
     * the client remote address and (in case) the value of
     * HTTP_X_FORWARDED_FOR header
     *
     * @param   string   $key
     *
     * @return  string
     */
    protected static function encryptKey($key) {

        if ( isset($_SERVER['REMOTE_ADDR']) ) {

            $client_hash = md5($_SERVER['REMOTE_ADDR'].(isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : ''), true);

            $server_hash = md5($key, true);

            $cookie_key = $client_hash.$server_hash;

        } else {

            $cookie_key = hash('sha256', $key);

        }

        return $cookie_key;

    }

}
