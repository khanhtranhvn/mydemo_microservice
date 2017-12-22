FROM nginx:1.13.3
MAINTAINER Khanh Tran <khanh.tranvn90@gmail.com>

ENV IMAGE_PHP_VERSION=7.1

RUN export DEBIAN_FRONTEND=noninteractive \
    && apt-get update --fix-missing \
    && apt-get -y upgrade \
    && apt-get -y dist-upgrade \
    && apt-get -y autoremove \
    && apt-get install --no-install-recommends --no-install-suggests -y ca-certificates \
        software-properties-common \
        gettext-base \
        curl \
        openssl \
        git \
        bzip2 \
        imagemagick \
        webp \
        supervisor \
        pwgen

RUN LC_ALL=en_US.UTF-8 apt-add-repository ppa:ondrej/php \
    && apt-get update \
    && apt-get install --fix-missing --allow-unauthenticated -y php7.1 php7.1-fpm \
        php7.1-common \
        php7.1-bcmath \
        php7.1-cli \
        php7.1-curl \
        php7.1-gd \
        php7.1-intl \
        php7.1-json \
        php7.1-mbstring \
        php7.1-mcrypt \
        php7.1-mysqlnd \
        php7.1-opcache \
        php7.1-readline \
        php7.1-sqlite \
        php7.1-imap \
        php7.1-soap \
        php7.1-xml \
        php7.1-zip \
        php7.1-mongodb \
        php7.1-imagick \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer \
    && apt-get autoremove -y \
    && rm -rf /var/lib/apt/lists/* \
    && apt-get clean

# tweak nginx config
RUN sed -i -e"s/worker_processes  1/worker_processes 5/" /etc/nginx/nginx.conf && \
sed -i -e"s/keepalive_timeout\s*65/keepalive_timeout 2/" /etc/nginx/nginx.conf && \
sed -i -e"s/user  nginx/user  www-data/" /etc/nginx/nginx.conf && \
sed -i -e"s/keepalive_timeout 2/keepalive_timeout 2;\n\tclient_max_body_size 100m/" /etc/nginx/nginx.conf

# tweak php-fpm config
RUN sed -i -e "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g" /etc/php/${IMAGE_PHP_VERSION}/fpm/php.ini && \
sed -i -e "s/upload_max_filesize\s*=\s*2M/upload_max_filesize = 100M/g" /etc/php/${IMAGE_PHP_VERSION}/fpm/php.ini && \
sed -i -e "s/post_max_size\s*=\s*8M/post_max_size = 100M/g" /etc/php/${IMAGE_PHP_VERSION}/fpm/php.ini && \
sed -i -e "s/;daemonize\s*=\s*yes/daemonize = no/g" /etc/php/${IMAGE_PHP_VERSION}/fpm/php-fpm.conf && \
sed -i -e "s/;catch_workers_output\s*=\s*yes/catch_workers_output = yes/g" /etc/php/${IMAGE_PHP_VERSION}/fpm/pool.d/www.conf && \
sed -i -e "s/pm.max_children = 5/pm.max_children = 9/g" /etc/php/${IMAGE_PHP_VERSION}/fpm/pool.d/www.conf && \
sed -i -e "s/pm.start_servers = 2/pm.start_servers = 3/g" /etc/php/${IMAGE_PHP_VERSION}/fpm/pool.d/www.conf && \
sed -i -e "s/pm.min_spare_servers = 1/pm.min_spare_servers = 2/g" /etc/php/${IMAGE_PHP_VERSION}/fpm/pool.d/www.conf && \
sed -i -e "s/pm.max_spare_servers = 3/pm.max_spare_servers = 4/g" /etc/php/${IMAGE_PHP_VERSION}/fpm/pool.d/www.conf && \
sed -i -e "s/pm.max_requests = 500/pm.max_requests = 200/g" /etc/php/${IMAGE_PHP_VERSION}/fpm/pool.d/www.conf

# fix ownership of sock file for php-fpm
#RUN sed -i -e "s/;listen.mode = 0660/listen.mode = 0750/g" /etc/php/${IMAGE_PHP_VERSION}/fpm/pool.d/www.conf && \
RUN sed -i "s/;listen.owner = nobody/listen.owner = www-data/g" /etc/php/${IMAGE_PHP_VERSION}/fpm/pool.d/www.conf && \
sed -i "s/;listen.group = nobody/listen.group = www-data/g" /etc/php/${IMAGE_PHP_VERSION}/fpm/pool.d/www.conf && \
find /etc/php/${IMAGE_PHP_VERSION}/cli/conf.d/ -name "*.ini" -exec sed -i -re 's/^(\s*)#(.*)/\1;\2/g' {} \; && \
mkdir /run/php

# Supervisor Config
COPY build/supervisord.conf /etc/supervisord.conf

# mycrypt conf
RUN phpenmod mcrypt

RUN mkdir /code \
    && chown -R www-data: /code

COPY build/docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh

ENTRYPOINT ["/docker-entrypoint.sh"]