#!/bin/bash

service mysqld start
mysql -u root -e "GRANT ALL ON *.* TO root@'%' IDENTIFIED BY '' WITH GRANT OPTION;"
mysql -u root -e "CREATE DATABASE IF NOT EXISTS project CHARACTER SET 'utf8';"

/usr/bin/supervisord -c /supervisord.conf