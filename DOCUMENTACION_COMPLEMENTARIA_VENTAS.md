# DOCUMENTACIÓN COMPLEMENTARIA - SISTEMA DE VENTAS
## Tienda la Economía

---

## 1. DIAGRAMA ENTIDAD-RELACIÓN (E-R)

```
┌──────────────────────────────────────────────────────────────────────────┐
│                        MODELO DE DATOS                                    │
└──────────────────────────────────────────────────────────────────────────┘

                                ┌─────────────┐
                                │  CLIENTE    │
                                ├─────────────┤
                                │*ID_Cliente  │◄──┐
                                │ Nombre      │   │
                                │ Apellido    │   │
                                │ DNI         │   │
                                │ Email       │   │
                                │ Tipo_Cli..  │   │
                                │ Desc_Fijo   │   │
                                └─────────────┘   │
                                      △           │
                                      │           │
                                      │ 1:N       │
                                      │           │
                         ┌────────────┴───────────┐
                         │                        │
                         │                        │
                    ┌────▼──────────┐       ┌─────▼──────┐
                    │    VENTA      │       │  VENDEDOR  │
                    ├───────────────┤       ├────────────┤
                    │*ID_Venta      │       │*ID_Vendedor│
                    │ ID_Cliente    │◄──────┤ Nombre     │
                    │ ID_Vendedor   │       │ Cargo      │
                    │ Fecha_Venta   │       │ Comisión%  │
                    │ Subtotal      │       │ Estado     │
                    │ Descuento_Tot │       └────────────┘
                    │ Impuesto      │
                    │ Total         │
                    │ Método_Pago   │
                    │ Estado_Venta  │
                    │ Num_Factura   │
                    └────┬──────────┘
                         │ 1:N
                         │
                    ┌────▼──────────────┐
                    │  DETALLE_VENTA    │
                    ├───────────────────┤
                    │*ID_Detalle        │
                    │ ID_Venta          │
                    │ ID_Producto       │◄────┐
                    │ Cantidad          │     │
                    │ Precio_Unitario   │     │
                    │ Descuento_Linea   │     │
                    │ Total_Linea       │     │
                    └───────────────────┘     │
                                              │
                                         ┌────┴────────┐
                                         │  PRODUCTO   │
                                         ├─────────────┤
                                         │*ID_Producto │
                                         │ Nombre      │
                                         │ Descripcion │
                                         │ Precio_Unit │
                                         │ Cantidad_St │
                                         │ Categoria   │
                                         │ Proveedor_ID│
                                         │ Margen_Gan. │
                                         │ Estado      │
                                         └─────────────┘

                         ┌──────────────────────┐
                         │     DESCUENTO       │
                         ├──────────────────────┤
                         │*ID_Descuento        │
                         │ Codigo               │
                         │ Descripcion          │
                         │ Tipo                 │
                         │ Valor                │
                         │ Minimo_Compra        │
                         │ Maximo_Aplicacion    │
                         │ Usos_Actuales        │
                         │ Fecha_Inicio         │
                         │ Fecha_Fin            │
                         │ Estado               │
                         └──────────────────────┘

                      ┌──────────────────────┐
                      │   CIERRE_DIARIO      │
                      ├──────────────────────┤
                      │*ID_Cierre            │
                      │ Fecha                │
                      │ Hora                 │
                      │ Usuario              │
                      │ Cantidad_Ventas      │
                      │ Total_Ventas         │
                      │ Total_Descuentos     │
                      │ Total_Impuestos      │
                      │ Total_Comisiones     │
                      │ Utilidad_Neta        │
                      │ Estado               │
                      └──────────────────────┘
```

---

## 2. EJEMPLOS PRÁCTICOS DE CÁLCULO

### 2.1 Ejemplo 1: Cliente Regular - Sin Código

**Datos:**
- Cliente: Juan Pérez (Regular)
- Productos:
  - Laptop $800 x 1
  - Mouse $20 x 2
- Subtotal: $840

**Cálculo:**
```
Subtotal:                    $840.00
Descuento (8% por vol):      -$67.20
Subtotal después descuento:  $772.80
IVA (19%):                   +$146.83
TOTAL A PAGAR:               $919.63

Validación:
✓ Subtotal >= $500 → Aplica 8% descuento
✓ Límite máximo para Regular: 10% (8% < 10% ✓)
```

### 2.2 Ejemplo 2: Cliente Premium - Con Código Válido

**Datos:**
- Cliente: María García (Premium)
- Productos:
  - Monitor $400 x 2
  - Teclado $80 x 1
- Subtotal: $880
- Código: "BIENVENIDA" (+5%)
- Verificación:
  - Código vigente: SÍ
  - Monto mínimo ($100): SÍ
  - Usos disponibles: SÍ

**Cálculo:**
```
Subtotal:                       $880.00

Descuento Cliente:
  Tipo Premium + $200-299: 10%  -$88.00

Descuento Código:
  BIENVENIDA: 5%                -$44.00

Descuento Total:
  MAX(10%, 5%) = 10%            -$88.00
  Código no se acumula
  
Subtotal después descuento:     $792.00
IVA (19%):                      +$150.48
TOTAL A PAGAR:                  $942.48

Validación:
✓ Tipo Premium ≥ $200 → 10% descuento
✓ Código BIENVENIDA válido
✓ Límite máximo Premium: 15% (10% < 15% ✓)
```

### 2.3 Ejemplo 3: Cliente VIP - Máximo Descuento

**Datos:**
- Cliente: Carlos López (VIP)
- Productos:
  - Servidor $3000 x 1
  - SSD $600 x 2
- Subtotal: $4200
- Código: "NAVIDAD2025" (10%)

**Cálculo:**
```
Subtotal:                        $4200.00

Descuento Cliente:
  Tipo VIP + >= $300: 15%        -$630.00

Descuento Código:
  NAVIDAD2025: 10%               -$420.00

Comparación:
  MAX(15%, 10%) = 15%            (usar el mayor)
  
Límite máximo VIP: 20%
  Descuento 15% < 20% ✓ VÁLIDO

Subtotal después descuento:      $3570.00
IVA (19%):                       +$678.30
TOTAL A PAGAR:                   $4248.30

Validación:
✓ Tipo VIP >= $300 → 15% descuento
✓ Código NAVIDAD2025 válido (menos descuento que el del cliente)
✓ Se aplica el mayor: 15%
✓ Límite máximo VIP: 20% (15% < 20% ✓)
```

### 2.4 Ejemplo 4: Cierre Diario Completo

**Datos del Día: 22/01/2026**

```
VENTAS DEL DÍA:

Venta 001: Cliente Regular - $500.00 (Método: Efectivo)
           Descuento: 10% = $50.00
           IVA: $85.50
           Total: $535.50

Venta 002: Cliente Premium - $1200.00 (Método: Tarjeta)
           Descuento: 15% = $180.00
           IVA: $193.80
           Total: $1213.80

Venta 003: Cliente VIP - $2000.00 (Método: Cheque)
           Descuento: 20% = $400.00
           IVA: $304.00
           Total: $1904.00

Venta 004: Cliente Regular - $300.00 (Método: Efectivo)
           Descuento: 5% = $15.00
           IVA: $54.25
           Total: $339.25

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

CONSOLIDACIÓN DEL CIERRE:

Total Bruto (Subtotales):        $4000.00
Total Descuentos Aplicados:      -$645.00
                                  (16.1% del bruto)

Total Impuestos (19%):           +$637.55

────────────────────────────────────────────────────
TOTALES POR MÉTODO DE PAGO:

Efectivo:                        $874.75
Tarjeta:                        $1213.80
Cheque:                         $1904.00
────────────────────────────────────────────────────
TOTAL NETO (Ingresos):          $3992.55

CÁLCULO DE COMISIONES (5%):

Vendedor 001 (2 ventas):
  Total vendido: $835.50
  Comisión (5%): $41.78

Vendedor 002 (2 ventas):
  Total vendido: $3117.80
  Comisión (5%): $155.89

Total Comisiones:               -$197.67

════════════════════════════════════════════════════════════
UTILIDAD NETA DEL DÍA:          $3794.88
════════════════════════════════════════════════════════════
```

---

## 3. REGLAS DE NEGOCIO

### 3.1 Validaciones Obligatorias

| Regla | Descripción | Acción |
|-------|-------------|--------|
| R001 | El cliente debe existir en BD | Rechazar venta si no existe |
| R002 | Stock debe ser suficiente | Advertencia si stock insuficiente |
| R003 | Precio unitario >= 0 | No permitir precios negativos |
| R004 | Cantidad vendida > 0 | Rechazar ventas con cantidad 0 |
| R005 | Descuento no supera subtotal | Limitar descuento a máximo permitido |
| R006 | Código válido y vigente | Rechazar códigos expirados o inactivos |
| R007 | Método pago debe ser válido | Solo: Efectivo, Tarjeta, Cheque |
| R008 | Factura única por día | No permitir números duplicados |

### 3.2 Reglas de Descuento

| Regla | Condición | Beneficio | Límite |
|-------|-----------|-----------|--------|
| RD01 | Cliente Regular + <$100 | 0% | - |
| RD02 | Cliente Regular + $100-$499 | 5% | 10% máx |
| RD03 | Cliente Regular + ≥$500 | 8% | 10% máx |
| RD04 | Cliente Premium + cualquiera | 5% | 15% máx |
| RD05 | Cliente Premium + ≥$200 | 10% | 15% máx |
| RD06 | Cliente VIP + cualquiera | 10% | 20% máx |
| RD07 | Cliente VIP + ≥$300 | 15% | 20% máx |
| RD08 | Código BIENVENIDA | +5% | Si válido |
| RD09 | Código DIASEMANA | +3% | L-V solamente |
| RD10 | Código NAVIDAD2025 | +10% | Hasta 31/12/2025 |

---

## 4. LISTA DE CHEQUEO PARA CIERRE

```
╔══════════════════════════════════════════════════════════╗
║         CHECKLIST DIARIO - CIERRE DE VENTAS             ║
╠══════════════════════════════════════════════════════════╣
║                                                          ║
║ □ ANTES DEL CIERRE:                                      ║
║   □ Verificar que no haya ventas pendientes              ║
║   □ Validar integridad de base de datos                  ║
║   □ Revisar alertas de stock bajo                        ║
║   □ Confirmar acceso a sistema                           ║
║                                                          ║
║ □ DURANTE EL CIERRE:                                     ║
║   □ Procesar todas las ventas completadas                ║
║   □ Calcular descuentos correctamente                    ║
║   □ Verificar método de pago en cada venta               ║
║   □ Calcular comisiones de vendedores                    ║
║   □ Generar reportes                                     ║
║                                                          ║
║ □ VALIDACIONES FINALES:                                  ║
║   □ Totales coinciden con punto de venta                 ║
║   □ Descuentos dentro de límites permitidos              ║
║   □ Impuestos calculados correctamente (19%)             ║
║   □ Métodos de pago contabilizan correctamente           ║
║   □ Comisiones calculadas para todos los vendedores      ║
║                                                          ║
║ □ DESPUÉS DEL CIERRE:                                    ║
║   □ Guardar cierre en BD                                 ║
║   □ Realizar backup de base de datos                     ║
║   □ Generar reportes PDF                                 ║
║   □ Imprimir resumen del día                             ║
║   □ Enviar notificación a gerencia                       ║
║   □ Registrar en auditoría                               ║
║                                                          ║
╚══════════════════════════════════════════════════════════╝
```

---

## 5. TABLA COMPARATIVA DE MÉTODOS DE CÁLCULO

### Método A: Descuento Acumulativo (NO PERMITIDO)
```
Base:        $1000
Dscto Cli:   -$100 (10%)
Base 2:       $900
Dscto Código: -$45 (5%)
Total:        $855  ← Demasiado bajo
```

### Método B: Mayor Descuento (MÉTODO UTILIZADO)
```
Base:          $1000
Dscto Cli:     -$100 (10%)
Dscto Código:  -$50  (5%)
Usar MAYOR:    -$100 (10%)
Total:          $900  ← Correcto
```

### Método C: Promedio de Descuentos (NO PERMITIDO)
```
Base:          $1000
Promedio:      (10% + 5%) / 2 = 7.5%
Dscto:         -$75
Total:          $925  ← Injusto
```

---

## 6. TABLA DE HORARIOS DE CIERRE

| Día | Hora Cierre | Responsable | Validación |
|-----|-------------|-------------|-----------|
| Lunes-Viernes | 19:00 | Vendedor + Supervisor | Estándar |
| Sábado | 20:00 | Vendedor + Gerente | Estándar |
| Domingo | 19:00 | Vendedor + Gerente | Ampliada |
| Festivos | 18:00 | Gerente + Contador | Crítica |

---

**Documento Complementario**
**Tienda la Economía**
**Sistema de Ventas v1.0**
