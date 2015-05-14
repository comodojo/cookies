php -S 127.0.0.1:8000 -t resources/ &
pid="${!}"
../vendor/bin/phpunit --configuration ../phpunit.xml.dist
kill "${pid}"