# Dockerfile

# Utilisez une image Symfony prédéfinie basée sur PHP
FROM php:8.1-fpm

# Installation des dépendances
RUN apt-get update && \
    apt-get install -y \
    curl \
    git \
    unzip \
    locales && \
    echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    locale-gen

# Installation des extensions PHP nécessaires
RUN pecl install mongodb && \
    docker-php-ext-enable mongodb && \
    docker-php-ext-install pdo pdo_mysql

# Installation de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Exposition du port 8000 (ou le port que vous avez configuré dans votre application Symfony)
EXPOSE 8000

# Commande par défaut pour démarrer PHP-FPM
CMD ["php-fpm"]
