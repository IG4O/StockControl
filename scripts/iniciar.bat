@echo off
cd /d "%~dp0"
cd ..
cd docker
echo Iniciando sistema Dona Guio...
docker-compose up -d
echo Sistema iniciado com sucesso!
echo.
echo Acesse pelo navegador:
echo  -> http://localhost:8080
pause
