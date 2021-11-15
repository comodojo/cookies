SERVERPID=$(cat "$PWD/tests/tmp/pid") 
kill $SERVERPID
rm "$PWD/tests/tmp/pid"