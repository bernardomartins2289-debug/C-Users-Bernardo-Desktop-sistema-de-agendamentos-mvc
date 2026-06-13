#!/bin/bash
set -e

echo "Aguardando MySQL ficar pronto..."
until php -r "
try {
    \$pdo = new PDO('mysql:host=$DB_HOST;dbname=$DB_NAME', '$DB_USER', '$DB_PASS');
    exit(0);
} catch (Exception \$e) {
    exit(1);
}
" 2>/dev/null; do
    echo "MySQL ainda não está pronto, aguardando..."
    sleep 2
done

echo "MySQL pronto! Executando seed..."
php /var/www/html/database/seed.php

echo "Iniciando Apache..."
exec apache2-foreground
