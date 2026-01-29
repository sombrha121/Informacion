# Sistema Médico - Laravel

Sistema completo de gestión médica desarrollado en Laravel 11.

## 📋 Características

- ✅ Gestión de Pacientes
- ✅ Gestión de Personal Médico
- ✅ Consultas Médicas
- ✅ Exámenes de Laboratorio
- ✅ Tratamientos
- ✅ Compras e Inventario
- ✅ Reportes y Estadísticas
- ✅ Sistema de Autenticación

## 🚀 Instalación y Configuración

### Requisitos
- Laragon con PHP 8.3+ y MySQL
- Composer

### Pasos para Iniciar el Proyecto

1. **Crear Base de Datos**
   - Abrir HeidiSQL (en Laragon)
   - Crear base de datos: `sistema_medico`

2. **Generar Clave de Aplicación**
```powershell
cd c:\laragon\www\Prototipo
php artisan key:generate
```

3. **Ejecutar Migraciones**
```powershell
php artisan migrate
```

4. **Cargar Datos de Prueba**
```powershell
php artisan db:seed
```

5. **Iniciar Servidor**
```powershell
php artisan serve
```
6.  **otro metodo mediatne la terminal**
   ```powershell
   copy .env.example .env
composer install
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
npm install
npm run build
php artisan serve  
```

O acceder directamente desde Laragon: `http://prototipo.test`

## 👤 Credenciales de Acceso

**Administrador**
- Email: admin@sistema.com
- Password: admin123

**Doctor**
- Email: doctor@sistema.com
- Password: doctor123

## 📦 Módulos del Sistema

1. **Pacientes** - Registro y gestión de pacientes
2. **Consultas** - Programación y seguimiento de consultas médicas
3. **Exámenes** - Solicitud y registro de exámenes de laboratorio
4. **Tratamientos** - Planes de tratamiento y medicamentos
5. **Compras** - Gestión de compras e inventario
6. **Personal** - Administración de personal médico
7. **Reportes** - Estadísticas e informes del sistema

---
**Laravel 11** • Bootstrap 5 • MySQL

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
