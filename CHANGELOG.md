# Changelog

## Version 2.0.0-alpha

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
