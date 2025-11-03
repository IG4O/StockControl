@echo off
cd /d "%~dp0"
cd ..
cd docker

echo ========================================
echo Executando atualizacao no banco de dados
echo ========================================

cmd /c "docker exec -i stockcontrol_db psql -U postgres -d guiodb < ../migrations/update.sql"

echo.
echo Atualizacao concluida com sucesso!
pause
