# Sử dụng hình ảnh PHP 8.2 chính thức
FROM mcr.microsoft.com/devcontainers/php:1-8.2-bookworm

# Cài đặt các phần mở rộng PHP cần thiết cho MySQL
RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
    && apt-get install -y default-mysql-client \
    && apt-get clean -y && rm -rf /var/lib/apt/lists/*

# Cài đặt php-mysql driver
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Cài đặt Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
