$env:GIT_EDITOR = "cmd /c exit"
cd "c:\laragon\www\Informacion"

# Abort merge if in progress
git merge --abort 2>$null

# Reset y reintentar
git reset --hard HEAD 2>$null
git pull --no-edit origin main 2>$null
git push origin main 2>$null

Write-Host "Push completado!"
