# Changelog

## Version 1.1.0

### Added
- new `EncryptedCookie`

### Fixed
- `SecureCookie` now encode data using base64 to avoid binary values
- Fixed an error in `CookieBase` that did not allow to set the correct path for a cookie
- Fixed an error in `CookieManager` that did not check existence of a cookie correctly

## Version 1.0.0

- Initial release