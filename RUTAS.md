# 📋 LISTA DE RUTAS DEL SISTEMA

## 🔐 Autenticación
- `GET  /` - Página de login
- `GET  /login` - Formulario de login
- `POST /login` - Procesar login
- `POST /logout` - Cerrar sesión

## 🏠 Dashboard
- `GET /dashboard` - Panel principal (requiere autenticación)

## 👥 Pacientes
- `GET    /pacientes` - Listar pacientes
- `GET    /pacientes/create` - Formulario nuevo paciente
- `POST   /pacientes` - Guardar paciente
- `GET    /pacientes/{id}` - Ver detalles
- `GET    /pacientes/{id}/edit` - Formulario editar
- `PUT    /pacientes/{id}` - Actualizar paciente
- `DELETE /pacientes/{id}` - Eliminar paciente

## 📋 Consultas
- `GET    /consultas` - Listar consultas
- `GET    /consultas/create` - Formulario nueva consulta
- `POST   /consultas` - Guardar consulta
- `GET    /consultas/{id}` - Ver detalles
- `GET    /consultas/{id}/edit` - Formulario editar
- `PUT    /consultas/{id}` - Actualizar consulta
- `DELETE /consultas/{id}` - Eliminar consulta
- `POST   /consultas/{id}/concluir` - Marcar como concluida

## 🧪 Exámenes
- `GET    /examenes` - Listar exámenes
- `GET    /examenes/create` - Formulario nuevo examen
- `POST   /examenes` - Guardar examen
- `GET    /examenes/{id}` - Ver detalles
- `GET    /examenes/{id}/edit` - Formulario editar
- `PUT    /examenes/{id}` - Actualizar examen
- `DELETE /examenes/{id}` - Eliminar examen
- `POST   /examenes/{id}/concluir` - Marcar como concluido

## 💊 Tratamientos
- `GET    /tratamientos` - Listar tratamientos
- `GET    /tratamientos/create` - Formulario nuevo tratamiento
- `POST   /tratamientos` - Guardar tratamiento
- `GET    /tratamientos/{id}` - Ver detalles
- `GET    /tratamientos/{id}/edit` - Formulario editar
- `PUT    /tratamientos/{id}` - Actualizar tratamiento
- `DELETE /tratamientos/{id}` - Eliminar tratamiento
- `POST   /tratamientos/{id}/aceptar` - Aceptar tratamiento
- `POST   /tratamientos/{id}/completar` - Completar tratamiento

## 🛒 Compras
- `GET    /compras` - Listar compras
- `GET    /compras/create` - Formulario nueva compra
- `POST   /compras` - Guardar compra
- `GET    /compras/{id}` - Ver detalles
- `GET    /compras/{id}/edit` - Formulario editar
- `PUT    /compras/{id}` - Actualizar compra
- `DELETE /compras/{id}` - Eliminar compra

## 👨‍⚕️ Personal
- `GET    /personal` - Listar personal
- `GET    /personal/create` - Formulario nuevo personal
- `POST   /personal` - Guardar personal
- `GET    /personal/{id}` - Ver detalles
- `GET    /personal/{id}/edit` - Formulario editar
- `PUT    /personal/{id}` - Actualizar personal
- `DELETE /personal/{id}` - Eliminar personal

## 📊 Reportes
- `GET /reportes` - Dashboard de reportes
- `GET /reportes/pacientes` - Reporte de pacientes
- `GET /reportes/consultas` - Reporte de consultas
- `GET /reportes/financiero` - Reporte financiero

## 📖 Historial
- `GET /historial/{paciente}` - Ver historial completo del paciente

---

**Todas las rutas excepto `/` y `/login` requieren autenticación**

Para ver todas las rutas disponibles en el sistema:
```powershell
php artisan route:list
```
