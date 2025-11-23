# AGSuitePro

> Sistema de gestión integral para eventos y restaurantes con Laravel 10

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

## 📋 Descripción

**AGSuitePro** es una aplicación web full-stack desarrollada en Laravel que proporciona dos modos de operación distintos:

- **Modo Fichas**: Sistema de gestión de eventos con control de invitados, gastos y compras
- **Modo Mesas**: Sistema POS para restaurantes con gestión de mesas, camareros y comandas en tiempo real

## ✨ Características Principales

### 🎫 Modo Fichas (Eventos)

- **Gestión de Fichas de Eventos**
  - Creación y administración de eventos con múltiples tipos (bodas, comuniones, bautizos, etc.)
  - Control de fechas, horarios y menús
  - Asignación de responsables y notas

- **Control de Invitados**
  - Registro de asistentes con datos de contacto
  - Límites configurables de invitados por ficha
  - Sistema de cobro por invitado adicional
  - Primer invitado gratis (configurable)
  - Grupos de invitados con tarifa especial

- **Gestión de Consumos**
  - Añadir productos/servicios a fichas
  - Familias de productos organizadas visualmente
  - Imágenes de productos con lazy loading y caché
  - Control de stock en tiempo real
  - Lectura de códigos de barras

- **Control de Gastos**
  - Registro de gastos asociados a cada ficha
  - Categorización de gastos
  - Cálculo automático de rentabilidad

- **Sistema de Compras**
  - Gestión de proveedores
  - Registro de compras con recibos
  - Control de inventario automático

### 🍽️ Modo Mesas (Restaurante)

- **Grid Visual de Mesas**
  - Visualización en tiempo real del estado de todas las mesas
  - Estados: Libre, Ocupada, Cerrada
  - Código de colores intuitivo (verde, rojo, gris)
  - Información de camarero, comensales e importe en cada mesa

- **Gestión de Mesas**
  - Generación masiva de mesas con prefijo personalizable
  - Creación individual de mesas
  - Edición de descripción y número
  - Reordenamiento drag & drop (próximamente)
  - Eliminación de mesas (solo si están libres)

- **Flujo de Trabajo para Camareros**
  1. **Abrir Mesa**: Asignar número de comensales y tomar la mesa
  2. **Tomar Mesa**: Asumir el control de una mesa de otro camarero
  3. **Añadir Consumos**: Productos y servicios desde familias visuales
  4. **Cerrar Mesa**: Cobrar con múltiples métodos de pago y opción de propina
  5. **Liberar Mesa**: Resetear la mesa a estado libre

- **Panel de Estadísticas**
  - Mesas libres/ocupadas en tiempo real
  - Mis mesas activas
  - Mi facturación del turno

- **Control de Camareros**
  - Rol específico "Usuario Mesas" con menú simplificado
  - Acceso directo al grid desde el logo del navbar
  - Sin acceso a configuración ni gestión administrativa

### 💰 Sistema de Facturación e IVA

- **Gestión de Facturas**
  - Generación automática de facturas al cerrar mesas
  - Numeración secuencial automática por año
  - Datos del cliente (nombre, NIF/CIF, dirección)
  - Desglose completo de productos y servicios

- **Cálculo de IVA**
  - Sistema adaptado a precios PVP (con IVA incluido)
  - Cálculo automático de base imponible: `PVP / (1 + IVA/100)`
  - Soporte para múltiples tipos de IVA: 0%, 4%, 10%, 21%
  - Desglose detallado por tipo de IVA en facturas
  - Visualización de IVA en resúmenes de mesas

- **Facturación de Mesas**
  - Modal de facturación con datos del cliente opcionales
  - Generación de PDF con diseño profesional
  - Visualización de facturas emitidas con filtros por fecha
  - Búsqueda y consulta de facturas históricas
  - Estadísticas: total facturas, base imponible, total IVA, importe total

- **Gestión de Sitios Multi-tenant**
  - Datos fiscales por sitio: CIF, dirección, teléfono
  - Información del emisor en facturas
  - Logo personalizado por restaurante/negocio

### 📊 Informes y Reportes

#### Modo Fichas
- Balance de fichas por fechas
- Listado de fichas pendientes/cerradas
- Próximas reservas
- Productos más vendidos
- Facturación automática con envío por email

#### Modo Mesas
- Ventas por productos con desglose de IVA
- Ventas por camareros
- Ocupación de mesas
- Histórico de mesas cerradas
- Facturas emitidas con totales

### 🔐 Sistema de Permisos

- **Roles Integrados**: Administrador, Editor, Usuario, Usuario Mesas
- **Permisos Granulares**: Basado en Spatie Laravel Permission
- **Multi-sitio**: Soporte para múltiples restaurantes/eventos con base de datos independiente por sitio

### 📱 Notificaciones

- **Email**: Configuración SMTP personalizable por sitio
- **SMS**: Integración con Twilio
- **WhatsApp**: Mensajes automáticos vía Twilio WhatsApp API
- **Firebase Cloud Messaging**: Notificaciones push (en desarrollo)

### 🎨 Interfaz de Usuario

- **Diseño Responsive**: Bootstrap 5 con CSS Grid optimizado (3/4/5 columnas)
- **Temas Personalizables**: SCSS por sitio (app.scss, eldespiste.scss)
- **Optimización de Imágenes**:
  - Lazy loading nativo
  - Cache HTTP (1 año para imágenes, 1 mes para CSS/JS)
  - Cache busting con timestamps
  - Atributos width/height para prevenir layout shifts
- **Iconos**: Bootstrap Icons
- **Modo Oscuro**: (en desarrollo)

## 🚀 Instalación

### Requisitos Previos

- PHP >= 8.1
- Composer
- MySQL >= 8.0 o MariaDB >= 10.3
- Node.js >= 16.x (para compilar assets)
- Extensiones PHP: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath, GD

### Paso a Paso

1. **Clonar el repositorio**

```bash
git clone https://github.com/devit-gm/agsuitepro.git
cd agsuitepro
```

2. **Instalar dependencias**

```bash
composer install
npm install
```

3. **Configurar entorno**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurar base de datos**

Edita `.env` con tus credenciales:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=agsuitepro
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña

# Base de datos por sitio (multi-tenancy)
DB_DATABASE_SITE=agsuitepro_site1
```

5. **Ejecutar migraciones**

```bash
php artisan migrate --seed
```

6. **Compilar assets**

```bash
npm run dev      # Desarrollo
npm run build    # Producción
```

7. **Configurar permisos**

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

8. **Configurar servidor web**

Para Apache, asegúrate de que el DocumentRoot apunte a la carpeta `public/` y que `mod_rewrite` esté habilitado.

Copia `public/htaccess.txt` a `public/.htaccess` si no existe.

9. **Iniciar servidor de desarrollo**

```bash
php artisan serve
```

Accede a `http://localhost:8000`

### Credenciales por Defecto

```
Email: admin@agsuitepro.com
Password: admin123
```

**⚠️ IMPORTANTE**: Cambia estas credenciales inmediatamente en producción.

## ⚙️ Configuración

### Modo de Operación

Configura el modo desde **Ajustes** en la interfaz web o directamente en base de datos:

**Modo Fichas (Eventos)**:
```sql
UPDATE ajustes SET modo_operacion = 'fichas';
UPDATE ajustes SET mostrar_usuarios = 1;
UPDATE ajustes SET mostrar_gastos = 1;
UPDATE ajustes SET mostrar_compras = 1;
```

**Modo Mesas (Restaurante)**:
```sql
UPDATE ajustes SET modo_operacion = 'mesas';
UPDATE ajustes SET mostrar_usuarios = 0;
UPDATE ajustes SET mostrar_gastos = 0;
UPDATE ajustes SET mostrar_compras = 0;
```

### Generar Mesas Iniciales

Desde la interfaz en **Mesas > Generar Mesas** o con el seeder:

```bash
php artisan db:seed --class=MesasSeeder
```

Esto crea 20 mesas por defecto en estado "libre".

### Configuración de Email

Edita en **Ajustes > Configuración de Email** o en `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=tu_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Configuración de SMS/WhatsApp (Twilio)

```env
TWILIO_SID=tu_account_sid
TWILIO_AUTH_TOKEN=tu_auth_token
TWILIO_PHONE_NUMBER=+34123456789
TWILIO_WHATSAPP_NUMBER=whatsapp:+34123456789
```

### Firebase (Notificaciones Push)

Coloca tu archivo de credenciales en `storage/firebase-credentials.json` (este archivo está en `.gitignore` por seguridad).

```env
FIREBASE_CREDENTIALS=storage/firebase-credentials.json
```

## 📖 Uso

### Modo Fichas

#### Crear una Ficha

1. Ir a **Fichas > Nueva Ficha**
2. Rellenar datos: tipo, fecha, hora, menú, responsables
3. Guardar

#### Añadir Invitados

1. Abrir ficha → **Asistentes**
2. Hacer clic en **+ Añadir Invitado**
3. Rellenar nombre, teléfono, email
4. Guardar

#### Añadir Consumos

1. Abrir ficha → **Lista**
2. Seleccionar familia de productos
3. Hacer clic en productos para añadir
4. Modificar cantidades con +/-

#### Registrar Gastos

1. Abrir ficha → **Gastos**
2. Hacer clic en **+ Añadir Gasto**
3. Rellenar concepto e importe
4. Guardar

#### Cerrar Ficha

1. Abrir ficha → **Resumen**
2. Revisar totales
3. Seleccionar método de pago
4. Hacer clic en **Enviar**
5. Opcionalmente marcar "Facturar" para envío por email

### Modo Mesas

#### Flujo Completo de Mesa

**1. Abrir Mesa**

- En el grid, hacer clic en una mesa verde (Libre)
- En el modal, introducir número de comensales
- Hacer clic en **Abrir Mesa**
- La mesa cambia a rojo (Ocupada) con tu nombre

**2. Añadir Consumos**

- Hacer clic en la mesa roja
- Ir a **Familias** → seleccionar familia
- Hacer clic en productos para añadir
- Volver a **Lista** para revisar

**3. Cerrar Mesa**

- En el grid, hacer clic en la mesa ocupada
- Hacer clic en **Cerrar Mesa**
- Revisar consumos en el modal con desglose de IVA
- Seleccionar método de pago (efectivo, tarjeta, etc.)
- Opcionalmente añadir propina
- **Opcionalmente facturar**: marcar checkbox e introducir datos del cliente
- Hacer clic en **Cobrar**
- La mesa cambia a gris (Cerrada)
- Si se facturó, se genera PDF con desglose de IVA

**4. Liberar Mesa**

- Hacer clic en la mesa gris (Cerrada)
- Hacer clic en **Liberar**
- La mesa vuelve a verde (Libre)

#### Gestión de Mesas (Admin)

**Generar Mesas en Lote**
- Ir a **Mesas** (botón en navbar superior)
- Hacer clic en **Generar Mesas**
- Establecer prefijo (ej: "Mesa ") y cantidad (ej: 15)
- Hacer clic en **Generar**

**Editar Mesa**
- Hacer clic en el icono de lápiz (esquina superior derecha de la mesa)
- Modificar descripción o número
- Guardar

**Eliminar Mesa**
- Solo posible si está en estado "Libre"
- Hacer clic en el icono de papelera
- Confirmar eliminación

## 🗂️ Estructura del Proyecto

```
agsuitepro/
├── app/
│   ├── Console/           # Comandos Artisan
│   ├── Enums/            # Enumeraciones (EstadoMesa, TipoFicha, etc.)
│   ├── Exceptions/       # Manejadores de excepciones
│   ├── Http/
│   │   ├── Controllers/  # Controladores principales
│   │   │   ├── FichasController.php      # Fichas + Mesas
│   │   │   ├── FacturaMesaController.php # Facturación de mesas
│   │   │   ├── ProductosController.php   # Productos
│   │   │   ├── FamiliasController.php    # Familias
│   │   │   ├── UsuariosController.php    # Usuarios
│   │   │   ├── InformesController.php    # Reportes
│   │   │   ├── AjustesController.php     # Configuración
│   │   │   ├── SitiosController.php      # Gestión multi-tenant
│   │   │   ├── WhatsAppController.php    # WhatsApp API
│   │   │   └── SmsController.php         # SMS Twilio
│   │   ├── Middleware/   # Middlewares (DetectSite, VerificarRol)
│   │   └── Kernel.php    # Registro de middlewares
│   ├── Models/           # Modelos Eloquent
│   │   ├── Ficha.php     # Fichas/Mesas con scopes
│   │   ├── FacturaMesa.php # Facturas con cálculo de IVA
│   │   ├── Producto.php  # Con métodos baseImponible() e importeIva()
│   │   ├── Servicio.php  # Con métodos baseImponible() e importeIva()
│   │   ├── Familia.php
│   │   ├── User.php
│   │   ├── Ajustes.php
│   │   ├── Site.php      # Gestión multi-tenant
│   │   └── ...
│   ├── Providers/        # Service Providers
│   ├── Services/         # Servicios (TwilioService, etc.)
│   └── helpers.php       # Funciones globales (fichaRoute, cachedImage)
├── config/
│   ├── app.php           # Configuración general
│   ├── database.php      # Conexiones DB (central + site)
│   ├── permission.php    # Spatie Permissions
│   ├── services.php      # APIs externas (Twilio, Firebase)
│   └── twilio.php        # Configuración Twilio
├── database/
│   ├── migrations/       # Migraciones de base de datos
│   ├── seeders/          # Seeders (MesasSeeder, RolesSeeder)
│   └── factories/        # Factories para testing
├── public/
│   ├── css/              # CSS compilado
│   ├── js/               # JavaScript compilado
│   ├── images/           # Imágenes públicas
│   ├── .htaccess         # Configuración Apache con cache
│   └── index.php         # Entry point
├── resources/
│   ├── css/              # CSS fuente
│   ├── js/
│   │   └── app.js        # JavaScript principal (Bootstrap, listeners)
│   ├── sass/
│   │   ├── app.scss      # Estilos globales
│   │   └── eldespiste.scss # Tema personalizado
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php   # Layout principal
│   │   ├── fichas/
│   │   │   ├── index.blade.php # Lista de fichas
│   │   │   ├── create.blade.php
│   │   │   ├── edit.blade.php
│   │   │   ├── lista.blade.php # Consumos
│   │   │   ├── familias.blade.php
│   │   │   ├── productos.blade.php
│   │   │   ├── usuarios.blade.php # Invitados
│   │   │   ├── gastos.blade.php
│   │   │   ├── resumen.blade.php # Con desglose de IVA
│   │   │   ├── mesas-grid.blade.php # Grid de mesas
│   │   │   ├── pdf-mesa.blade.php # Plantilla PDF factura
│   │   │   └── modales/
│   │   │       ├── abrir-mesa.blade.php
│   │   │       ├── cerrar-mesa.blade.php # Con facturación
│   │   │       └── facturar-mesa.blade.php
│   │   ├── facturas/
│   │   │   ├── index.blade.php # Listado de facturas
│   │   │   └── show.blade.php  # Detalle de factura
│   │   ├── productos/
│   │   ├── familias/
│   │   ├── usuarios/
│   │   ├── ajustes/
│   │   └── informes/
│   └── lang/
│       ├── es.json        # Traducciones español
│       └── es/            # Traducciones Laravel
├── routes/
│   ├── web.php           # Rutas web principales
│   ├── api.php           # Rutas API (futuro)
│   └── channels.php      # Broadcasting (futuro)
├── storage/
│   ├── app/              # Archivos subidos
│   ├── logs/             # Logs Laravel
│   └── framework/        # Cache, sessions, views compiladas
├── tests/                # Tests unitarios y feature
├── .env                  # Variables de entorno (NO en Git)
├── .gitignore            # Archivos ignorados por Git
├── composer.json         # Dependencias PHP
├── package.json          # Dependencias Node.js
├── vite.config.js        # Configuración Vite
├── webpack.mix.js        # Mix (legacy)
└── README.md             # Este archivo
```

## 🛠️ Tecnologías

### Backend
- **Laravel 10**: Framework PHP moderno con routing, ORM, autenticación
- **PHP 8.1+**: Tipado fuerte, enums, atributos
- **MySQL/MariaDB**: Base de datos relacional
- **Eloquent ORM**: Gestión de modelos y relaciones

### Frontend
- **Bootstrap 5**: Framework CSS responsive
- **Blade Templates**: Motor de plantillas de Laravel
- **JavaScript Vanilla**: Sin frameworks pesados, listeners nativos
- **Bootstrap Icons**: Iconografía
- **CSS Grid**: Layouts modernos y flexibles

### Integraciones
- **Twilio**: SMS y WhatsApp Business API
- **Firebase**: Notificaciones push (FCM)
- **DomPDF**: Generación de PDFs
- **Snappy/wkhtmltopdf**: PDFs avanzados con HTML/CSS

### Herramientas
- **Composer**: Gestor de dependencias PHP
- **npm**: Gestor de paquetes Node.js
- **Vite**: Build tool y HMR para desarrollo
- **Laravel Mix**: Alternativa a Vite (legacy)
- **Git**: Control de versiones

## 🔒 Seguridad

- **Autenticación**: Laravel Sanctum + sesiones
- **Autorización**: Spatie Laravel Permission con roles y permisos
- **Protección CSRF**: Tokens en formularios
- **Validación**: Request validation en controladores
- **Sanitización**: Htmlspecialchars en vistas Blade
- **Credenciales**: Variables de entorno en `.env` (no versionado)
- **Firebase Credentials**: Archivo JSON en `.gitignore`
- **HTTPS**: Recomendado en producción con certificado SSL

### Buenas Prácticas Implementadas

- `.env` y `*.key` en `.gitignore`
- `storage/firebase-credentials.json` excluido de Git
- Regenerar `APP_KEY` en cada instalación
- Usar contraseñas seguras y 2FA para cuentas admin
- Mantener Laravel y dependencias actualizadas

## 📊 Base de Datos

### Tablas Principales

#### `users`
Usuarios del sistema con roles (Admin, Editor, Usuario, Usuario Mesas).

#### `fichas`
Núcleo del sistema. Almacena fichas de eventos O mesas de restaurante.

**Campos clave**:
- `tipo`: Tipo de ficha (1-Boda, 2-Comunión, etc.) o 5-Mesa
- `modo`: `'ficha'` o `'mesa'`
- `estado`: 0-Pendiente, 1-Confirmada, 2-Cerrada, 3-Cancelada
- `estado_mesa`: `'libre'`, `'ocupada'`, `'cerrada'` (solo modo mesas)
- `numero_mesa`: Identificador de mesa (VARCHAR)
- `camarero_id`: Usuario asignado a la mesa
- `numero_comensales`: Cantidad de personas
- `hora_apertura`, `hora_cierre`: Timestamps de apertura/cierre

#### `facturas_mesa`
Facturas generadas al cerrar mesas.

**Campos clave**:
- `numero_factura`: Numeración secuencial (ej: 2025/00001)
- `ficha_id`: Relación con la mesa
- `fecha`: Fecha de emisión
- `cliente_nombre`, `cliente_nif`: Datos del cliente
- `subtotal`: Base imponible total
- `total_iva`: Suma de todas las cuotas de IVA
- `total`: Importe total a pagar
- `detalles`: JSON con líneas de detalle, desglose de IVA y datos de mesa

#### `fichas_productos`
Relación muchos-a-muchos entre fichas y productos con cantidad y precio.

#### `fichas_servicios`
Relación muchos-a-muchos entre fichas y servicios.

#### `fichas_usuarios`
Invitados/asistentes de una ficha (modo fichas).

#### `fichas_gastos`
Gastos asociados a fichas (modo fichas).

#### `productos`
Catálogo de productos con stock, precio, imagen, familia.

#### `familias`
Categorías de productos con imagen.

#### `servicios`
Servicios adicionales (DJ, fotografía, etc.).

#### `recibos`
Recibos de compra a proveedores.

#### `ajustes`
Configuración global del sitio (modo_operacion, precios, SMTP, etc.).

#### `sitios`
Gestión multi-tenant con datos fiscales.

**Campos clave**:
- `nombre`: Nombre del negocio
- `dominio`: Dominio del sitio
- `cif`: CIF/NIF fiscal
- `direccion`: Dirección completa
- `telefono`: Teléfono de contacto
- `db_host`, `db_name`, `db_user`, `db_password`: Conexión a base de datos del sitio
- `mail_*`: Configuración SMTP específica del sitio
- `ruta_logo`, `ruta_logo_nav`: Rutas a logos personalizados

#### `permissions`, `roles`, `role_has_permissions`, `model_has_roles`
Sistema de permisos de Spatie.

### Migraciones Importantes

- `create_fichas_table`: Estructura base de fichas/mesas
- `add_mesas_fields_to_fichas`: Campos para modo mesas (estado_mesa, camarero_id, etc.)
- `create_productos_table`, `create_familias_table`: Catálogo con IVA
- `create_fichas_productos_table`: Pivot para consumos
- `create_ajustes_table`: Configuración
- `create_facturas_mesa_table`: Sistema de facturación
- `add_fiscal_fields_to_sitios_table`: CIF, dirección y teléfono para sitios

## 🧪 Testing

```bash
# Ejecutar todos los tests
php artisan test

# Tests específicos
php artisan test --filter=FichasTest
php artisan test --filter=MesasTest

# Con coverage
php artisan test --coverage
```

## 📦 Despliegue

### Requisitos del Servidor

- PHP >= 8.1 con extensiones requeridas
- MySQL >= 8.0
- Apache con mod_rewrite o Nginx
- Composer
- SSL/TLS (certificado HTTPS)

### Pasos de Despliegue

1. **Subir archivos al servidor** (excluir `node_modules`, `.env`, `storage/app`)

2. **Clonar repositorio o FTP**

```bash
git clone https://github.com/devit-gm/agsuitepro.git /var/www/agsuitepro
cd /var/www/agsuitepro
```

3. **Configurar `.env` en producción**

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tudominio.com

DB_DATABASE=tu_base_datos_produccion
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña_segura
```

4. **Instalar dependencias**

```bash
composer install --optimize-autoloader --no-dev
```

5. **Compilar assets**

```bash
npm ci
npm run build
```

6. **Optimizar aplicación**

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

7. **Permisos**

```bash
chown -R www-data:www-data /var/www/agsuitepro
chmod -R 755 /var/www/agsuitepro
chmod -R 775 storage bootstrap/cache
```

8. **Configurar Virtual Host (Apache)**

```apache
<VirtualHost *:80>
    ServerName tudominio.com
    DocumentRoot /var/www/agsuitepro/public

    <Directory /var/www/agsuitepro/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/agsuitepro_error.log
    CustomLog ${APACHE_LOG_DIR}/agsuitepro_access.log combined
</VirtualHost>
```

9. **Certificado SSL con Let's Encrypt**

```bash
sudo apt install certbot python3-certbot-apache
sudo certbot --apache -d tudominio.com
```

10. **Cron para tareas programadas**

```bash
crontab -e
# Añadir:
* * * * * cd /var/www/agsuitepro && php artisan schedule:run >> /dev/null 2>&1
```

## 🤝 Contribución

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama feature (`git checkout -b feature/nueva-funcionalidad`)
3. Commit tus cambios (`git commit -m 'Añadir nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Abre un Pull Request

### Estándares de Código

- Seguir PSR-12 para PHP
- Documentar funciones con PHPDoc
- Escribir tests para nuevas funcionalidades
- Usar nombres descriptivos en inglés para código, español para UI

## 🐛 Reporte de Bugs

Si encuentras un bug, por favor abre un issue en GitHub con:

- Descripción detallada del problema
- Pasos para reproducir
- Comportamiento esperado vs. actual
- Capturas de pantalla (si aplica)
- Versión de Laravel, PHP y navegador

## 📄 Licencia

Este proyecto está bajo la licencia MIT. Ver el archivo [LICENSE](LICENSE) para más detalles.

## 👥 Autores

- **David Gómez** - *Desarrollo principal* - [@devit-gm](https://github.com/devit-gm)

## 🙏 Agradecimientos

- Laravel Framework por su elegante sintaxis
- Bootstrap por el sistema de diseño
- Spatie por Laravel Permission
- Twilio por las APIs de comunicación
- Comunidad open source por inspiración y soporte

## 📞 Soporte

Para preguntas y soporte:

- **Email**: davgomruiz@gmail.com
- **GitHub Issues**: https://github.com/devit-gm/agsuitepro/issues
- **Documentación**: https://github.com/devit-gm/agsuitepro/wiki

---

**Desarrollado con ❤️ en España** 

**Versión**: 2025 Noviembre con Sistema de Facturación e IVA

### 📝 Changelog

#### v2025.11 - Sistema de Facturación e IVA
- ✨ Sistema completo de facturación para mesas
- ✨ Cálculo automático de IVA desde precios PVP
- ✨ Desglose de IVA por tipo (0%, 4%, 10%, 21%)
- ✨ Generación de PDFs con diseño profesional
- ✨ Gestión de facturas emitidas con filtros
- ✨ Datos fiscales por sitio (CIF, dirección, teléfono)
- 🐛 Corrección de cálculos de IVA en informes
- 🐛 Protección de consultas en layout para sitio central
- 🎨 Interfaz responsive optimizada para móviles
- 🎨 Diseño mejorado de modales y formularios

#### v2025.11 - Modo Mesas y Control de Stock
- ✨ Grid visual de mesas con estados en tiempo real
- ✨ Gestión completa de mesas (abrir, cerrar, liberar)
- ✨ Control de stock automático
- ✨ Lectura de códigos de barras
- ✨ Panel de estadísticas para camareros
- 🎨 Optimización de imágenes con lazy loading y cache
