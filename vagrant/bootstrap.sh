#! /bin/bash

# Setting Files
export XDEBUG_REMOTE_INI_FILE="/vagrant/vagrant/files/xdebug-remote.ini"
export XDEBUG_PROFILER_INI_FILE="/vagrant/vagrant/files/xdebug-profiler.ini"
export MYSQL_CONF_FILE="/vagrant/vagrant/files/my.cnf"
export PHPFPM_CONF_FILE="/vagrant/vagrant/files/www.conf"
export PHP_INI_FILE="/vagrant/vagrant/files/php-development.ini"
export NGINX_VHOST_FILE="/vagrant/vagrant/files/vhost.conf"
export DATABASE_NAME="project"

# Set Global Environment
rm -f /etc/profile.d/vagrant.sh
echo 'export APPLICATION_ENV="development"' > /etc/profile.d/vagrant.sh
chmod 755 /etc/profile.d/vagrant.sh

# ----------------------------------------------------------------------------------------------------------------------

echo "STARTING BASE SECTION..."
sed -i "s|enabled=1|enabled=0|" /etc/yum/pluginconf.d/fastestmirror.conf

/etc/init.d/iptables stop
chkconfig iptables off
echo "FINISHED BASE SECTION!"

# ----------------------------------------------------------------------------------------------------------------------

echo "STARTING REMI SECTION..."
rpm -qa | grep -q epel-release || rpm -Uvh http://download.fedoraproject.org/pub/epel/6/i386/epel-release-6-8.noarch.rpm
rpm -qa | grep -q remi-release || rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-6.rpm
echo "FINISHED REMI SECTION!"

echo "STARTING GIT SECTION..."
yum --enablerepo=remi install -y git-core
echo "FINISHED GIT SECTION!"

echo "STARTING MYSQL SECTION..."
yum --enablerepo=remi install -y mysql-server mysql-devel
service mysqld stop

cp -f "$MYSQL_CONF_FILE" /etc/my.cnf

chkconfig mysqld on
service mysqld start

mysql -u root -e "GRANT ALL ON *.* TO root@'%' IDENTIFIED BY '' WITH GRANT OPTION;"
mysql -u root -e "CREATE DATABASE $DATABASE_NAME CHARACTER SET 'utf8';"
echo "FINISHED MYSQL SECTION!"

# ----------------------------------------------------------------------------------------------------------------------

echo "STARTING PHP SECTION..."
yum --enablerepo=remi-php55,remi install -y gcc make php php-opcache php-apc php-devel pcre-devel php-pear php-pecl-xdebug php-pecl-xhprof php-mysql php-pecl-memcached php-xml php-gd php-mbstring php-mcrypt php-fpm php-soap php-json

curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

rm -f /etc/php-fpm.d/www.conf
ln -s "${PHPFPM_CONF_FILE}" /etc/php-fpm.d/www.conf

rm -f /etc/php.d/php-development.ini
ln -s "${PHP_INI_FILE}" /etc/php.d/php-development.ini

rm -f /etc/php.d/xdebug-remote.ini
ln -s "${XDEBUG_REMOTE_INI_FILE}" /etc/php.d/xdebug-remote.ini

rm -f /etc/php.d/xdebug-profiler.ini
ln -s "${XDEBUG_PROFILER_INI_FILE}" /etc/php.d/xdebug-profiler.ini

rm -f /vagrant/composer.lock
/usr/local/bin/composer self-update
/usr/local/bin/composer -d=/vagrant install
if [ -d "/vagrant/vendor/bin" ]; then
    echo 'pathmunge /vagrant/vendor/bin' > /etc/profile.d/phpcomposer_vendor.sh
    chmod +x /etc/profile.d/phpcomposer_vendor.sh
    . /etc/profile
fi

chkconfig php-fpm on
service php-fpm restart
echo "FINISHED PHP SECTION!"

# ----------------------------------------------------------------------------------------------------------------------

echo "STARTING NGINX SECTION..."
yum --enablerepo=remi install -y nginx

rm -f /etc/nginx/conf.d/default.conf
rm -f /etc/nginx/conf.d/virtual.conf
rm -f /etc/nginx/conf.d/vhost.conf
ln -s "${NGINX_VHOST_FILE}" /etc/nginx/conf.d/vhost.conf

chkconfig nginx on
service nginx restart
echo "FINISHED NGINX SECTION!"

# ----------------------------------------------------------------------------------------------------------------------

echo "STARTING MEMCACHED SECTION..."
yum --enablerepo=remi install -y memcached
chkconfig memcached on
service memcached restart
echo "FINISHED MEMCACHED SECTION!"

# ----------------------------------------------------------------------------------------------------------------------