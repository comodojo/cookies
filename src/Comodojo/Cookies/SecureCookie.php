<?php

namespace Comodojo\Cookies;

use \phpseclib3\Crypt\AES;

/**
 * AES-encrypted cookie using client-specific key
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

class SecureCookie extends EncryptedCookie
{

    /**
     * Create a client-specific key using provided key,
     * the client remote address and (in case) the value of
     * HTTP_X_FORWARDED_FOR header
     *
     * {@inheritdoc}
     *
     */
    protected static function setupCipher(string $key): AES
    {
        $remoteAddress = $_SERVER['REMOTE_ADDR'] ?? '';
        $xffHeader = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '';
        $cipher = new AES('ecb');
        $cipher->setKeyLength(256);
        $cipher->setKey(hash('md5', $key.$remoteAddress.$xffHeader));
        return $cipher;
    }
}
