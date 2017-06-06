FROM php:5.6.30-alpine

RUN docker-php-ext-install mysql

WORKDIR /var/www/html

ADD . /var/www/html

EXPOSE "80"

CMD ["php", "-S", "0.0.0.0:80"]