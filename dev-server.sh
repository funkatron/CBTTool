#!/usr/bin/env bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
SERVER_ADDR="0.0.0.0:9909"

# making sqlite3 file if needed
sqlite3 ./data/cbttool.sqlite3 "select ''";

cd "$DIR/www"

echo "visit http://$SERVER_ADDR"

/usr/bin/env php -S $SERVER_ADDR

