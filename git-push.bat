@echo off
cd /d "C:\laragon\www\Informacion"
del ".git\MERGE_HEAD" 2>nul
del ".git\MERGE_MSG" 2>nul
git reset --hard HEAD
git pull origin main --no-edit
git push origin main
echo Push completado!
pause
