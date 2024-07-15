#!/bin/sh
echo "Starting services..."
sed -i "s,LISTEN_PORT,$PORT,g" /etc/nginx/nginx.conf

php-fpm -D
echo "PHP service initiated"
# while ! nc -w 1 -z 127.0.0.1 9000; do sleep 0.1; done;
echo "Nginx Server is starting..."
nginx
