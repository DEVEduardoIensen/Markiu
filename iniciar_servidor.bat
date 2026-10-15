@echo off
set "PATH=C:\php;%PATH%"
echo Iniciando servidor PHP em http://localhost:8000 ...
echo Pressione Ctrl+C para parar o servidor.
echo.
php -S localhost:8000
