@echo off
set "PATH=C:\php;%PATH%"
echo Iniciando API PHP da Tarefa 2 em http://localhost:8000/tarefa2/api.php ...
echo.
cd ..
php -S localhost:8000
