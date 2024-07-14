FROM php:8.2-fpm

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    nginx \
    wget \
    zip \
    libonig-dev \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libpq-dev \
    pkg-config \
    patch \
    libzip-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-configure gd
RUN docker-php-ext-install gd pdo_pgsql pgsql


# Install Nging and copy local configs
RUN mkdir -p /run/nginx
COPY ./nginx/conf.d/app.conf /etc/nginx/nginx.conf
COPY ./nginx/startup.sh /etc/nginx/service_startup.sh

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www
RUN chown -R www:www /var
RUN chmod 777 /var
RUN chown -R www:www /run
RUN chmod 777 /run

# Change current user to www
USER www

RUN /usr/local/bin/composer install --no-dev
RUN php artisan key:generate
RUN php artisan config:clear

# Config Cache and optimize
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache
RUN php artisan optimize


# Expose port 9000 and start php-fpm server
EXPOSE 80
EXPOSE 443
EXPOSE 9000
#CMD ["php-fpm"]
CMD sh /etc/nginx/service_startup.sh
