php -S 127.0.0.1:8000 -t resources/ &
pid="${!}"
$TRAVIS_BUILD_DIR/vendor/bin/phpunit
kill "${pid}"