# 🏥 Sistema Médico Completo - Laravel 11

## 📋 Descripción General

Sistema integral de gestión médica desarrollado con Laravel 11, diseñado para:
- ✅ Gestión de pacientes
- ✅ Registro de consultas médicas
- ✅ Solicitud y seguimiento de exámenes
- ✅ Control de tratamientos
- ✅ Gestión de compras/inventario
- ✅ Administración de personal médico
- ✅ Reportes financieros y estadísticos

## 🚀 Características Principales

### 1. Módulo de Pacientes
- CRUD completo de pacientes
- Información médica: tipo de sangre, alergias, enfermedades crónicas
- Historial de consultas, exámenes y tratamientos
- Búsqueda por nombre o DNI

### 2. Módulo de Consultas
- Registro de consultas médicas
- Asignación de doctores por especialidad
- Seguimiento de motivo, diagnóstico y observaciones
- Estados: Programada, En Proceso, Concluida, Cancelada
- Autocomplete de pacientes en tiempo real

### 3. Módulo de Exámenes
- Solicitud de exámenes de laboratorio
- Registro de resultados
- Seguimiento por estado
- Tipos: Sangre, Orina, Rayos X, Ecografía, etc.
- Costo y fecha de realización

### 4. Módulo de Tratamientos
- Registro de tratamientos médicos
- Medicamentos e indicaciones
- Fechas de inicio y fin
- Estados con transiciones validadas
- Costo del tratamiento

### 5. Módulo de Compras
- Gestión de compras con múltiples ítems
- Detalles de productos por compra
- Cálculo automático de montos
- Estados: Pendiente, Aprobada, Recibida, Cancelada
- Exportación de datos

### 6. Módulo de Personal
- Registro de personal médico y administrativo
- Tipos: Doctor, Enfermero, Administrativo, Laboratorio
- Creación automática de usuarios
- Especialidades y contacto

### 7. Módulo de Reportes
- **Reporte de Pacientes:** Listado con estadísticas
- **Reporte de Consultas:** Filtrable por fecha y estado
- **Reporte Financiero:** Análisis de ingresos y gastos
- Gráficos dinámicos con Chart.js
- Exportación a CSV/Excel

## 🎯 Mejoras Implementadas

### Seguridad
- ✅ Autenticación integrada
- ✅ Validaciones de transición de estados
- ✅ CSRF protection en formularios
- ✅ Restricción de acceso por autenticación

### Experiencia de Usuario
- ✅ Autocomplete de pacientes en tiempo real
- ✅ Interfaz responsiva con Bootstrap 5
- ✅ Gráficos dinámicos con datos reales
- ✅ Validaciones de formularios lado servidor

### Datos
- ✅ Gráficos que cargan datos en tiempo real
- ✅ Cálculos automáticos (totales, márgenes)
- ✅ Transiciones de estados validadas
- ✅ Relaciones entre modelos definidas

## 🛠️ Stack Tecnológico

| Componente | Versión |
|-----------|---------|
| **Framework** | Laravel 11 |
| **PHP** | 8.3.28 |
| **Base de Datos** | MySQL 5.7+ |
| **Frontend** | Bootstrap 5.3 |
| **Gráficos** | Chart.js |
| **Iconos** | Bootstrap Icons |
| **ORM** | Eloquent |

## 📊 Estructura de Base de Datos

```
┌─────────────┐  ┌──────────────┐  ┌────────────┐
│  Pacientes  │  │    Personal  │  │    Users   │
├─────────────┤  ├──────────────┤  ├────────────┤
│ id          │  │ id           │  │ id         │
│ nombre      │  │ nombre       │  │ email      │
│ dni         │  │ email        │  │ password   │
│ alergias    │  │ tipo         │  │ name       │
│ sangre      │  │ especialidad │  └────────────┘
└──────┬──────┘  └──────┬───────┘
       │                 │
       ├─────────────┬───┘
       │             │
       ▼             ▼
  ┌─────────────┐ ┌──────────────┐
  │ Consultas   │ │ Compras      │
  └─────────────┘ └──────────────┘
       │
    ┌──┴──┐
    ▼     ▼
┌────────────────┐
│ Exámenes       │
│ Tratamientos   │
└────────────────┘
```

## 🔌 Endpoints de API

```
GET    /api/pacientes/search          - Búsqueda de pacientes
GET    /api/charts/data               - Datos para gráficos
```

## 👤 Usuarios de Prueba

**Admin:**
- Email: `admin@sistema.com`
- Password: `admin123`

**Doctor:**
- Email: `doctor@sistema.com`
- Password: `doctor123`

## 📁 Estructura de Carpetas

```
Prototipo/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php
│   │   ├── PacienteController.php
│   │   ├── ConsultaController.php
│   │   ├── ExamenController.php
│   │   ├── TratamientoController.php
│   │   ├── CompraController.php
│   │   ├── PersonalController.php
│   │   ├── ReporteController.php
│   │   └── ApiController.php
│   ├── Models/
│   │   ├── Paciente.php
│   │   ├── Personal.php
│   │   ├── Consulta.php
│   │   ├── Examen.php
│   │   ├── Tratamiento.php
│   │   ├── Compra.php
│   │   ├── DetalleCompra.php
│   │   └── User.php
│   └── Services/
│       └── PdfService.php
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── resources/views/
│   ├── layouts/
│   ├── reportes/
│   ├── pacientes/
│   ├── consultas/
│   ├── examenes/
│   ├── tratamientos/
│   ├── compras/
│   └── personal/
└── routes/
    └── web.php
```

## 🚀 Instalación y Ejecución

1. **Clonar/Descargar el proyecto**
   ```bash
   cd c:\laragon\www\Prototipo
   ```

2. **Instalar dependencias**
   ```bash
   composer install
   ```

3. **Configurar base de datos (.env)**
   ```
   DB_DATABASE=sistema_medico
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Ejecutar migraciones**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Iniciar servidor**
   ```bash
   php artisan serve
   ```

6. **Acceder a la aplicación**
   ```
   http://127.0.0.1:8000
   ```

## 📈 Estadísticas del Proyecto

| Métrica | Cantidad |
|---------|----------|
| Vistas Blade | 32 |
| Controladores | 9 |
| Modelos | 8 |
| Migraciones | 9 |
| Rutas de API | 2 |
| Módulos funcionales | 7 |
| Reportes | 3 |

## ✨ Futuras Mejoras

- [ ] Exportación a PDF de reportes
- [ ] Envío de email de recordatorios
- [ ] Autenticación de dos factores
- [ ] Sistema de permisos por rol
- [ ] Notificaciones en tiempo real
- [ ] Integración con SMS
- [ ] Copia de seguridad automática
- [ ] Estadísticas avanzadas

## 🤝 Contribuciones

Este proyecto fue desarrollado como sistema integral de gestión médica.

## 📝 Licencia

Sistema propietario de gestión médica - Enero 2026

## 🆘 Soporte

Para reportar problemas o solicitar nuevas características, contacte al equipo de desarrollo.

---

**Sistema Médico - Versión 1.0**  
Desarrollado con ❤️ en Laravel 11  
Enero 16, 2026
