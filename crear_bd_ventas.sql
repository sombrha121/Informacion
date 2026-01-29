-- ============================================================================
-- SCRIPT SQL - SISTEMA DE VENTAS "TIENDA LA ECONOMÍA"
-- ============================================================================
-- Descripción: Script de creación completa de la base de datos con todas
--              las tablas, índices y relaciones necesarias
-- Fecha: 22/01/2026
-- ============================================================================

-- ============================================================================
-- CREAR BASE DE DATOS
-- ============================================================================
DROP DATABASE IF EXISTS sistema_ventas;

CREATE DATABASE sistema_ventas
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE sistema_ventas;

-- ============================================================================
-- TABLA: CLIENTE
-- ============================================================================
CREATE TABLE cliente (
    id_cliente INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    dni VARCHAR(15) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE,
    telefono VARCHAR(15),
    direccion VARCHAR(255),
    tipo_cliente ENUM('Regular', 'Premium', 'VIP') DEFAULT 'Regular',
    descuento_fijo DECIMAL(5,2) DEFAULT 0.00,
    estado ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_dni (dni),
    INDEX idx_email (email),
    INDEX idx_tipo_cliente (tipo_cliente),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLA: PROVEEDOR
-- ============================================================================
CREATE TABLE proveedor (
    id_proveedor INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(150) NOT NULL,
    contacto VARCHAR(100),
    email VARCHAR(100),
    telefono VARCHAR(15),
    direccion VARCHAR(255),
    ciudad VARCHAR(100),
    pais VARCHAR(100),
    estado ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_nombre (nombre),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLA: PRODUCTO
-- ============================================================================
CREATE TABLE producto (
    id_producto INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    precio_unitario DECIMAL(10,2) NOT NULL,
    cantidad_stock INT NOT NULL DEFAULT 0,
    cantidad_minima INT DEFAULT 10,
    categoria VARCHAR(50) NOT NULL,
    codigo_barra VARCHAR(50) UNIQUE,
    id_proveedor INT,
    margen_ganancia DECIMAL(5,2) DEFAULT 20.00,
    estado ENUM('Disponible', 'Descontinuado') DEFAULT 'Disponible',
    fecha_ingreso DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    PRIMARY KEY (id_producto),
    FOREIGN KEY (id_proveedor) REFERENCES proveedor(id_proveedor),
    INDEX idx_nombre (nombre),
    INDEX idx_categoria (categoria),
    INDEX idx_codigo_barra (codigo_barra),
    INDEX idx_estado (estado),
    INDEX idx_cantidad_stock (cantidad_stock)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLA: VENDEDOR (EMPLEADO)
-- ============================================================================
CREATE TABLE vendedor (
    id_vendedor INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    dni VARCHAR(15) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE,
    telefono VARCHAR(15),
    cargo ENUM('Vendedor', 'Supervisor', 'Gerente', 'Administrativo') DEFAULT 'Vendedor',
    porcentaje_comision DECIMAL(5,2) DEFAULT 5.00,
    fecha_contratacion DATE NOT NULL,
    estado ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_dni (dni),
    INDEX idx_email (email),
    INDEX idx_cargo (cargo),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLA: DESCUENTO (CÓDIGOS PROMOCIONALES)
-- ============================================================================
CREATE TABLE descuento (
    id_descuento INT PRIMARY KEY AUTO_INCREMENT,
    codigo VARCHAR(20) UNIQUE NOT NULL,
    descripcion VARCHAR(255),
    tipo ENUM('Porcentaje', 'Monto_Fijo') NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    minimo_compra DECIMAL(12,2) DEFAULT 0.00,
    maximo_aplicacion INT DEFAULT NULL,
    usos_actuales INT DEFAULT 0,
    fecha_inicio DATETIME NOT NULL,
    fecha_fin DATETIME NOT NULL,
    estado ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_codigo (codigo),
    INDEX idx_estado (estado),
    INDEX idx_fecha_inicio (fecha_inicio),
    INDEX idx_fecha_fin (fecha_fin)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLA: VENTA
-- ============================================================================
CREATE TABLE venta (
    id_venta INT PRIMARY KEY AUTO_INCREMENT,
    id_cliente INT NOT NULL,
    id_vendedor INT,
    numero_factura VARCHAR(20) UNIQUE NOT NULL,
    fecha_venta DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    subtotal DECIMAL(12,2) NOT NULL,
    descuento_total DECIMAL(12,2) DEFAULT 0.00,
    impuesto DECIMAL(12,2) NOT NULL,
    total DECIMAL(12,2) NOT NULL,
    metodo_pago ENUM('Efectivo', 'Tarjeta', 'Cheque') NOT NULL,
    estado_venta ENUM('Pendiente', 'Completada', 'Cancelada', 'Cerrada', 'Verificacion_Pendiente') DEFAULT 'Pendiente',
    observaciones TEXT,
    fecha_cierre DATETIME,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    PRIMARY KEY (id_venta),
    FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente) ON DELETE CASCADE,
    FOREIGN KEY (id_vendedor) REFERENCES vendedor(id_vendedor) ON DELETE SET NULL,
    INDEX idx_numero_factura (numero_factura),
    INDEX idx_id_cliente (id_cliente),
    INDEX idx_id_vendedor (id_vendedor),
    INDEX idx_fecha_venta (fecha_venta),
    INDEX idx_estado_venta (estado_venta),
    INDEX idx_metodo_pago (metodo_pago)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLA: DETALLE_VENTA
-- ============================================================================
CREATE TABLE detalle_venta (
    id_detalle INT PRIMARY KEY AUTO_INCREMENT,
    id_venta INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL CHECK (cantidad > 0),
    precio_unitario DECIMAL(10,2) NOT NULL,
    descuento_linea DECIMAL(5,2) DEFAULT 0.00,
    subtotal_linea DECIMAL(12,2) NOT NULL,
    total_linea DECIMAL(12,2) NOT NULL,
    
    FOREIGN KEY (id_venta) REFERENCES venta(id_venta) ON DELETE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES producto(id_producto) ON DELETE RESTRICT,
    INDEX idx_id_venta (id_venta),
    INDEX idx_id_producto (id_producto)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLA: COMISION
-- ============================================================================
CREATE TABLE comision (
    id_comision INT PRIMARY KEY AUTO_INCREMENT,
    id_vendedor INT NOT NULL,
    fecha DATETIME NOT NULL,
    cantidad_ventas INT NOT NULL,
    total_vendido DECIMAL(12,2) NOT NULL,
    porcentaje DECIMAL(5,2) NOT NULL,
    monto_comision DECIMAL(12,2) NOT NULL,
    estado ENUM('Pendiente', 'Pagada') DEFAULT 'Pendiente',
    fecha_pago DATETIME,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    PRIMARY KEY (id_comision),
    FOREIGN KEY (id_vendedor) REFERENCES vendedor(id_vendedor) ON DELETE CASCADE,
    INDEX idx_id_vendedor (id_vendedor),
    INDEX idx_fecha (fecha),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLA: CIERRE_DIARIO
-- ============================================================================
CREATE TABLE cierre_diario (
    id_cierre INT PRIMARY KEY AUTO_INCREMENT,
    fecha_cierre DATE NOT NULL UNIQUE,
    hora_cierre DATETIME NOT NULL,
    id_usuario INT,
    cantidad_ventas INT NOT NULL,
    total_ventas DECIMAL(12,2) NOT NULL,
    total_descuentos DECIMAL(12,2) NOT NULL,
    total_impuestos DECIMAL(12,2) NOT NULL,
    total_efectivo DECIMAL(12,2) DEFAULT 0.00,
    total_tarjeta DECIMAL(12,2) DEFAULT 0.00,
    total_cheque DECIMAL(12,2) DEFAULT 0.00,
    total_comisiones DECIMAL(12,2) NOT NULL,
    utilidad_neta DECIMAL(12,2) NOT NULL,
    estado ENUM('Completado', 'Cancelado') DEFAULT 'Completado',
    ruta_reporte VARCHAR(255),
    observaciones TEXT,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_fecha_cierre (fecha_cierre),
    INDEX idx_estado (estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLA: AUDITORIA
-- ============================================================================
CREATE TABLE auditoria (
    id_auditoria INT PRIMARY KEY AUTO_INCREMENT,
    tabla VARCHAR(100) NOT NULL,
    operacion ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
    id_registro INT,
    usuario VARCHAR(100),
    datos_anteriores JSON,
    datos_nuevos JSON,
    fecha_cambio DATETIME DEFAULT CURRENT_TIMESTAMP,
    ip_origen VARCHAR(45),
    
    INDEX idx_tabla (tabla),
    INDEX idx_operacion (operacion),
    INDEX idx_usuario (usuario),
    INDEX idx_fecha_cambio (fecha_cambio)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- INSERTAR DATOS DE PRUEBA
-- ============================================================================

-- Proveedores
INSERT INTO proveedor (nombre, contacto, email, telefono, ciudad, pais)
VALUES
('TechSupplies Inc', 'Juan García', 'juan@techsupplies.com', '+1-555-0101', 'Miami', 'USA'),
('ElectroGlobal', 'María López', 'maria@electroglobal.com', '+34-91-555-0102', 'Madrid', 'España'),
('Importadora Asia', 'Chen Wang', 'chen@importadora.com', '+86-10-555-0103', 'Beijing', 'China');

-- Productos
INSERT INTO producto (nombre, descripcion, precio_unitario, cantidad_stock, categoria, codigo_barra, id_proveedor, margen_ganancia)
VALUES
('Laptop Dell XPS 13', 'Laptop ultrabook 13 pulgadas', 1299.99, 15, 'Electrónica', '5901234123456', 1, 25.00),
('Monitor LG 27"', 'Monitor IPS Full HD 27 pulgadas', 299.99, 25, 'Monitores', '5901234123457', 2, 22.00),
('Teclado Mecánico RGB', 'Teclado gaming con switches mecánicos', 149.99, 40, 'Accesorios', '5901234123458', 1, 35.00),
('Mouse Logitech MX', 'Mouse inalámbrico profesional', 99.99, 50, 'Accesorios', '5901234123459', 2, 30.00),
('USB-C Hub 7 en 1', 'Hub multifuncional con 7 puertos', 79.99, 60, 'Accesorios', '5901234123460', 3, 40.00),
('SSD Samsung 1TB', 'Unidad de estado sólido 1TB NVMe', 129.99, 35, 'Almacenamiento', '5901234123461', 1, 28.00),
('Webcam Logitech 4K', 'Cámara web Ultra HD 4K', 199.99, 20, 'Accesorios', '5901234123462', 2, 32.00),
('Audífonos Sony WH-1000', 'Audífonos noise-cancelling', 349.99, 18, 'Audio', '5901234123463', 2, 24.00),
('Cable HDMI 2.1', 'Cable HDMI 2.1 de 2 metros', 29.99, 100, 'Cables', '5901234123464', 3, 50.00),
('Soporte para Monitor', 'Soporte ajustable para monitores', 49.99, 45, 'Accesorios', '5901234123465', 3, 45.00);

-- Vendedores
INSERT INTO vendedor (nombre, apellido, dni, email, telefono, cargo, porcentaje_comision, fecha_contratacion)
VALUES
('Carlos', 'Rodríguez', '123456789', 'carlos.rodriguez@economia.com', '555-0201', 'Vendedor', 5.00, '2023-06-15'),
('Sofía', 'Martinez', '987654321', 'sofia.martinez@economia.com', '555-0202', 'Vendedor', 5.00, '2023-08-20'),
('Pedro', 'González', '456789123', 'pedro.gonzalez@economia.com', '555-0203', 'Supervisor', 7.00, '2022-03-10'),
('Andrea', 'López', '789123456', 'andrea.lopez@economia.com', '555-0204', 'Gerente', 8.00, '2021-01-01');

-- Clientes
INSERT INTO cliente (nombre, apellido, dni, email, telefono, tipo_cliente)
VALUES
('Juan', 'Pérez García', '11111111', 'juan.perez@email.com', '555-1001', 'Regular'),
('María', 'González López', '22222222', 'maria.gonzalez@email.com', '555-1002', 'Premium'),
('Carlos', 'Rodríguez Martínez', '33333333', 'carlos.rodriguez@email.com', '555-1003', 'VIP'),
('Ana', 'Fernández Sánchez', '44444444', 'ana.fernandez@email.com', '555-1004', 'Regular'),
('Luis', 'Domínguez Castillo', '55555555', 'luis.dominguez@email.com', '555-1005', 'Premium'),
('Beatriz', 'Torres García', '66666666', 'beatriz.torres@email.com', '555-1006', 'VIP');

-- Códigos Promocionales
INSERT INTO descuento (codigo, descripcion, tipo, valor, minimo_compra, maximo_aplicacion, fecha_inicio, fecha_fin)
VALUES
('BIENVENIDA', 'Descuento de bienvenida para nuevos clientes', 'Porcentaje', 5.00, 100.00, NULL, '2026-01-01', '2026-02-28'),
('DIASEMANA', 'Descuento especial para compras entre semana', 'Porcentaje', 3.00, 50.00, NULL, '2026-01-01', '2026-12-31'),
('NAVIDAD2025', 'Promoción especial de fin de año', 'Porcentaje', 10.00, 200.00, 100, '2025-12-15', '2025-12-31'),
('DESC100', 'Descuento fijo de $100', 'Monto_Fijo', 100.00, 500.00, NULL, '2026-01-01', '2026-12-31');

-- ============================================================================
-- CREAR VISTAS
-- ============================================================================

-- Vista: Resumen de Ventas Diarias
CREATE VIEW vista_ventas_diarias AS
SELECT 
    DATE(v.fecha_venta) AS fecha,
    COUNT(v.id_venta) AS cantidad_ventas,
    SUM(v.subtotal) AS subtotal_total,
    SUM(v.descuento_total) AS total_descuentos,
    SUM(v.impuesto) AS total_impuestos,
    SUM(v.total) AS total_ingresos
FROM venta v
WHERE v.estado_venta = 'Completada'
GROUP BY DATE(v.fecha_venta);

-- Vista: Desempeño de Vendedores
CREATE VIEW vista_desempeño_vendedores AS
SELECT 
    ve.id_vendedor,
    ve.nombre,
    ve.apellido,
    COUNT(v.id_venta) AS cantidad_ventas,
    SUM(v.total) AS total_vendido,
    AVG(v.total) AS ticket_promedio,
    SUM(c.monto_comision) AS comisiones_pagadas
FROM vendedor ve
LEFT JOIN venta v ON ve.id_vendedor = v.id_vendedor AND v.estado_venta = 'Completada'
LEFT JOIN comision c ON ve.id_vendedor = c.id_vendedor AND c.estado = 'Pagada'
GROUP BY ve.id_vendedor;

-- Vista: Productos con Stock Bajo
CREATE VIEW vista_productos_stock_bajo AS
SELECT 
    id_producto,
    nombre,
    cantidad_stock,
    cantidad_minima,
    (cantidad_minima - cantidad_stock) AS diferencia,
    proveedor.nombre AS proveedor
FROM producto
JOIN proveedor ON producto.id_proveedor = proveedor.id_proveedor
WHERE cantidad_stock <= cantidad_minima;

-- ============================================================================
-- CREAR ÍNDICES ADICIONALES
-- ============================================================================

-- Índices para mejorar performance de reportes
CREATE INDEX idx_venta_fecha ON venta(fecha_venta);
CREATE INDEX idx_venta_cliente ON venta(id_cliente);
CREATE INDEX idx_venta_vendedor ON venta(id_vendedor);
CREATE INDEX idx_detalle_producto ON detalle_venta(id_producto);

-- ============================================================================
-- CREAR TRIGGERS
-- ============================================================================

-- Trigger: Actualizar stock al vender
DELIMITER //
CREATE TRIGGER actualizar_stock_venta
AFTER INSERT ON detalle_venta
FOR EACH ROW
BEGIN
    UPDATE producto
    SET cantidad_stock = cantidad_stock - NEW.cantidad
    WHERE id_producto = NEW.id_producto;
END//
DELIMITER ;

-- ============================================================================
-- INFORMACIÓN DEL SISTEMA
-- ============================================================================
SELECT 'Base de datos "sistema_ventas" creada exitosamente!' AS Mensaje;
SELECT '========================================' AS Separador;
SELECT 'Tablas creadas:' AS Seccion;
SHOW TABLES;
SELECT '========================================' AS Separador;
SELECT 'Registros de ejemplo insertados:' AS Seccion;
SELECT COUNT(*) AS 'Total Clientes' FROM cliente;
SELECT COUNT(*) AS 'Total Productos' FROM producto;
SELECT COUNT(*) AS 'Total Vendedores' FROM vendedor;
SELECT COUNT(*) AS 'Total Códigos Promocionales' FROM descuento;
