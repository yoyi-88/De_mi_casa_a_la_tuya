# Especificaciones de Infraestructura - DMCALT

Este documento detalla los entornos y configuraciones técnicas necesarias para el despliegue y funcionamiento de la plataforma "De Mi Casa a la Tuya".

## 1. Entorno de Desarrollo (Local)

El desarrollo íntegro de la aplicación se ha realizado bajo una arquitectura basada en Windows para garantizar la compatibilidad con las herramientas de diseño y oficina requeridas por el ciclo.

* **Sistema Operativo:** Windows 11 Home/Pro.
* **Servidor Local:** XAMPP v8.x.
* **Stack Tecnológico:**
  * **Apache:** Servidor web encargado de gestionar las peticiones locales.
  * **PHP:** Versión 8.1/8.2 con extensiones `pdo_mysql`, `openssl` y `mbstring` activas.
  * **Base de Datos:** MariaDB (Gestionada mediante phpMyAdmin).
* **IDE:** Visual Studio Code con soporte para Git.

## 2. Entorno de Producción (Hosting)

Para el despliegue final se ha optado por una solución de hosting compartido que permite evaluar la portabilidad del código entre sistemas operativos (Windows -> Linux).

* **Proveedor:** InfinityFree (Hosting Gratuito).
* **Servidor Operativo:** Linux (Ubuntu/Debian basado).
* **Panel de Control:** VistaPanel / cPanel simplificado.
* **Acceso a Archivos:** Protocolo FTP mediante cliente  **FileZilla** .

### Especificaciones del Servidor de Producción:

* **PHP:** Versión 8.2.2. (Nota: Se requiere declaración estricta de propiedades en las clases).
* **Base de Datos:** MariaDB 11.4.
* **Motor de Almacenamiento:** **MyISAM** (Nota: Integridad referencial gestionada por software en la capa de Modelo de PHP ante la falta de soporte de InnoDB).

## 3. Configuración del Servidor Web (.htaccess)

Se utiliza un archivo de configuración de Apache para gestionar el enrutamiento del patrón MVC y la seguridad de la conexión.

**Apache**

```
RewriteEngine On
RewriteBase /

# 1. Forzado de protocolo seguro (HTTPS)
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# 2. Front Controller: Redirección a index.php
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?url=$1 [L,QSA]
```

## 4. Servicios Externos e Integraciones

La aplicación depende de los siguientes servicios externos para su funcionalidad completa:

* **Servidor de Correo (SMTP):**
  * **Proveedor:** Gmail (Google Workspace).
  * **Protocolo:** TLS en Puerto 587.
  * **Autenticación:** Contraseñas de aplicación de Google (Seguridad reforzada).
* **CDNs (Content Delivery Networks):**
  * **Bootstrap 5:** Estilos y componentes de UI.
  * **Flatpickr:** Calendario interactivo de reservas.
  * **Chart.js:** Renderizado de estadísticas en el Dashboard.

## 5. Medidas de Seguridad Implementadas

* **SSL/TLS:** Certificado activo para cifrar el tráfico cliente-servidor.
* **Protección CSRF:** Tokens de sesión validados en cada petición POST.
* **Saneamiento de Datos:** Uso de `filter_var` y sentencias preparadas en PDO.
* **Hashing:** Contraseñas cifradas mediante el algoritmo `BCRYPT`.
