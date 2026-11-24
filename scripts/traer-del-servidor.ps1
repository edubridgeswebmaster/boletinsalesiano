# Trae al PC una copia de los archivos propios instalados en el servidor.
# Uso: abre PowerShell en C:\dev\www\boletinsalesiano y ejecuta:
#   .\scripts\traer-del-servidor.ps1
# Requiere el cliente OpenSSH de Windows (scp). Si el SSH del servidor no usa
# el puerto 22, cambia $Puerto.

$Servidor = "root@chianti.castelnuovo.net"
$Puerto   = 22
$Remoto   = "/home/b0let1n/public_html"
$Destino  = Join-Path $PSScriptRoot "..\servidor"

New-Item -ItemType Directory -Force -Path "$Destino\mu-plugins" | Out-Null

scp -P $Puerto "${Servidor}:${Remoto}/wp-content/mu-plugins/*.php" "$Destino\mu-plugins\"
scp -P $Puerto "${Servidor}:${Remoto}/.htaccess" "$Destino\htaccess.txt"
scp -P $Puerto "${Servidor}:${Remoto}/robots.txt" "$Destino\robots.txt"
scp -P $Puerto "${Servidor}:${Remoto}/wp-cache-constante.php" "$Destino\wp-cache-constante.php"

Write-Host "Copia actualizada en $Destino ($(Get-Date -Format 'dd/MM/yyyy HH:mm'))"
