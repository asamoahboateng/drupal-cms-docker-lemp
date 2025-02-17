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
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mysqli \
    && docker-php-ext-install opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN apt-get update && apt-get install -y msmtp msmtp-mta
RUN apt-get update &&  apt-get install -y cron

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY mysql/backup.sh /usr/local/bin

RUN chmod +x /usr/local/bin/backup.sh

COPY crontab /etc/cron.d/backup

RUN crontab /etc/cron.d/backup

# Set working directory
WORKDIR /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html