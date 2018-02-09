Mini shop
========================

Installation
-------------

First please build the container with the command:

    docker-compose build app
    
Later go inside of the container with command:
 
    docker-compose run app bash
 
and execute:
    
    php bin/console doctrine:schema:update --force
    
Exit the container with:

    exit
    
Later you should be able to run project with the command:

    docker-compose up 
    
The default url for in the development mode is [http://localhost:8000](http://localhost:8000).

Testing 
------------

Run in the project's directory:

    docker-compose run app bash
    
And later execute:

    php bin/phpunit