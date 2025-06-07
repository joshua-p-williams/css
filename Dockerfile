FROM php:7.2-fpm

# Set working directory
WORKDIR /var/www

# Copy composer files early for cache
COPY composer.lock composer.json /var/www/

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    gnupg \
    ca-certificates

# --- Install Node.js 14 (instead of 18) ---
RUN curl -fsSL https://deb.nodesource.com/setup_14.x | bash - && \
    apt-get install -y nodejs

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# Configure and install GD
RUN docker-php-ext-configure gd \
    --with-freetype-dir=/usr/include/ \
    --with-jpeg-dir=/usr/include/ && \
    docker-php-ext-install gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php \
    -- --install-dir=/usr/local/bin --filename=composer

# Create app user and assign ownership
RUN groupadd -g 1000 www && \
    useradd -u 1000 -ms /bin/bash -g www www

# Copy application code and set ownership
COPY . /var/www
COPY --chown=www:www . /var/www

# Switch to non-root user
USER www

# Expose PHP-FPM port and start the process
EXPOSE 9000
CMD ["php-fpm"]
