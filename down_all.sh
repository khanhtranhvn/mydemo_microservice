#!/usr/bin/env bash

docker-compose -f user_service/docker-compose.yml down
docker-compose -f web/docker-compose.yml down
