# !/bin/bash

echo "Clonando..."
echo ""
git clone "https://github.com/luciobian/forum-tdd.git"

echo ""
echo ""

cd forum-tdd/forum 

echo "Instalando dependencias.."
echo ""
composer install

chmod -R 777 storage bootstrap/cache

cp .env.example .env


php artisan key:generate
echo ""
read -p "Iniciar servicio de MySQL y luego presione ENTER para continuar" var
echo ""
if [ ${#var} -eq 0 ]; then
	mysql --user="root" --password=""  --execute="CREATE DATABASE laravel;"

	echo ""
	echo "Database 'laravel' creada..."

	php artisan migrate 

	echo ""
	echo "Tablas migradas..."

	echo ""
	php artisan db:fill
	echo "Tablas cargadas con datos aleatoreos..."
fi

echo " "
echo " "
echo "Ejecutando tests..."
echo "-----------------------"
echo ""
echo "" 
vendor/bin/phpunit
echo ""
echo ""
echo "-----------------------"

php artisan serve


