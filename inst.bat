@echo off

REM Configuración de PHP en IIS

REM Descargar la compilación de PHP desde Web Platform Installer o el archivo zip desde http://windows.php.net/downloads/

REM Ruta SIN COMILLAS al directorio donde se ha descomprimido o instalado la carpeta de PHP
set phppath=C:\PHP\v7.4

REM Ruta CON COMILLAS de PHP para concatenar variables string
set phppath2="%phppath%"

REM Limpiar los manejadores actuales de PHP
"C:\Windows\System32\inetsrv\appcmd" clear config /section:system.webServer/fastCGI
REM El siguiente comando generará un mensaje de error si PHP no está instalado. Esto puede ser ignorado.
"C:\Windows\System32\inetsrv\appcmd" set config /section:system.webServer/handlers /-[name='PHP_via_FastCGI']

REM Instalar el manejador de PHP
"C:\Windows\System32\inetsrv\appcmd" set config /section:system.webServer/fastCGI /+[fullPath='%phppath2%\php-cgi.exe']
"C:\Windows\System32\inetsrv\appcmd" set config /section:system.webServer/handlers /+[name='PHP_via_FastCGI',path='*.php',verb='*',modules='FastCgiModule',scriptProcessor='%phppath2%\php-cgi.exe',resourceType='Unspecified']
"C:\Windows\System32\inetsrv\appcmd" set config /section:system.webServer/handlers /accessPolicy:Read,Script

REM Configurar las variables de FastCGI
"C:\Windows\System32\inetsrv\appcmd" set config -section:system.webServer/fastCgi /[fullPath='%phppath2%\php-cgi.exe'].monitorChangesTo:php.ini
"C:\Windows\System32\inetsrv\appcmd" set config -section:system.webServer/fastCgi /[fullPath='%phppath2%\php-cgi.exe'].activityTimeout:600
"C:\Windows\System32\inetsrv\appcmd" set config -section:system.webServer/fastCgi /[fullPath='%phppath2%\php-cgi.exe'].requestTimeout:600
"C:\Windows\System32\inetsrv\appcmd" set config -section:system.webServer/fastCgi /[fullPath='%phppath2%\php-cgi.exe'].instanceMaxRequests:10000
"C:\Windows\System32\inetsrv\appcmd".exe set config -section:system.webServer/fastCgi /+"[fullPath='%phppath%\php-cgi.exe'].environmentVariables.[name='PHP_FCGI_MAX_REQUESTS',value='10000']"
"C:\Windows\System32\inetsrv\appcmd".exe set config -section:system.webServer/fastCgi /+"[fullPath='%phppath%\php-cgi.exe'].environmentVariables.[name='PHPRC',value='%phppath%\php.ini']"

REM Agrega index.php como documento default
"C:\Windows\System32\inetsrv\appcmd" set config /section:defaultDocument /-files.[value='index.php']
"C:\Windows\System32\inetsrv\appcmd" set config /section:defaultDocument /+files.[value='index.php']