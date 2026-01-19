FROM php:8.2-fpm

# Установка системных зависимостей
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Установка PHP расширений
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    zip

# Настройка PHP
RUN echo "session.save_handler = files" >> /usr/local/etc/php/conf.d/sessions.ini \
    && echo "session.save_path = /tmp" >> /usr/local/etc/php/conf.d/sessions.ini \
    && echo "upload_max_filesize = 10M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 10M" >> /usr/local/etc/php/conf.d/uploads.ini

# Создание директории для сессий
RUN mkdir -p /tmp && chmod 777 /tmp

# Установка рабочей директории
WORKDIR /var/www/html

# Копирование файлов приложения
COPY . /var/www/html/

# Установка прав доступа
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 9000

CMD ["php-fpm"]




