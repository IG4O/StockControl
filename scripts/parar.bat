@echo off
cd /d "%~dp0"
cd ..
cd docker
echo Parando o sistema Dona Guió...
docker-compose down
echo Sistema encerrado.
pause
