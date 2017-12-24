#!/usr/bin/env bash

docker-compose -f user_service/docker-compose.yml build
docker-compose -f web/docker-compose.yml build