# Utiliser une image officielle de PHP 8 FPM
FROM php:8-fpm

# Définir le répertoire de travail dans le conteneur
WORKDIR /var/www/html

# Installer les dépendances nécessaires pour Symfony
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip

# Installer les extensions PHP nécessaires pour Symfony
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql zip

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copier les fichiers de l'application Symfony dans le conteneur
COPY . /var/www/html

# Installer les dépendances de l'application Symfony
#RUN composer install --no-cache --prefer-dist --no-dev --no-autoloader --no-scripts --no-progress

# Exposer le port 9000 pour PHP-FPM
EXPOSE 9000

# Commande par défaut pour démarrer PHP-FPM
CMD ["php-fpm"]
