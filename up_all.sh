#!/usr/bin/env bash

docker-compose -f user_service/docker-compose.yml up -d --remove-orphans
docker-compose -f web/docker-compose.yml up -d --remove-orphans