# DOCUMENTACIÓN DEL SISTEMA DE VENTAS
## Tienda la Economía

---

## 1. DICCIONARIO DE DATOS (30 pts)

### Definición de Elementos Clave del Sistema

#### 1.1 **CLIENTE**
| Atributo | Tipo | Descripción | Restricciones |
|----------|------|-------------|----------------|
| **ID_Cliente** | INT | Identificador único del cliente | PK, NOT NULL, AUTO_INCREMENT |
| **Nombre** | VARCHAR(100) | Nombre completo del cliente | NOT NULL |
| **Apellido** | VARCHAR(100) | Apellido del cliente | NOT NULL |
| **DNI** | VARCHAR(15) | Documento Nacional de Identidad | UNIQUE, NOT NULL |
| **Email** | VARCHAR(100) | Correo electrónico | UNIQUE |
| **Telefono** | VARCHAR(15) | Número de teléfono | |
| **Direccion** | VARCHAR(255) | Domicilio del cliente | |
| **Tipo_Cliente** | ENUM('Regular', 'Premium', 'VIP') | Categoría del cliente | DEFAULT 'Regular' |
| **Descuento_Fijo** | DECIMAL(5,2) | Descuento aplicable según tipo | DEFAULT 0.00 |
| **Estado** | ENUM('Activo', 'Inactivo') | Estado del cliente | DEFAULT 'Activo' |
| **Fecha_Registro** | DATETIME | Fecha de creación del registro | DEFAULT CURRENT_TIMESTAMP |

#### 1.2 **PRODUCTO**
| Atributo | Tipo | Descripción | Restricciones |
|----------|------|-------------|----------------|
| **ID_Producto** | INT | Identificador único del producto | PK, NOT NULL, AUTO_INCREMENT |
| **Nombre** | VARCHAR(150) | Nombre del producto | NOT NULL |
| **Descripcion** | TEXT | Descripción detallada | |
| **Precio_Unitario** | DECIMAL(10,2) | Precio sin descuento | NOT NULL |
| **Cantidad_Stock** | INT | Cantidad disponible en almacén | NOT NULL, DEFAULT 0 |
| **Categoria** | VARCHAR(50) | Categoría del producto | NOT NULL |
| **Codigo_Barra** | VARCHAR(50) | Código de barras | UNIQUE |
| **Proveedor_ID** | INT | ID del proveedor | FK |
| **Margen_Ganancia** | DECIMAL(5,2) | Porcentaje de ganancia | DEFAULT 20.00 |
| **Estado** | ENUM('Disponible', 'Descontinuado') | Estado del producto | DEFAULT 'Disponible' |
| **Fecha_Ingreso** | DATETIME | Fecha de registro del producto | DEFAULT CURRENT_TIMESTAMP |

#### 1.3 **VENTA**
| Atributo | Tipo | Descripción | Restricciones |
|----------|------|-------------|----------------|
| **ID_Venta** | INT | Identificador único de la venta | PK, NOT NULL, AUTO_INCREMENT |
| **ID_Cliente** | INT | Referencia del cliente | FK, NOT NULL |
| **Fecha_Venta** | DATETIME | Fecha y hora de la transacción | NOT NULL, DEFAULT CURRENT_TIMESTAMP |
| **Subtotal** | DECIMAL(12,2) | Suma antes de descuentos | NOT NULL |
| **Descuento_Total** | DECIMAL(12,2) | Monto total de descuentos | DEFAULT 0.00 |
| **Impuesto** | DECIMAL(12,2) | Monto del IVA (19%) | NOT NULL |
| **Total** | DECIMAL(12,2) | Monto final a pagar | NOT NULL |
| **Metodo_Pago** | ENUM('Efectivo', 'Tarjeta', 'Cheque') | Forma de pago | NOT NULL |
| **Estado_Venta** | ENUM('Pendiente', 'Completada', 'Cancelada') | Estado de la transacción | DEFAULT 'Pendiente' |
| **Vendedor_ID** | INT | ID del vendedor/empleado | FK |
| **Numero_Factura** | VARCHAR(20) | Número de factura | UNIQUE |

#### 1.4 **DETALLE_VENTA**
| Atributo | Tipo | Descripción | Restricciones |
|----------|------|-------------|----------------|
| **ID_Detalle** | INT | Identificador del detalle | PK, AUTO_INCREMENT |
| **ID_Venta** | INT | Referencia a la venta | FK, NOT NULL |
| **ID_Producto** | INT | Referencia al producto | FK, NOT NULL |
| **Cantidad** | INT | Cantidad de unidades vendidas | NOT NULL, > 0 |
| **Precio_Unitario** | DECIMAL(10,2) | Precio en el momento de la venta | NOT NULL |
| **Descuento_Linea** | DECIMAL(5,2) | Descuento por línea (%) | DEFAULT 0.00 |
| **Subtotal_Linea** | DECIMAL(12,2) | Total de la línea sin descuento | NOT NULL |
| **Total_Linea** | DECIMAL(12,2) | Total de la línea con descuento | NOT NULL |

#### 1.5 **DESCUENTO**
| Atributo | Tipo | Descripción | Restricciones |
|----------|------|-------------|----------------|
| **ID_Descuento** | INT | Identificador del descuento | PK, AUTO_INCREMENT |
| **Codigo** | VARCHAR(20) | Código promocional | UNIQUE, NOT NULL |
| **Descripcion** | VARCHAR(255) | Descripción de la promoción | |
| **Tipo** | ENUM('Porcentaje', 'Monto_Fijo') | Tipo de descuento | NOT NULL |
| **Valor** | DECIMAL(10,2) | Valor del descuento | NOT NULL |
| **Minimo_Compra** | DECIMAL(12,2) | Monto mínimo para aplicar | DEFAULT 0.00 |
| **Maximo_Aplicacion** | INT | Máximo número de usos | DEFAULT NULL |
| **Usos_Actuales** | INT | Usos realizados | DEFAULT 0 |
| **Fecha_Inicio** | DATETIME | Inicio de vigencia | NOT NULL |
| **Fecha_Fin** | DATETIME | Fin de vigencia | NOT NULL |
| **Estado** | ENUM('Activo', 'Inactivo') | Estado de la promoción | DEFAULT 'Activo' |

---

## 2. LÓGICA DE DESCUENTOS (40 pts)

### 2.1 Árbol de Decisiones para Cálculo de Descuentos

```
                            ┌─────────────────────────────┐
                            │   INICIO CÁLCULO DESCUENTO  │
                            └────────────┬────────────────┘
                                         │
                            ┌────────────▼────────────┐
                            │  ¿Cliente Válido?       │
                            └────────────┬────────────┘
                                    SÍ  │  NO
                                        │  └─────► RECHAZAR
                                        │
                            ┌───────────▼──────────────┐
                            │ Verificar Tipo Cliente   │
                            └───────┬───────┬──────┬───┘
                                    │       │      │
                        ┌───────────┘       │      └────────┐
                        │                   │               │
                    REGULAR             PREMIUM            VIP
                   (0-5%)              (5-10%)          (10-15%)
                        │                   │               │
                        └───────────┬───────┴───────────────┘
                                    │
                        ┌───────────▼──────────────┐
                        │ ¿Subtotal > Mín_Compra? │
                        └───────┬────────┬────────┘
                            SÍ  │        │ NO
                                │        └─────► Sin descuento extra
                                │
                    ┌───────────▼──────────────┐
                    │ ¿Código Promocional?     │
                    └───────┬────────┬────────┘
                        SÍ  │        │ NO
                            │        └─────► Usar % por Tipo
                            │
                    ┌───────▼─────────────────┐
                    │ Validar Código          │
                    │ • Vigencia              │
                    │ • Límite de usos        │
                    │ • Monto mínimo          │
                    └───────┬─────────────────┘
                        VÁLIDO │ INVÁLIDO
                            │  └─────► Rechazar código
                            │
            ┌───────────────▼─────────────────────┐
            │ Calcular Descuento Mayor            │
            │ MAX(Descuento_Tipo, Descuento_Código)
            └───────────────┬─────────────────────┘
                            │
            ┌───────────────▼─────────────────────┐
            │ ¿Descuento > Máximo Permitido?      │
            └───────┬────────┬───────────────────┘
                SÍ  │        │ NO
                    │        └─────► Aplicar descuento
        ┌───────────▼──────────┐
        │ Limitar a Máximo     │
        │ Descuento Permitido  │
        └───────────┬──────────┘
                    │
            ┌───────▼──────────────┐
            │ APLICAR DESCUENTO    │
            └──────────────────────┘
```

### 2.2 Tabla de Reglas de Descuentos

| ID | Condición | Tipo Cliente | Subtotal | Código | Descuento | Límite Máx | Acción |
|----|-----------|----|-----------|---------|---------|-----------|-----------|
| R1 | Siempre | Regular | Cualquiera | NO | 0% | 0% | Sin descuento |
| R2 | Siempre | Regular | ≥ $100 | NO | 5% | 10% | Descuento por volumen |
| R3 | Siempre | Regular | ≥ $500 | NO | 8% | 10% | Descuento por volumen |
| R4 | Siempre | Premium | Cualquiera | NO | 5% | 15% | Descuento base |
| R5 | Siempre | Premium | ≥ $200 | NO | 10% | 15% | Descuento mejorado |
| R6 | Siempre | VIP | Cualquiera | NO | 10% | 20% | Descuento base |
| R7 | Siempre | VIP | ≥ $300 | NO | 15% | 20% | Descuento máximo |
| R8 | Válido | Cualquiera | ≥ Mín | SÍ | Según código | 20% | Código promocional |
| R9 | Inválido | Cualquiera | - | SÍ | 0% | 0% | Ignorar código |
| R10 | Siempre | Cualquiera | - | - | Usar MAX | 20% | Aplicar mayor |

### 2.3 Matriz de Descuentos

```
╔═════════════════════════════════════════════════════════════════════════════╗
║                    MATRIZ DE DESCUENTOS - TIENDA LA ECONOMÍA                ║
╠════════════════════╦═══════════════╦═══════════════╦═══════════════╗
║  RANGO DE COMPRA   ║   REGULAR     ║   PREMIUM     ║     VIP       ║
╠════════════════════╬═══════════════╬═══════════════╬═══════════════╣
║ Hasta $99.99       ║      0%       ║      5%       ║      10%      ║
║ $100 - $299.99     ║      5%       ║      10%      ║      15%      ║
║ $300 - $499.99     ║      8%       ║      12%      ║      18%      ║
║ $500 o más         ║      10%      ║      15%      ║      20%      ║
╚════════════════════╩═══════════════╩═══════════════╩═══════════════╝

Límite Máximo de Descuento:
  - Regular: 10%
  - Premium: 15%
  - VIP: 20%

Descuentos Adicionales (Códigos Promocionales):
  - BIENVENIDA: +5% (válido primeros 30 días)
  - DIASEMANA: +3% (aplicable L-V)
  - NAVIDAD2025: +10% (hasta 31/12/2025)
  - REFERIDO: +2% por cada referido activo
```

---

## 3. CIERRE DE VENTAS (30 pts)

### 3.1 Pseudocódigo del Proceso de Cierre de Ventas

```pseudocodigo
╔═══════════════════════════════════════════════════════════════════════════════╗
║                 ALGORITMO: CIERRE DE VENTAS DIARIO                            ║
║                         Tienda la Economía                                     ║
╚═══════════════════════════════════════════════════════════════════════════════╝

PROCEDIMIENTO CierreVentas()
    
    DECLARAR:
        fecha_cierre ← FECHA_ACTUAL()
        hora_cierre ← HORA_ACTUAL()
        total_ventas ← 0.00
        cantidad_ventas ← 0
        total_descuentos ← 0.00
        total_impuestos ← 0.00
        total_por_metodo_pago[] ← {Efectivo: 0, Tarjeta: 0, Cheque: 0}
        lista_ventas_pendientes[] ← []
        reporte_cierre ← OBJETO_VACIO()
        
    INICIO
        
        ESCRIBIR "═══════════════════════════════════════════════════════════"
        ESCRIBIR "        INICIANDO CIERRE DE VENTAS"
        ESCRIBIR "        Fecha: " + fecha_cierre + " Hora: " + hora_cierre
        ESCRIBIR "═══════════════════════════════════════════════════════════"
        ESCRIBIR ""
        
        // ─────────────────────────────────────────────────────────────
        // FASE 1: VALIDACIÓN INICIAL
        // ─────────────────────────────────────────────────────────────
        
        ESCRIBIR "FASE 1: VALIDACIÓN INICIAL"
        ESCRIBIR "─────────────────────────────────────────────────────────"
        
        SI NO VerificarIntegridadBD() ENTONCES
            ESCRIBIR "[ERROR] Base de datos corrupta. Abortando cierre."
            RETORNAR FALSO
        FIN SI
        
        SI VerificarVentasAbiertas() ENTONCES
            ESCRIBIR "[ALERTA] Existen ventas pendientes de completar"
            lista_ventas_pendientes ← ObtenerVentasPendientes()
            PARA CADA venta EN lista_ventas_pendientes HACER
                ESCRIBIR "   - Venta ID: " + venta.id + " Estado: PENDIENTE"
            FIN PARA
            ESCRIBIR ""
        FIN SI
        
        // ─────────────────────────────────────────────────────────────
        // FASE 2: CONSOLIDACIÓN DE VENTAS
        // ─────────────────────────────────────────────────────────────
        
        ESCRIBIR "FASE 2: CONSOLIDACIÓN DE VENTAS"
        ESCRIBIR "─────────────────────────────────────────────────────────"
        
        ventasDia[] ← ObtenerVentas(fecha_cierre, Estado='Completada')
        
        SI ventasDia.VACIO() ENTONCES
            ESCRIBIR "[INFORMACIÓN] No hay ventas para cerrar en esta fecha"
        SINO
            PARA CADA venta EN ventasDia HACER
                
                // Validar integridad de la venta
                SI ValidarVenta(venta) ENTONCES
                    
                    total_ventas ← total_ventas + venta.total
                    cantidad_ventas ← cantidad_ventas + 1
                    total_descuentos ← total_descuentos + venta.descuento_total
                    total_impuestos ← total_impuestos + venta.impuesto
                    
                    // Clasificar por método de pago
                    metodo ← venta.metodo_pago
                    total_por_metodo_pago[metodo] ← total_por_metodo_pago[metodo] + venta.total
                    
                    // Marcar venta como cerrada
                    venta.estado_venta ← 'Cerrada'
                    venta.fecha_cierre ← hora_cierre
                    ActualizarVenta(venta)
                    
                SINO
                    ESCRIBIR "[ERROR] Venta " + venta.id + " con inconsistencias. Revisión manual requerida."
                    venta.estado_venta ← 'Verificación_Pendiente'
                    ActualizarVenta(venta)
                FIN SI
                
            FIN PARA
            
            ESCRIBIR ""
            ESCRIBIR "Ventas procesadas: " + cantidad_ventas
            ESCRIBIR "Total en ventas: $" + FORMATEAR_DINERO(total_ventas)
            ESCRIBIR ""
            
        FIN SI
        
        // ─────────────────────────────────────────────────────────────
        // FASE 3: VERIFICACIÓN DE INVENTARIO
        // ─────────────────────────────────────────────────────────────
        
        ESCRIBIR "FASE 3: VERIFICACIÓN DE INVENTARIO"
        ESCRIBIR "─────────────────────────────────────────────────────────"
        
        productos_bajo_stock[] ← VerificarStockMinimo()
        
        SI NO productos_bajo_stock.VACIO() ENTONCES
            ESCRIBIR "[ALERTA] Productos con stock bajo:"
            PARA CADA producto EN productos_bajo_stock HACER
                ESCRIBIR "   - " + producto.nombre + " (Stock: " + producto.cantidad_stock + ")"
            FIN PARA
            ESCRIBIR ""
        SINO
            ESCRIBIR "Stock verificado correctamente"
            ESCRIBIR ""
        FIN SI
        
        // ─────────────────────────────────────────────────────────────
        // FASE 4: CÁLCULO DE COMISIONES (si aplica)
        // ─────────────────────────────────────────────────────────────
        
        ESCRIBIR "FASE 4: CÁLCULO DE COMISIONES POR VENDEDOR"
        ESCRIBIR "─────────────────────────────────────────────────────────"
        
        vendedores[] ← ObtenerVendedoresConVentas(fecha_cierre)
        comisiones_total ← 0.00
        
        PARA CADA vendedor EN vendedores HACER
            
            ventas_vendedor ← ObtenerVentasPorVendedor(vendedor.id, fecha_cierre)
            total_vendedor ← SUM(ventas_vendedor.total)
            cantidad_vendedor ← COUNT(ventas_vendedor)
            
            // Calcular comisión: 5% sobre total de ventas
            comision ← total_vendedor * 0.05
            comisiones_total ← comisiones_total + comision
            
            registroComision ← CREAR_REGISTRO(
                vendedor_id: vendedor.id,
                fecha: fecha_cierre,
                cantidad_ventas: cantidad_vendedor,
                total_vendido: total_vendedor,
                porcentaje: 5,
                comision: comision
            )
            
            GuardarComision(registroComision)
            
            ESCRIBIR "   Vendedor: " + vendedor.nombre
            ESCRIBIR "   Ventas: " + cantidad_vendedor
            ESCRIBIR "   Total: $" + FORMATEAR_DINERO(total_vendedor)
            ESCRIBIR "   Comisión (5%): $" + FORMATEAR_DINERO(comision)
            ESCRIBIR ""
            
        FIN PARA
        
        // ─────────────────────────────────────────────────────────────
        // FASE 5: GENERACIÓN DE REPORTES
        // ─────────────────────────────────────────────────────────────
        
        ESCRIBIR "FASE 5: GENERACIÓN DE REPORTES"
        ESCRIBIR "─────────────────────────────────────────────────────────"
        
        reporte_cierre.fecha ← fecha_cierre
        reporte_cierre.hora ← hora_cierre
        reporte_cierre.cantidad_ventas ← cantidad_ventas
        reporte_cierre.total_ventas ← total_ventas
        reporte_cierre.total_descuentos ← total_descuentos
        reporte_cierre.total_impuestos ← total_impuestos
        reporte_cierre.porcentaje_descuento ← (total_descuentos / total_ventas) * 100
        reporte_cierre.total_por_metodo ← total_por_metodo_pago
        reporte_cierre.comisiones ← comisiones_total
        reporte_cierre.utilidad_bruta ← total_ventas - comisiones_total
        
        // Generar PDF del reporte
        archivo_reporte ← GenerarReportePDF(reporte_cierre)
        
        ESCRIBIR "Reporte generado: " + archivo_reporte
        ESCRIBIR ""
        
        // ─────────────────────────────────────────────────────────────
        // FASE 6: RESUMEN FINAL Y CONFIRMACIÓN
        // ─────────────────────────────────────────────────────────────
        
        ESCRIBIR "╔═══════════════════════════════════════════════════════════╗"
        ESCRIBIR "║                    RESUMEN DEL CIERRE                     ║"
        ESCRIBIR "╠═══════════════════════════════════════════════════════════╣"
        ESCRIBIR "║ Fecha del Cierre:          " + FORMATO_FECHA(fecha_cierre)
        ESCRIBIR "║ Hora:                      " + FORMATO_HORA(hora_cierre)
        ESCRIBIR "║ Cantidad de Ventas:        " + cantidad_ventas
        ESCRIBIR "║ Total Bruto:               $" + FORMATEAR_DINERO(total_ventas)
        ESCRIBIR "║ Total Descuentos:          $" + FORMATEAR_DINERO(total_descuentos)
        ESCRIBIR "║ Total Impuestos (19%):     $" + FORMATEAR_DINERO(total_impuestos)
        ESCRIBIR "║────────────────────────────────────────────────────────────"
        ESCRIBIR "║ DESGLOSE POR MÉTODO DE PAGO:"
        
        PARA CADA metodo, monto EN total_por_metodo_pago HACER
            ESCRIBIR "║   " + metodo + ": $" + FORMATEAR_DINERO(monto)
        FIN PARA
        
        ESCRIBIR "║────────────────────────────────────────────────────────────"
        ESCRIBIR "║ Comisiones Vendedores:     $" + FORMATEAR_DINERO(comisiones_total)
        ESCRIBIR "║ UTILIDAD NETA:             $" + FORMATEAR_DINERO(reporte_cierre.utilidad_bruta)
        ESCRIBIR "╚═══════════════════════════════════════════════════════════╝"
        ESCRIBIR ""
        
        // ─────────────────────────────────────────────────────────────
        // FASE 7: CONFIRMAR CIERRE
        // ─────────────────────────────────────────────────────────────
        
        ESCRIBIR "¿Confirmar cierre de ventas? (S/N): "
        respuesta ← LEER_ENTRADA()
        
        SI MAYUSCULA(respuesta) = 'S' ENTONCES
            
            // Crear registro de cierre
            registro_cierre ← CREAR_REGISTRO(
                fecha: fecha_cierre,
                hora: hora_cierre,
                usuario: USUARIO_ACTUAL(),
                estado: 'Completado',
                datos: reporte_cierre
            )
            
            GuardarCierreDiario(registro_cierre)
            
            // Backup de base de datos
            ESCRIBIR "Realizando backup de base de datos..."
            EjecutarBackup()
            
            ESCRIBIR "═══════════════════════════════════════════════════════════"
            ESCRIBIR "✓ CIERRE DE VENTAS COMPLETADO EXITOSAMENTE"
            ESCRIBIR "  Reporte disponible en: " + archivo_reporte
            ESCRIBIR "═══════════════════════════════════════════════════════════"
            
            RETORNAR VERDADERO
            
        SINO
            
            ESCRIBIR "[CANCELADO] Cierre de ventas cancelado por el usuario"
            
            // Revertir cambios si los hay
            PARA CADA venta EN ventasDia HACER
                SI venta.estado_venta = 'Cerrada' ENTONCES
                    venta.estado_venta ← 'Completada'
                    ActualizarVenta(venta)
                FIN SI
            FIN PARA
            
            RETORNAR FALSO
            
        FIN SI
        
    FIN

// ─────────────────────────────────────────────────────────────────────────────
// FUNCIONES AUXILIARES
// ─────────────────────────────────────────────────────────────────────────────

FUNCIÓN VerificarIntegridadBD() RETORNA BOOLEANO
    INTENTA
        conexion ← ConectarBD()
        resultado ← conexion.EJECUTAR("SELECT COUNT(*) FROM ventas")
        RETORNAR VERDADERO
    EXCEPTO
        RETORNAR FALSO
    FIN INTENTA
FIN FUNCIÓN

FUNCIÓN ValidarVenta(venta) RETORNA BOOLEANO
    SI venta.total = 0 ENTONCES
        RETORNAR FALSO
    FIN SI
    
    SI venta.descuento_total > venta.subtotal ENTONCES
        RETORNAR FALSO
    FIN SI
    
    detalles ← ObtenerDetallesVenta(venta.id)
    SI detalles.VACIO() ENTONCES
        RETORNAR FALSO
    FIN SI
    
    RETORNAR VERDADERO
FIN FUNCIÓN

FUNCIÓN VerificarStockMinimo() RETORNA ARRAY
    productos_bajo_stock ← []
    productos ← ObtenerTodosProductos()
    
    PARA CADA producto EN productos HACER
        SI producto.cantidad_stock < 10 ENTONCES
            INSERTAR(productos_bajo_stock, producto)
        FIN SI
    FIN PARA
    
    RETORNAR productos_bajo_stock
FIN FUNCIÓN

FUNCIÓN EjecutarBackup()
    timestamp ← FECHA_HORA_ACTUAL()
    archivo_backup ← "backup_" + timestamp + ".sql"
    EJECUTAR_COMANDO("mysqldump -u root sistema_medico > " + archivo_backup)
FIN FUNCIÓN
```

### 3.2 Diagrama de Flujo del Cierre

```
┌─────────────────────────┐
│   INICIO CIERRE         │
└────────┬────────────────┘
         │
         ▼
    ┌────────────────┐
    │ Validar BD     │
    │ e Integridad   │
    └────┬───────────┘
         │ ¿OK?
      SÍ│ NO
        │  └──► ABORTARR
        │
        ▼
    ┌────────────────────────┐
    │ Obtener Ventas Dia     │
    │ (Estado: Completada)   │
    └────┬───────────────────┘
         │
         ▼
    ┌────────────────────┐
    │ ¿Hay ventas?       │
    └────┬────────┬──────┘
      SÍ │        │ NO
        │        └──► FIN (sin movimiento)
        │
        ▼
    ┌────────────────────────┐
    │ Procesar Cada Venta    │
    │ • Validar              │
    │ • Calcular totales     │
    │ • Clasificar pagos     │
    │ • Marcar como cerrada  │
    └────┬───────────────────┘
         │
         ▼
    ┌────────────────────────┐
    │ Verificar Inventario   │
    │ (Stock mínimo)         │
    └────┬───────────────────┘
         │
         ▼
    ┌────────────────────────┐
    │ Calcular Comisiones    │
    │ (5% por vendedor)      │
    └────┬───────────────────┘
         │
         ▼
    ┌────────────────────────┐
    │ Generar Reporte PDF    │
    └────┬───────────────────┘
         │
         ▼
    ┌────────────────────────┐
    │ Mostrar Resumen        │
    └────┬───────────────────┘
         │
         ▼
    ┌────────────────────────┐
    │ ¿Confirmar?            │
    └────┬──────────┬────────┘
      SÍ │          │ NO
        │          └──► REVERTIR
        │
        ▼
    ┌────────────────────────┐
    │ Guardar Cierre         │
    │ Realizar Backup        │
    └────┬───────────────────┘
         │
         ▼
    ┌────────────────────────┐
    │ ✓ CIERRE COMPLETADO    │
    └────────────────────────┘
```

---

## 4. CONSIDERACIONES FINALES

### 4.1 Validaciones Críticas
- Verificar integridad de datos antes de procesamiento
- Validar que descuentos no superen el subtotal
- Confirmar disponibilidad de stock en ventas
- Validar códigos promocionales activos y dentro de límites

### 4.2 Seguridad
- Crear backup antes de cierre
- Registrar auditoría de cada operación
- Proteger acceso a reportes financieros
- Validar permisos de usuarios

### 4.3 Escalabilidad
- Permitir cierre parcial por vendedor o caja
- Soportar múltiples monedas
- Integración con sistemas contables
- Reportes en tiempo real

---

**Documento generado:** 22/01/2026
**Sistema:** Tienda la Economía - Sistema de Ventas
**Versión:** 1.0
