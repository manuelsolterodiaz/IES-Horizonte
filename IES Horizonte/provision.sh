#!/bin/bash

echo "🔧 Actualizando paquetes..."
apt update

echo "📦 Instalando Apache, PHP y MariaDB..."
apt install -y apache2 mariadb-server php libapache2-mod-php php-mysql

echo "🚀 Habilitando servicios..."
systemctl enable apache2
systemctl enable mariadb
systemctl start apache2
systemctl start mariadb

echo "🔐 Configurando MariaDB..."
mysql -u root <<EOF
CREATE DATABASE ies_horizonte;
CREATE USER 'webuser'@'localhost' IDENTIFIED BY '123456Aa@';
GRANT ALL PRIVILEGES ON ies_horizonte.* TO 'webuser'@'localhost';
FLUSH PRIVILEGES;
EOF

echo "🌐 Creando página de prueba..."
cat <<EOPHP > /var/www/html/index.php
<?php
\$conexion = new mysqli("localhost", "webuser", "clave_segura", "ies_horizonte");
if (\$conexion->connect_error) {
    die("Error de conexión: " . \$conexion->connect_error);
}
echo "✅ Conexión exitosa a la base de datos!";
?>
EOPHP

echo "✅ Servidor web y base de datos listos"
