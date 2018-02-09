FROM alpine:3.6

RUN apk add --no-cache php7 php7-phar php7-json php7-openssl php7-iconv php7-zlib \
                php7-xml php7-pdo php7-ctype php7-mbstring php7-dom php7-session \
                php7-intl php7-tokenizer php7-pdo_mysql php7-simplexml bash nodejs-npm
RUN php -r "copy('http://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN rm composer-setup.php

RUN mv composer.phar /usr/bin/composer

RUN addgroup -g 1000 app \
    && adduser -u 1000 -G app -s /bin/php -D app

RUN mkdir /home/app/code
COPY . /home/app/code
RUN rm -rf /home/app/code/vendor /home/app/code/node_modules composer.lock
RUN chown -R app:app /home/app/code

USER app
WORKDIR /home/app/code

RUN composer install
RUN npm install

#CMD ["php", "bin/console", "server:run", "0.0.0.0:8000"]
CMD ["/bin/bash", "docker_start.sh"]