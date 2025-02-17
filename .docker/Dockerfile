FROM php:8.3-fpm


# Install dependencies and Composer
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    msmtp msmtp-mta \
    cron \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mysqli opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

    RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mysqli opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*


# RUN  docker-php-ext-install pdo pdo_mysql mysqli

# # Install additional tools if needed
# RUN apt-get update && apt-get install -y libpng-dev \
#     libjpeg-dev libfreetype6-dev zip git curl \
#     && docker-php-ext-configure gd --with-freetype --with-jpeg \
#     && docker-php-ext-install gd


# Install other necessary extensions or tools if needed
# RUN docker-php-ext-install mysqli

# Copy your configuration files
# Copy the custom php.ini file into the container
#COPY ./php/conf.d/custom.ini /usr/local/etc/php/conf.d/

COPY ./php/php.ini /usr/local/etc/php/conf.d/

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./mysql/backup.sh /usr/local/bin

RUN mkdir -p /var/www/html/web/sites/default &&  chmod 777 -R /var/www/html/web/sites/default
RUN chmod +x /usr/local/bin/backup.sh

COPY crontab /etc/cron.d/backup

RUN crontab /etc/cron.d/backup



# Set working directory
WORKDIR /var/www/html



# Set permissions
RUN chown -R www-data:www-data /var/www/html

# make folder writable
#RUN [ -d /var/www/html/web/sites/default ] && chmod 755 -R /var/www/html/web/sites/default
#RUN  chmod 755 -R web/sites/default/