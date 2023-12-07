# Utilisez une image Symfony prédéfinie basée sur PHP
FROM php:8.1-fpm

# Installation des dépendances
RUN apt-get update && \
    apt-get install -y \
    curl \
    git \
    unzip \
    libssl-dev

# Installation des extensions PHP nécessaires
RUN pecl install mongodb && \
    docker-php-ext-enable mongodb && \
    docker-php-ext-install pdo pdo_mysql

# Installation de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copie des fichiers de l'application Symfony
WORKDIR /var/www/html
COPY . .

# Installation des dépendances Symfony
RUN composer install --no-scripts --no-interaction

# Exposition du port 9000 (par défaut pour PHP-FPM)
EXPOSE 9000

# Commande par défaut pour démarrer PHP-FPM
CMD ["php-fpm"]
