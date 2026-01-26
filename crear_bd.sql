-- Script para crear la base de datos del Sistema Médico
-- Ejecutar este script en HeidiSQL o MySQL Workbench

-- Eliminar la base de datos si existe (opcional, comentado por seguridad)
-- DROP DATABASE IF EXISTS sistema_medico;

-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS sistema_medico 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Seleccionar la base de datos
USE sistema_medico;

-- Mostrar mensaje de confirmación
SELECT 'Base de datos "sistema_medico" creada exitosamente!' AS Mensaje;

-- Información adicional
SELECT 
    'Ahora puedes ejecutar las migraciones de Laravel' AS 'Siguiente Paso',
    'php artisan migrate' AS 'Comando';
