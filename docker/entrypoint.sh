#!/bin/bash
set -e

printf "zend_extension=xdebug.so\nxdebug.remote_autostart=off\nxdebug.remote_enable=on\nxdebug.remote_port=$PHP_XDEBUG_REMOTE_PORT\nxdebug.idekey=PHPSTORM\nxdebug.remote_connect_back=off\nxdebug.remote_log=/proc/self/fd/2\nxdebug.remote_host=$PHP_XDEBUG_REMOTE_HOST" > $PHP_INI_DIR/conf.d/xdebug.ini

exec /usr/bin/supervisord --nodaemon -c /app/docker/conf/supervisord.conf