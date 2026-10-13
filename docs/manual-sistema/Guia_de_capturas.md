# Capturas y diagramas por insertar

## 1. Características del equipo o servidor
Insertar la pantalla de información del equipo o máquina virtual mostrando procesador, memoria, sistema operativo y almacenamiento. Ocultar identificadores privados.

Pie sugerido: Figura 1. Características del equipo o servidor.

## 2. Versiones de PHP, Composer, Node y MySQL
Mostrar php -v, composer --version, node --version y SELECT VERSION() de la instalación real. No mostrar credenciales.

Pie sugerido: Figura 2. Versiones de PHP, Composer, Node y MySQL.

## 3. Extensiones PHP y archivo php.ini
Mostrar pdo_mysql en php -m y la ubicación de php.ini. Como complemento, insertar configuración de límites de carga y zona horaria; ocultar rutas privadas si corresponde.

Pie sugerido: Figura 3. Extensiones PHP y archivo php.ini.

## 4. Configuración del servidor web
Mostrar el VirtualHost o server block con raíz apuntando a la carpeta public, nombre del sitio y tratamiento de PHP. No incluir claves TLS privadas.

Pie sugerido: Figura 4. Configuración del servidor web.

## 5. Base de datos MySQL creada
Mostrar en Workbench o phpMyAdmin el nombre del esquema y su codificación/cotejamiento. Utilizar el nombre real del proyecto.

Pie sugerido: Figura 5. Base de datos MySQL creada.

## 6. Usuario y privilegios del esquema
Mostrar los privilegios asociados al esquema, sin contraseña ni información de otras bases.

Pie sugerido: Figura 6. Usuario y privilegios del esquema.

## 7. Instalación de dependencias
Mostrar el resultado correcto de composer install y npm ci, desde la carpeta de la rama funcional.

Pie sugerido: Figura 7. Instalación de dependencias.

## 8. Configuración de conexión MySQL en .env
Mostrar DB_CONNECTION=mysql, host, puerto, nombre de base y usuario. Sustituir la contraseña por asteriscos; ocultar APP_KEY y otras credenciales.

Pie sugerido: Figura 8. Configuración de conexión MySQL en .env.

## 9. Migraciones y tablas en MySQL
Mostrar php artisan migrate:status y el listado de tablas de la base real. Confirmar que se trata de MySQL y del esquema del proyecto.

Pie sugerido: Figura 9. Migraciones y tablas en MySQL.

## 10. Aplicación en ejecución
Mostrar la página inicial con URL del entorno autorizado y una consola de arranque si corresponde. Evitar exponer direcciones internas privadas.

Pie sugerido: Figura 10. Aplicación en ejecución.

## 11. Programador de tareas y colas
Mostrar php artisan schedule:list, el proceso de colas y la configuración cron o equivalente. No incluir contenido privado de mensajes.

Pie sugerido: Figura 11. Programador de tareas y colas.

## 12. Respaldo MySQL
Mostrar la herramienta o consola de respaldo con ejecución satisfactoria y nombre del archivo; ocultar usuarios privados y rutas sensibles.

Pie sugerido: Figura 12. Respaldo MySQL.

## 13. Restauración en esquema de prueba
Mostrar el esquema de prueba restaurado y una consulta de comprobación. No usar capturas de datos personales reales.

Pie sugerido: Figura 13. Restauración en esquema de prueba.

## 14. Registro de errores del sistema
Mostrar una entrada sanitizada de storage/logs/laravel.log con fecha, nivel y mensaje. Ocultar correos, tokens, datos bancarios y contraseñas.

Pie sugerido: Figura 14. Registro de errores del sistema.

## 15. Diagrama de arquitectura de la aplicación
Insertar un diagrama: navegador → rutas/middleware → controladores y Livewire → servicios → modelos Eloquent → MySQL. Añadir almacenamiento, correo y programador como componentes externos de operación.

Pie sugerido: Figura 15. Diagrama de arquitectura de la aplicación.

## 16. DFD de contexto
Mostrar los tres actores, el proceso Explora Candelaria y los flujos de datos: registro, consulta, gestión de oferta, reserva, revisión de pago y reportes.

Pie sugerido: Figura 16. DFD de contexto.

## 17. DFD de nivel 1
Descomponer autenticación, catálogo/publicaciones, reservas/pagos y reportes; conectar los almacenes usuarios, servicios, publicaciones y reservas de MySQL.

Pie sugerido: Figura 17. DFD de nivel 1.

## 18. Diagrama de red del despliegue real
Insertar navegador → servidor web/PHP → MySQL, con puertos y red solo si son confirmados. Añadir SMTP y servicios externos. Usar nombres genéricos en lugar de IP privadas sensibles.

Pie sugerido: Figura 18. Diagrama de red del despliegue real.

## 19. Diagrama entidad–relación en MySQL
Obtener o elaborar el ER desde el esquema real en Workbench. Mostrar users, emprendimientos, tipos/pivote/servicios, reservas/detalles, cuentas y publicaciones; señalar PK, FK y cardinalidades. Dividir en varias imágenes si no es legible.

Pie sugerido: Figura 19. Diagrama entidad–relación en MySQL.

## 20. Modelo relacional y claves foráneas
Mostrar las claves de reservas, reserva_detalles, servicios y emprendimiento_tipo_servicios desde Workbench o SHOW CREATE TABLE; incluir nombres y referencias de las FK.

Pie sugerido: Figura 20. Modelo relacional y claves foráneas.

## 21. Diccionario real de MySQL
Mostrar la estructura de una tabla central con nombre, tipo, tamaño, nulabilidad, PK y FK. Exportar las estructuras de las demás tablas para contrastar el diccionario completo.

Pie sugerido: Figura 21. Diccionario real de MySQL.

## 22. Diagrama de casos de uso
Insertar actores Turista, Administrador y Emprendedor con sus casos de uso dentro del límite del sistema. Diferenciar autenticación y permisos; no inventar módulos que no existen.

Pie sugerido: Figura 22. Diagrama de casos de uso.

## 23. Secuencia de registro y confirmación de correo
Mostrar turista → formulario → RegistroController → validación/caché → Mail → enlace de confirmación → User/rol. Reflejar la caducidad de 30 minutos sin mostrar tokens.

Pie sugerido: Figura 23. Secuencia de registro y confirmación de correo.

## 24. Secuencia de solicitud de reserva
Mostrar turista → Checkout → ReservaService → InventarioService/Eloquent → MySQL → resultado y aviso. Incluir transacción, validación de stock y creación de detalles.

Pie sugerido: Figura 24. Secuencia de solicitud de reserva.

## 25. Secuencia de comprobante y revisión
Mostrar turista → HistorialReservas → ReservaService → Storage/MySQL; después emprendedor → GestorReservas → cambio de estado. Separar la revisión humana de la tarea programada.

Pie sugerido: Figura 25. Secuencia de comprobante y revisión.

## 26. Interfaz pública e inicio de sesión
Página de inicio y formulario de acceso con los elementos principales.

Pie sugerido: Figura 26. Interfaz pública e inicio de sesión.

## 27. Interfaz del turista
Buscador, carrito/checkout e historial de reservas; separar cada pantalla si hace falta.

Pie sugerido: Figura 27. Interfaz del turista.

## 28. Interfaz del administrador
Panel y gestión de emprendimientos; como complemento, publicaciones y reportes.

Pie sugerido: Figura 28. Interfaz del administrador.

## 29. Interfaz del emprendedor
Gestión de servicios, detalle de reserva, revisión de comprobante y reportes.

Pie sugerido: Figura 29. Interfaz del emprendedor.

## 30. Interfaz de configuración de pago
Formulario de cuentas bancarias con datos ficticios y botón para guardar.

Pie sugerido: Figura 30. Interfaz de configuración de pago.

## 31. Código de las funciones principales
Mostrar fragmentos de ReservaService e InventarioService con firmas y reglas relevantes. Omitir configuración privada y no sustituir el código por ejemplos no implementados.

Pie sugerido: Figura 31. Código de las funciones principales.

## 32. Despliegue y acceso operativo
Mostrar la ejecución satisfactoria de migraciones y compilación, y una comprobación de acceso de la versión desplegada. Distinguir entorno de pruebas de producción.

Pie sugerido: Figura 32. Despliegue y acceso operativo.

## 33. Pruebas contra MySQL
Mostrar comandos, base de PRUEBAS y resultado actual. phpunit.xml puede usar una conexión de prueba distinta: configurar y verificar una base MySQL dedicada antes de ejecutar; RefreshDatabase puede eliminar/recrear tablas. Nunca apuntar las pruebas a producción.

Pie sugerido: Figura 33. Pruebas contra MySQL.