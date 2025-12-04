# Sistema de Mesas para Restaurante - AGSuitePro

## 🎯 Características Implementadas

### Sistema Colaborativo de Mesas
- ✅ **Todos los camareros ven todas las mesas**
- ✅ **Cualquier camarero puede tomar una mesa de otro**
- ✅ **Estados de mesa**: Libre, Ocupada, Cerrada
- ✅ **Gestión completa**: Abrir, Gestionar, Cerrar y Liberar mesas
- ✅ **Vista de Ticket**: Consultar consumos de cualquier mesa desde el grid
- ✅ **Historial completo** de acciones por mesa
- ✅ **Estadísticas personales** por camarero
- ✅ **Auto-refresh** cada 30 segundos
- ✅ **Grid responsive** adaptable a móviles y tablets

---

## 📦 Instalación

### 1. Ejecutar Migraciones

```bash
php artisan migrate
```

Esto creará:
- Campos nuevos en tabla `fichas`: numero_mesa, numero_comensales, modo, estado_mesa, camarero_id, etc.
- Tabla `mesa_historial`: Para auditoría de acciones
- Campos en `ajustes`: modo_operacion, mostrar_usuarios, mostrar_gastos

### 2. Crear Mesas Iniciales

```bash
php artisan db:seed --class=MesasSeeder
```

Esto creará 20 mesas iniciales (puedes modificar el número en el seeder).

### 3. Configurar Modo de Operación

En la base de datos, tabla `ajustes`, establecer:

```sql
UPDATE ajustes SET modo_operacion = 'mesas' WHERE id = 1;
```

O desde PHP:
```php
$ajustes = Ajustes::first();
$ajustes->modo_operacion = 'mesas';
$ajustes->save();
```

---

## 🚀 Uso del Sistema

### Acceder al Grid de Mesas

Navegar a: `/mesas`

O usar la ruta nombrada:
```php
route('mesas.index')
```

### Flujo de Trabajo

1. **Abrir Mesa (Estado: Libre)**
   - Click en "Abrir Mesa"
   - Indicar número de comensales
   - Mesa pasa a estado "Ocupada" y se asigna al camarero actual

2. **Gestionar Mesa (Estado: Ocupada)**
   - Si es tu mesa: Click en "Gestionar"
   - Redirige a `/fichas/{uuid}/lista` (vista de productos/servicios)
   - Añadir consumos mediante escáner de código de barras o manualmente

3. **Tomar Mesa de Otro Camarero**
   - Si NO es tu mesa: Click en "Tomar Mesa"
   - Confirmar acción
   - La mesa pasa a ser tuya
   - El camarero anterior pierde el control

3.5. **Ver Ticket de Mesa**
   - Click en "Ver Ticket" desde cualquier mesa ocupada o cerrada
   - Se muestra modal con todos los productos y servicios
   - Detalle de cantidades, precios unitarios y subtotales
   - Total general y desglose de IVA
   - No requiere ser el camarero asignado

4. **Cerrar Mesa**
   - Click en "Cerrar y Cobrar"
   - Se muestra resumen de consumos
   - Seleccionar método de pago
   - Opcionalmente añadir propina
   - Mesa pasa a estado "Cerrada"

5. **Liberar Mesa (Estado: Cerrada)**
   - Click en "Liberar"
   - Mesa vuelve a estado "Libre"
   - Se eliminan los consumos

---

## 🎨 Interfaz Visual

### Estados de Mesa

| Estado | Color | Icono | Descripción |
|--------|-------|-------|-------------|
| **Libre** | Verde | ✓ | Disponible para abrir |
| **Ocupada** | Amarillo/Naranja | 👥 | En servicio con camarero |
| **Cerrada** | Gris | 🔒 | Cerrada, esperando limpieza |

### Indicadores Visuales

- **Badge "MÍA"**: Indica que la mesa es tuya (borde azul pulsante)
- **Filtros**: Todos / Libres / Ocupadas / Mis Mesas
- **Auto-refresh**: Contador de 30 segundos con opción de pausar
- **Estadísticas en footer**: Libres, Ocupadas, Mis Mesas, Mi Total

---

## 🔧 Archivos Creados/Modificados

### Migraciones
- `2025_11_21_000001_add_campos_mesa_to_fichas_table.php`
- `2025_11_21_000002_create_mesa_historial_table.php`
- `2025_11_21_000003_add_modo_operacion_to_ajustes_table.php`

### Modelos
- `app/Enums/EstadoMesa.php` (NUEVO)
- `app/Models/MesaHistorial.php` (NUEVO)
- `app/Models/Ficha.php` (MODIFICADO - añadidos campos y relaciones)
- `app/Models/Ajustes.php` (MODIFICADO - añadidos campos)

### Vistas
- `resources/views/fichas/mesas-grid.blade.php` (NUEVO)
- `resources/views/fichas/modales/abrir-mesa.blade.php` (NUEVO)
- `resources/views/fichas/modales/cerrar-mesa.blade.php` (NUEVO)

### Controlador
- `app/Http/Controllers/FichasController.php` (MODIFICADO - añadidos 6 métodos nuevos)

### Rutas
- `routes/web.php` (MODIFICADO - añadidas 6 rutas para mesas)

### Seeders
- `database/seeders/MesasSeeder.php` (NUEVO)

---

## 🔐 Permisos y Seguridad

### Reglas de Acceso

1. **Abrir Mesa**: Cualquier camarero puede abrir una mesa libre
2. **Tomar Mesa**: Cualquier camarero puede tomar una mesa ocupada de otro
3. **Gestionar Mesa**: Solo el camarero asignado puede gestionar sus mesas
4. **Cerrar Mesa**: Solo el camarero asignado (o admin) puede cerrar
5. **Liberar Mesa**: Solo el camarero asignado (o admin) puede liberar

### Historial y Auditoría

Toda acción queda registrada en `mesa_historial`:
- Quién abrió la mesa
- Quién la tomó (transferencias)
- Qué consumos se añadieron
- Quién la cerró
- Método de pago utilizado

---

## 📊 Estructura de Base de Datos

### Tabla `fichas` (campos nuevos)

| Campo | Tipo | Descripción |
|-------|------|-------------|
| numero_mesa | VARCHAR(10) | Número identificador de mesa |
| numero_comensales | INT | Cantidad de personas |
| modo | ENUM | 'ficha' o 'mesa' |
| estado_mesa | ENUM | 'libre', 'ocupada', 'cerrada' |
| camarero_id | BIGINT | ID del camarero asignado |
| hora_apertura | DATETIME | Cuándo se abrió la mesa |
| hora_cierre | DATETIME | Cuándo se cerró |
| ultimo_camarero_id | BIGINT | Último camarero (historial) |

### Tabla `mesa_historial`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | ID autoincremental |
| mesa_id | CHAR(36) | UUID de la mesa |
| accion | ENUM | 'abrir', 'tomar', 'añadir_consumo', 'cerrar', 'liberar' |
| camarero_id | BIGINT | Quién realizó la acción |
| camarero_anterior_id | BIGINT | En caso de transferencia |
| detalles | JSON | Información adicional |
| fecha_accion | DATETIME | Timestamp de la acción |

---

## 🎮 API Endpoints

### GET `/mesas`
Muestra el grid de mesas

### POST `/fichas/mesa/{mesaId}/abrir`
Abre una mesa libre
- **Body**: `numero_comensales`, `notas` (opcional)
- **Response**: JSON con success/message

### POST `/fichas/mesa/{mesaId}/tomar`
Toma una mesa de otro camarero
- **Response**: JSON con success/message

### GET `/fichas/mesa/{mesaId}/resumen`
Obtiene resumen de la mesa para modal de cierre
- **Response**: JSON con productos, servicios, importe

### POST `/fichas/mesa/{mesaId}/cerrar`
Cierra y cobra una mesa
- **Body**: `metodo_pago`, `propina` (opcional)
- **Response**: JSON con success/message

### POST `/fichas/mesa/{mesaId}/liberar`
Libera una mesa cerrada
- **Response**: JSON con success/message

---

## 🔄 Modo Dual: Fichas vs Mesas

El sistema soporta ambos modos:

### Modo Fichas (Eventos)
```sql
UPDATE ajustes SET modo_operacion = 'fichas';
```
- Vista tradicional de fichas de eventos
- Gestión de usuarios/invitados
- Gastos y compras

### Modo Mesas (Restaurante)
```sql
UPDATE ajustes SET modo_operacion = 'mesas';
UPDATE ajustes SET mostrar_usuarios = 0;
UPDATE ajustes SET mostrar_gastos = 0;
UPDATE ajustes SET mostrar_compras = 0;
```
- Grid visual de mesas
- Gestión de comensales
- Enfoque en consumos rápidos
- Oculta secciones de usuarios, gastos y compras

---

## 🐛 Troubleshooting

### Las mesas no aparecen
1. Verificar que existan registros en `fichas` con `modo = 'mesa'`
2. Ejecutar el seeder: `php artisan db:seed --class=MesasSeeder`

### Error al abrir mesa
1. Verificar que la migración se ejecutó correctamente
2. Revisar que `camarero_id` permite NULL
3. Verificar foreign keys están creadas

### No puedo tomar una mesa
1. Verificar que la mesa esté en estado 'ocupada'
2. Verificar que no seas el camarero actual de esa mesa

### Auto-refresh no funciona
1. Verificar que JavaScript está habilitado
2. Revisar consola del navegador por errores
3. Verificar que Bootstrap Modal está cargado

---

## 📱 Responsive Design

El grid se adapta automáticamente:

- **Desktop** (>768px): 4-5 mesas por fila
- **Tablet** (576-768px): 3 mesas por fila
- **Móvil** (<576px): 2 mesas por fila

---

## 🎯 Próximas Mejoras (Opcional)

- [ ] Notificaciones push cuando alguien toma tu mesa
- [ ] Vista de historial detallado por mesa
- [ ] Reservas de mesas con anticipación
- [ ] Asignación automática de mesas según comensales
- [ ] Reportes de productividad por camarero
- [ ] Integración con impresora de tickets
- [ ] App móvil nativa para camareros

---

## 📞 Soporte

Si encuentras algún problema o tienes sugerencias, contacta al desarrollador.

---

**¡Sistema de Mesas implementado exitosamente! 🎉**
