# Changelog

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