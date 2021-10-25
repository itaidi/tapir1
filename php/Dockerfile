FROM php:8.0-fpm

# Copy composer.lock and composer.json
COPY ./src/ /var/www/

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libzip-dev \
    libonig-dev \
#    libjpeg62-turbo-dev \
#    libfreetype6-dev \
    locales \
    zip \
#    jpegoptim optipng pngquant gifsicle \
#    vim \
    unzip \
    git \
    curl \
    exif \
#   for mongo
    libcurl4-openssl-dev pkg-config libssl-dev \
    && pecl install mongodb && docker-php-ext-enable mongodb
 
# for mongo = exif,pcntl,sodium (включен с версии 7.2),zip,pdo, ssL

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
#RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
#RUN docker-php-ext-configure gd --with-jpeg=/usr/include/ --with-freetype=/usr/include/
#RUN docker-php-ext-install gd


# Работает не стабильно при запуке из Dockerfile
# Install composer
#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# run cd "$(pwd)/src"
# run composer install --ignore-platform-reqs --working-dir="$(pwd)/src"




# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
#COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www
# fix
run chown -R $USER:www /var/www/src/storage && chmod -R 775 /var/www/src/storage

# Change current user to www
USER www


# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]

