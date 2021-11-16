# Changelog

## Version 3.0.0-beta

### Breaking
- `CookieInterface::setValue()` accepts only strings now and no serialization provided (address https://sonarcloud.io/project/issues?id=comodojo_cookies&issues=AX0l3VoHz93uDyzxLqiG&open=AX0l3VoHz93uDyzxLqiG)
- `CookieInterface::getValue()` does not provide unserialization anymore (address https://sonarcloud.io/project/issues?id=comodojo_cookies&issues=AX0l3VoHz93uDyzxLqiG&open=AX0l3VoHz93uDyzxLqiG)
- `CookieManager::register()` was already deprecated and is now removed
- `CookieManager::unregister()` was already deprecated and is now removed
- `CookieManager::isRegistered()` was already deprecated and is now removed
- `CookieManager::delete()` replaces `CookieManager::del()`

### Other
- PHP min version to 7.4
- Update phpseclib to 3.0
- Some exceptions were rephrased

## Version 2.0.0

### Other
- minor code refactoring

## Version 2.0.0-beta

### Added
- `CookieManager::add()`
- `CookieManager::del()`
- `CookieManager::has()`
- `CookieManager::getAll()`

### Deprecated
- `CookieManager::register()` is now an alias for CookieManager::add(), will be removed in 2.1 branch
- `CookieManager::unregister()` is now an alias for CookieManager::del(), will be removed in 2.1 branch
- `CookieManager::isRegistered()` is now an alias for CookieManager::has(), will be removed in 2.1 branch

### Other
- PHP min version to 5.4
- Update phpseclib to 2.0 branch

## Version 1.1.1

### Added
- added comodojo/exceptions as a dependency

### Fixed
- Fixed `CookieInterface` methods signatures
- Fixed `CookieBase::exists` method

### Other
- Better commenting

## Version 1.1.0

### Added
- new `EncryptedCookie`

### Fixed
- `SecureCookie` now encode data using base64 to avoid binary values
- Fixed an error in `CookieBase` that did not allow to set the correct path for a cookie
- Fixed an error in `CookieManager` that did not check existence of a cookie correctly

## Version 1.0.0

- Initial release
