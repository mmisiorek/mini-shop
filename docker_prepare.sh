#!/bin/bash

if [ ! -f app/config/parameters.yml ]; then
    cp app/config/parameters_docker.yml.dist app/config/parameters.yml
    echo "File parameters.yml was created"
fi