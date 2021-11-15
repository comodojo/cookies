php -S 127.0.0.1:8000 -t tests/resources/ > /dev/null 2>&1 &
SERVERPID=$!
echo $SERVERPID > "$PWD/tests/tmp/pid"