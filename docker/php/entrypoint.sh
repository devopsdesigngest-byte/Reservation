#!/bin/sh
set -e

DB_HOST="${DB_HOST:-db}"
DB_PORT="${DB_PORT:-3306}"

until php -r '
$socket = @fsockopen($argv[1], (int)$argv[2]);
if ($socket) {
    fclose($socket);
    exit(0);
}
exit(1);
' "$DB_HOST" "$DB_PORT"; do
    sleep 2
done

php bin/console ndiassembow:migrate
exec php -S 0.0.0.0:8000 -t public