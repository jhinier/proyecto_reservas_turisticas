# Instrucciones para subir la aplicación a un servidor

Aplicación de reservas turísticas del GAD La Candelaria, desarrollada con Laravel 12, Livewire y Vite.

Esta guía utiliza un servidor Linux o un hosting con panel de administración y acceso a terminal. Los comandos del servidor se ejecutan desde la carpeta principal del proyecto, donde está el archivo `artisan`. Sustituya las rutas y los valores de ejemplo por los datos entregados por el proveedor.

## 1. Requisitos del servidor

- PHP 8.3 o superior compatible con `composer.lock`. Aunque el proyecto declara PHP 8.2 como mínimo, la versión instalada de `spatie/laravel-permission` requiere PHP 8.3.
- Extensiones PHP: PDO, `pdo_mysql`, ctype, DOM, fileinfo, filter, GD, hash, iconv, JSON, libxml, mbstring, OpenSSL, PCRE, session, SimpleXML, tokenizer, XML, XMLReader, XMLWriter, ZIP y zlib.
- Composer 2.
- MySQL o MariaDB, con una base de datos y un usuario asignado.
- Apache con reescritura de URL o Nginx configurado para Laravel y PHP-FPM.
- Dominio o subdominio con certificado HTTPS.
- Acceso a tareas programadas (cron).
- Acceso de salida al servidor SMTP del correo institucional.

Para compilar los estilos y JavaScript se necesita Node.js 22.12 o superior compatible con las dependencias y npm. La compilación puede realizarse en el equipo local; en ese caso no se necesita Node.js en el servidor.

## 2. Preparar los archivos

Antes de trasladar una instalación que ya contiene información, respalde la base de datos, el archivo `.env` y la carpeta `storage/app`, que contiene imágenes, documentos y comprobantes.

En el equipo local, desde la carpeta del proyecto, compile los archivos de producción:

```bash
npm ci
npm run build
```

Compruebe que se haya generado `public/build/manifest.json`.

Suba el proyecto al servidor mediante SFTP, el administrador de archivos del hosting o el procedimiento de despliegue del proveedor. Incluya `composer.json`, `composer.lock`, `.env.example`, `artisan`, las carpetas de la aplicación y `public/build`.

Al preparar la copia para subir:

- Excluya `.git`, `node_modules`, `vendor.rar`, registros y archivos temporales del entorno local.
- Cree el `.env` de producción en el servidor; las credenciales locales no deben publicarse.
- Instale `vendor` con Composer en el servidor, según el paso siguiente.
- Excluya `public/hot`, que corresponde al servidor de desarrollo de Vite.
- Excluya el enlace local `public/storage`; créelo nuevamente en el servidor.
- Conserve la estructura de `storage` y `bootstrap/cache`, sin copiar cachés locales de configuración, rutas o vistas.
- Si traslada los datos actuales, copie también los archivos de `storage/app` mediante un canal privado.

Ejemplo de ubicación del proyecto:

```text
/home/usuario/proyecto_reservas_turisticas
```

## 3. Instalar las dependencias de PHP

Desde la carpeta del proyecto en el servidor:

```bash
composer install --no-dev --prefer-dist --optimize-autoloader
composer check-platform-reqs --no-dev
```

Resuelva cualquier extensión o versión de PHP faltante antes de continuar. La versión de PHP de la terminal y la del dominio deben cumplir los mismos requisitos. Utilice `composer install` para respetar las versiones de `composer.lock`.

Si el hosting no tiene terminal, solicite al proveedor la ejecución de los comandos de Composer y Artisan. También se pueden preparar las dependencias en un entorno compatible con el servidor y subir `vendor`, pero siguen siendo necesarios los pasos de configuración, migraciones y tareas programadas.

## 4. Configurar el archivo `.env`

En una instalación nueva, cree el archivo a partir de la plantilla:

```bash
cp .env.example .env
```

Si ya existe un `.env` de producción, actualice sus valores conservando la clave de la aplicación. Configure, como mínimo:

```dotenv
APP_NAME="Turismo GAD La Candelaria"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://SU_DOMINIO

APP_LOCALE=es
APP_FALLBACK_LOCALE=es
APP_FAKER_LOCALE=es_ES

LOG_CHANNEL=daily
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE="NOMBRE_BASE_DE_DATOS"
DB_USERNAME="USUARIO_BASE_DE_DATOS"
DB_PASSWORD="CONTRASENA_BASE_DE_DATOS"

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_DOMAIN=null
SESSION_SECURE_COOKIE=true

CACHE_STORE=database
FILESYSTEM_DISK=public
QUEUE_CONNECTION=sync

VITE_APP_NAME="${APP_NAME}"
```

`SU_DOMINIO` y los valores en mayúsculas son marcadores: reemplácelos antes de publicar. El proveedor debe confirmar el servidor, el puerto y las credenciales de la base de datos. Si utiliza MariaDB puede configurar `DB_CONNECTION=mariadb`.

La zona horaria de la aplicación ya está definida como `America/Guayaquil` en `config/app.php`.

### Correo electrónico del GAD La Candelaria

**El correo electrónico y la clave para el envío de mensajes deben corresponder a la cuenta institucional del GAD La Candelaria. Estos datos deben ser proporcionados por el responsable del correo del GAD.**

Agregue o actualice las siguientes variables en el `.env` del servidor:

```dotenv
MAIL_MAILER=smtp
MAIL_SCHEME=smtp
MAIL_HOST="SERVIDOR_SMTP_DEL_CORREO_DEL_GAD"
MAIL_PORT=587
MAIL_USERNAME="CORREO_INSTITUCIONAL_DEL_GAD_LA_CANDELARIA"
MAIL_PASSWORD="CLAVE_QUE_GENERA_EL_CORREO_DEL_GAD_LA_CANDELARIA"
MAIL_FROM_ADDRESS="CORREO_INSTITUCIONAL_DEL_GAD_LA_CANDELARIA"
MAIL_FROM_NAME="GAD La Candelaria"
```

- `MAIL_USERNAME`: dirección completa del correo institucional del GAD La Candelaria.
- `MAIL_PASSWORD`: contraseña de esa cuenta o contraseña de aplicación, si el proveedor de correo la exige.
- `MAIL_FROM_ADDRESS`: la misma dirección institucional autorizada para enviar mensajes.
- `MAIL_HOST`, `MAIL_PORT` y `MAIL_SCHEME`: datos SMTP confirmados por el administrador del correo. El ejemplo utiliza el puerto 587 con STARTTLS; si el proveedor exige TLS implícito en el puerto 465, utilice `MAIL_SCHEME=smtps` y `MAIL_PORT=465`.

La configuración de este proyecto utiliza `MAIL_SCHEME`. Si existe `MAIL_URL`, compruebe que no esté sobrescribiendo los datos SMTP anteriores. El valor `MAIL_MAILER=log` solo registra mensajes y debe cambiarse a `smtp` para enviar correos reales.

Las credenciales reales se guardan únicamente en el `.env` del servidor o en el gestor de secretos del proveedor. No las escriba en esta guía ni las suba al repositorio.

## 5. Configurar la clave de la aplicación

Solo en una instalación completamente nueva, genere la clave:

```bash
php artisan key:generate --force
```

Si está trasladando una instalación existente, conserve su `APP_KEY` original y colóquela en el `.env` mediante un canal privado. No genere otra clave: los datos cifrados, incluida la configuración de autenticación de dos factores, dependen de ella.

## 6. Preparar la base de datos

Cree la base de datos y el usuario desde el panel del hosting o con ayuda del administrador del servidor. Asigne a ese usuario los permisos necesarios sobre la base de datos de la aplicación.

Si traslada la información actual, exporte la base de datos de origen e importe el respaldo en el servidor, incluida la tabla `migrations`. Mantenga el sitio de destino sin acceso público durante esta preparación.

Con los datos de conexión ya configurados, ejecute:

```bash
php artisan config:clear
php artisan migrate --force
```

### Datos iniciales: únicamente para una base de datos nueva

El archivo `database/seeders/permisos.php` crea los roles, permisos y una cuenta de superadministrador de prueba. **Antes de ejecutarlo, reemplace los datos de esa cuenta por los del responsable designado por el GAD y establezca una contraseña segura.**

Después, ejecute una sola vez:

```bash
php artisan db:seed --force
php artisan db:seed --class=TipoServicioSeeder --force
php artisan db:seed --class=TipoPublicacionSeeder --force
```

Los dos últimos comandos cargan los tipos de servicios y publicaciones, que no se ejecutan desde `DatabaseSeeder`. El seeder de permisos y el de tipos de publicaciones no están preparados para repetirse sobre datos ya existentes. Si importó la base de datos actual, omita estos comandos.

En producción conserve la información existente: no utilice `migrate:fresh`, `migrate:refresh` ni `db:wipe`.

## 7. Configurar almacenamiento y permisos

El usuario que ejecuta PHP debe poder escribir en `storage` y `bootstrap/cache`. En Linux, si el propietario y el grupo ya están configurados correctamente, puede ajustar los permisos con:

```bash
chmod -R 775 storage bootstrap/cache
```

Solicite al proveedor que confirme el propietario y el grupo adecuados para su hosting. Evite permisos `777`.

Cree el enlace para servir imágenes y documentos:

```bash
php artisan storage:link
```

En una migración, compruebe que los archivos respaldados estén en `storage/app/public` y que el enlace `public/storage` apunte al almacenamiento del servidor.

## 8. Configurar el dominio y HTTPS

La raíz pública del dominio debe apuntar a:

```text
/home/usuario/proyecto_reservas_turisticas/public
```

Configure esa ruta como `DocumentRoot` o raíz del sitio en el panel del hosting. El dominio debe servir `public/index.php`; la carpeta principal del proyecto contiene el `.env` y otros archivos privados.

- En Apache, conserve `public/.htaccess`, active `mod_rewrite` y permita las reglas de ese archivo.
- En Nginx, configure el controlador frontal con `try_files $uri $uri/ /index.php?$query_string` y conecte PHP-FPM según la configuración del servidor.
- Active el certificado HTTPS y la redirección de HTTP a HTTPS. `APP_URL` debe coincidir con la dirección final del sitio.
- Si el proveedor fija la raíz en `public_html`, solicite que el dominio apunte a la carpeta `public` del proyecto o que configure una disposición equivalente manteniendo el código privado fuera del acceso web.

## 9. Activar la revisión automática de reservas

La aplicación tiene una tarea en `routes/console.php` que ejecuta `ReservaService::procesarCancelacionesAutomaticas()` cada minuto. Configure una tarea cron con esa frecuencia:

```cron
* * * * * cd /home/usuario/proyecto_reservas_turisticas && /usr/bin/php artisan schedule:run >> /home/usuario/proyecto_reservas_turisticas/storage/logs/scheduler.log 2>&1
```

Reemplace la ruta del proyecto y `/usr/bin/php` por los valores del servidor. El ejecutable debe usar una versión compatible de PHP y el usuario del cron debe tener acceso al proyecto. Revise y rote el archivo `scheduler.log` como parte del mantenimiento.

Puede comprobar que Laravel reconoce la tarea con:

```bash
php artisan schedule:list
```

El ejemplo de `.env` utiliza `QUEUE_CONNECTION=sync`, por lo que los trabajos se ejecutan durante la petición. Si decide utilizar `QUEUE_CONNECTION=database`, configure además un trabajador permanente con Supervisor o el gestor de procesos del proveedor:

```bash
php artisan queue:work --tries=3 --timeout=60
```

## 10. Preparar las cachés y comprobar el sitio

Después de completar la configuración, las migraciones y los permisos:

```bash
php artisan config:cache
php artisan view:cache
```

Cada vez que cambie el `.env`, vuelva a ejecutar `php artisan config:cache`. Si utiliza trabajadores de cola, reinícielos con `php artisan queue:restart` después de actualizar código o configuración.

Antes de entregar el sitio, verifique:

- La página principal abre mediante HTTPS y carga correctamente estilos y JavaScript.
- La ruta `/up` responde correctamente; esta comprobación básica no sustituye las pruebas funcionales.
- El responsable del GAD puede iniciar sesión con su cuenta administrativa.
- Se pueden registrar usuarios y completar el flujo de reservas.
- Las imágenes, los documentos y los comprobantes se pueden subir y consultar.
- Una prueba de recuperación de contraseña llega a una cuenta de prueba autorizada, con el GAD La Candelaria como remitente.
- El cron se ejecuta cada minuto y procesa las reservas que cumplen las condiciones de cancelación automática.
- Los archivos `.env`, `composer.json` y `storage/logs` no son accesibles desde el navegador.

Si hay errores, consulte `storage/logs/laravel-AAAA-MM-DD.log` con la configuración `LOG_CHANNEL=daily` propuesta, además de los registros del servidor web. Mantenga `APP_DEBUG=false` en producción.

## 11. Actualizaciones posteriores

Respalde la base de datos y los archivos subidos antes de actualizar. Prepare el nuevo `public/build`, suba el código y conserve el `.env`, la `APP_KEY` y `storage/app` de producción.

Para una actualización con mantenimiento, ejecute en el servidor:

```bash
php artisan down
composer install --no-dev --prefer-dist --optimize-autoloader
composer check-platform-reqs --no-dev
php artisan config:clear
php artisan migrate --force
php artisan config:cache
php artisan view:cache
php artisan up
```

Si utiliza trabajadores de cola, reinícielos tras el despliegue. Ejecute `php artisan up` al terminar correctamente y compruebe nuevamente los flujos principales.
