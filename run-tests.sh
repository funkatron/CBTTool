#!/usr/bin/env bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# recreate sqlite db
echo "deleting testing db"
rm ./data/cbttool_testing.sqlite3;

echo "creating testing db"
sqlite3 ./data/cbttool_testing.sqlite3 "select ''";

# run migrations
echo "running migrations"
./vendor/bin/phinx migrate --environment='testing'

# run phpunit
echo "running tests"
./vendor/bin/phpunit --bootstrap ./vendor/autoload.php ./tests/

