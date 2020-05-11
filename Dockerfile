FROM php:5.6-apache
ENV TERM=xterm
LABEL maintainer="contact@panz.fr"
RUN apt update && apt install -y ca-certificates
COPY --chown=www-data:www-data MCManager/ /var/www/html/
RUN docker-php-ext-install pdo mysql
RUN docker-php-ext-install pdo mysqli
RUN usermod -u 1000 www-data
RUN a2enmod rewrite
VOLUME ["/var/www/html/"]
CMD /usr/sbin/apache2ctl -D FOREGROUND
