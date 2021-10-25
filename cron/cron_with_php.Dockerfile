FROM php:8.0-fpm

# Copy composer.lock and composer.json
#COPY ./src/ /var/www/

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    #libpng-dev \
    libzip-dev \
    libonig-dev \
    #libjpeg62-turbo-dev \
    #libfreetype6-dev \
    locales \ 
    zip 
    #jpegoptim optipng pngquant gifsicle \
    #vim \
    #unzip \
    #git \
    #curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
#RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
#RUN docker-php-ext-configure gd --with-jpeg=/usr/include/ --with-freetype=/usr/include/
#RUN docker-php-ext-install gd



# -----------------------------------
# add cron
RUN apt-get update && apt-get -y install cron
# Copy cron file to the cron.d directory
COPY cron/cron-cars /etc/cron.d/cron-cars
# Give execution rights on the cron job
RUN chmod 0644 /etc/cron.d/cron-cars
# Apply cron job
RUN crontab /etc/cron.d/cron-cars
# Create the log file to be able to run tail
RUN touch /var/log/cron.log


# Run the command on container startup
CMD cron && tail -f /var/log/cron.log
#CMD ["crond", "-f"]
# -----------------------------------

# Add user for laravel application
#RUN groupadd -g 1000 www
#RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
#COPY . /var/www

# Copy existing application directory permissions
#COPY --chown=www:www . /var/www



# Change current user to www
#USER www

# Expose port 9000 and start php-fpm server
#EXPOSE 9000
#CMD ["php-fpm"]

