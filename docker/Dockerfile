FROM centos:latest
MAINTAINER Ömer ÜCEL <omerucel@gmail.com>
RUN yum install -y --nogpgcheck epel-release && \
    rpm -qa | grep -q remi-release || rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-7.rpm && \
    sed -i "s|enabled=1|enabled=0|" /etc/yum/pluginconf.d/fastestmirror.conf && \
    yum --enablerepo=remi-php56,remi install --nogpgcheck -y \
        nginx \
        git \
        php \
        php-opcache \
        php-pecl-xdebug \
        php-pecl-xhprof \
        php-mysql \
        php-pecl-memcached \
        php-mbstring \
        php-mcrypt \
        php-fpm \
        php-soap \
        php-json && \
    rm -rf /etc/nginx/conf.d/default.conf && \
    rm -rf /etc/nginx/conf.d/ssl.conf && \
    rm -rf /etc/nginx/conf.d/virtual.conf && \
    curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    TMPDIR=/tmp yum clean metadata && \
    TMPDIR=/tmp yum clean all