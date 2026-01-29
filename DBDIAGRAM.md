# Diagrama de Base de Datos - Sistema Médico

## Script para dbdiagram.io

Copia el siguiente código en https://dbdiagram.io/d y verás el diagrama de tu base de datos:

```
Table users {
  id int [pk]
  name varchar
  email varchar [unique]
  email_verified_at timestamp [null]
  password varchar
  remember_token varchar [null]
  created_at timestamp
  updated_at timestamp
}

Table sessions {
  id varchar [pk]
  user_id int [ref: > users.id]
  ip_address varchar
  user_agent text
  payload longtext
  last_activity int
}

Table personal {
  id int [pk]
  user_id int [ref: > users.id, not null]
  nombre varchar
  apellido varchar
  dni varchar [unique]
  tipo enum ['Doctor', 'Enfermero', 'Administrativo', 'Laboratorio']
  especialidad varchar [null]
  telefono varchar [null]
  email varchar [unique]
  fecha_contratacion date
  estado enum ['Activo', 'Inactivo']
  created_at timestamp
  updated_at timestamp
}

Table pacientes {
  id int [pk]
  nombre varchar
  apellido varchar
  dni varchar [unique]
  fecha_nacimiento date
  genero enum ['M', 'F', 'Otro']
  telefono varchar [null]
  email varchar [null]
  direccion text [null]
  grupo_sanguineo varchar [null]
  alergias text [null]
  enfermedades_cronicas text [null]
  estado varchar [null]
  meses_vida int [null]
  created_at timestamp
  updated_at timestamp
}

Table consultas {
  id int [pk]
  paciente_id int [ref: > pacientes.id, not null]
  doctor_id int [ref: > personal.id, not null]
  fecha_hora datetime
  motivo text
  diagnostico text [null]
  observaciones text [null]
  estado enum ['Pendiente', 'En Proceso', 'Concluida', 'Cancelada']
  costo decimal(10,2)
  created_at timestamp
  updated_at timestamp
}

Table examenes {
  id int [pk]
  paciente_id int [ref: > pacientes.id, not null]
  consulta_id int [ref: > consultas.id, null]
  solicitado_por int [ref: > personal.id, not null]
  tipo_examen varchar
  descripcion text [null]
  fecha_solicitud datetime
  fecha_realizacion datetime [null]
  resultados text [null]
  estado enum ['Solicitado', 'En Proceso', 'Concluido', 'Cancelado']
  costo decimal(10,2)
  created_at timestamp
  updated_at timestamp
}

Table tratamientos {
  id int [pk]
  paciente_id int [ref: > pacientes.id, not null]
  consulta_id int [ref: > consultas.id, null]
  doctor_id int [ref: > personal.id, not null]
  nombre_tratamiento varchar
  descripcion text
  medicamentos text [null]
  indicaciones text [null]
  fecha_inicio date
  fecha_fin date [null]
  estado enum ['Pendiente', 'En Proceso', 'Completado', 'Cancelado']
  costo decimal(10,2)
  created_at timestamp
  updated_at timestamp
}

Table compras {
  id int [pk]
  realizado_por int [ref: > personal.id, not null]
  proveedor varchar
  descripcion text
  monto_total decimal(10,2)
  fecha_compra date
  estado enum ['Pendiente', 'Aprobada', 'Recibida', 'Cancelada']
  observaciones text [null]
  created_at timestamp
  updated_at timestamp
}

Table detalle_compras {
  id int [pk]
  compra_id int [ref: > compras.id, not null]
  producto varchar
  cantidad int
  precio_unitario decimal(10,2)
  subtotal decimal(10,2)
  created_at timestamp
  updated_at timestamp
}
```

## Instrucciones:

1. Ve a https://dbdiagram.io/d
2. Limpia el contenido que viene por defecto
3. Copia y pega el código anterior
4. ¡Verás tu diagrama ER completo!

## Descripción de Relaciones:

- **users** (1) ↔ (N) **personal**: Cada usuario puede tener un perfil de personal
- **users** (1) ↔ (N) **sessions**: Sesiones de usuario
- **personal** (1) ↔ (N) **consultas**: Doctores realizan consultas
- **personal** (1) ↔ (N) **examenes**: Médicos solicitan exámenes
- **personal** (1) ↔ (N) **tratamientos**: Doctores asignan tratamientos
- **personal** (1) ↔ (N) **compras**: Personal realiza compras
- **pacientes** (1) ↔ (N) **consultas**: Pacientes tienen múltiples consultas
- **pacientes** (1) ↔ (N) **examenes**: Pacientes requieren exámenes
- **pacientes** (1) ↔ (N) **tratamientos**: Pacientes reciben tratamientos
- **consultas** (1) ↔ (N) **examenes**: Consultas pueden tener múltiples exámenes
- **consultas** (1) ↔ (N) **tratamientos**: Consultas generan tratamientos
- **compras** (1) ↔ (N) **detalle_compras**: Cada compra tiene múltiples detalles


 -- tabla para pdoer usarla en DBDiagrama.io

Enum tipo_personal {
  Doctor
  Enfermero
  Administrativo
  Laboratorio
}

Enum estado_general {
  Activo
  Inactivo
}

Enum genero_enum {
  M
  F
  Otro
}

Enum estado_consulta {
  Pendiente
  "En Proceso"
  Concluida
  Cancelada
}

Enum estado_examen {
  Solicitado
  "En Proceso"
  Concluido
  Cancelado
}

Enum estado_tratamiento {
  Pendiente
  "En Proceso"
  Completado
  Cancelado
}

Enum estado_compra {
  Pendiente
  Aprobada
  Recibida
  Cancelada
}

Table users {
  id int [pk]
  name varchar
  email varchar [unique]
  email_verified_at timestamp [null]
  password varchar
  remember_token varchar [null]
  created_at timestamp
  updated_at timestamp
}

Table sessions {
  id varchar [pk]
  user_id int [ref: > users.id]
  ip_address varchar
  user_agent text
  payload text
  last_activity int
}

Table personal {
  id int [pk]
  user_id int [ref: > users.id, not null]
  nombre varchar
  apellido varchar
  dni varchar [unique]
  tipo tipo_personal
  especialidad varchar [null]
  telefono varchar [null]
  email varchar [unique]
  fecha_contratacion date
  estado estado_general
  created_at timestamp
  updated_at timestamp
}

Table pacientes {
  id int [pk]
  nombre varchar
  apellido varchar
  dni varchar [unique]
  fecha_nacimiento date
  genero genero_enum
  telefono varchar [null]
  email varchar [null]
  direccion text [null]
  grupo_sanguineo varchar [null]
  alergias text [null]
  enfermedades_cronicas text [null]
  estado varchar [null]
  meses_vida int [null]
  created_at timestamp
  updated_at timestamp
}

Table consultas {
  id int [pk]
  paciente_id int [ref: > pacientes.id]
  doctor_id int [ref: > personal.id]
  fecha_hora datetime
  motivo text
  diagnostico text [null]
  observaciones text [null]
  estado estado_consulta
  costo decimal
  created_at timestamp
  updated_at timestamp
}

Table examenes {
  id int [pk]
  paciente_id int [ref: > pacientes.id]
  consulta_id int [ref: > consultas.id, null]
  solicitado_por int [ref: > personal.id]
  tipo_examen varchar
  descripcion text [null]
  fecha_solicitud datetime
  fecha_realizacion datetime [null]
  resultados text [null]
  estado estado_examen
  costo decimal
  created_at timestamp
  updated_at timestamp
}

Table tratamientos {
  id int [pk]
  paciente_id int [ref: > pacientes.id]
  consulta_id int [ref: > consultas.id, null]
  doctor_id int [ref: > personal.id]
  nombre_tratamiento varchar
  descripcion text
  medicamentos text [null]
  indicaciones text [null]
  fecha_inicio date
  fecha_fin date [null]
  estado estado_tratamiento
  costo decimal
  created_at timestamp
  updated_at timestamp
}

Table compras {
  id int [pk]
  realizado_por int [ref: > personal.id]
  proveedor varchar
  descripcion text
  monto_total decimal
  fecha_compra date
  estado estado_compra
  observaciones text [null]
  created_at timestamp
  updated_at timestamp
}

Table detalle_compras {
  id int [pk]
  compra_id int [ref: > compras.id]
  producto varchar
  cantidad int
  precio_unitario decimal
  subtotal decimal
  created_at timestamp
  updated_at timestamp
}
