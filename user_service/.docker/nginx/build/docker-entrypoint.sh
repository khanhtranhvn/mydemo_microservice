#!/usr/bin/env bash

source ./project/.env

set -aeu
set -euo pipefail

NGINX_ROOT=${NGINX_ROOT:=/code}

if [ -v "DOCKER_HOST_UID" ]; then
    usermod -u $DOCKER_HOST_UID www-data || true
fi

if [ -v "DOCKER_HOST_GID" ]; then
    groupmod -g $DOCKER_HOST_GID www-data || true
fi

# Tweak nginx to match the workers to cpu's
procs=$(cat /proc/cpuinfo |grep processor | wc -l)
sed -i -e "s/worker_processes 5/worker_processes $procs/" /etc/nginx/nginx.conf

# Again set the right permissions (needed when mounting from a volume)
set +e
chown -Rf www-data.www-data $NGINX_ROOT
set -e

# Start supervisord and services
exec /usr/bin/supervisord -n -c /etc/supervisord.conf
