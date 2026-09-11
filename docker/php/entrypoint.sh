#!/bin/sh
set -e
until php -r '
$socket = @fsockopen("db", 3306);
if ($socket) {
    fclose($socket);
    exit(0);
}
exit(1);
'; do
    sleep 2
done
php bin/console ndiassembow:migrate
exec php -S 0.0.0.0:8000 -t public