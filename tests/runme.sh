php -S 127.0.0.1:8000 -t $TRAVIS_BUILD_DIR/tests/resources/ &
pid="${!}"
$TRAVIS_BUILD_DIR/vendor/bin/phpunit
kill "${pid}"