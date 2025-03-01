# Utiliser PHP 8.2 avec Apache
FROM php:8.2-apache

# Installer les dépendances et extensions nécessaires
RUN apt-get update && apt-get install -y lsb-release apt-transport-https ca-certificates \
    && curl -sSL https://packages.sury.org/php/README.txt | bash \
    && apt-get update \
    && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_pgsql \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installer Node.js et npm
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs

# Modifier le VirtualHost pour pointer vers le dossier 'public' de Laravel
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Installer Node.js et npm
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs

# Définir les permissions correctes
RUN chown -R www-data:www-data /var/www/html

# Exposer le port 80
EXPOSE 80

