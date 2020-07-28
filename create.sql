DROP DATABASE IF EXISTS ATF;
CREATE DATABASE IF NOT EXISTS ATF;
USE ATF;

CREATE TABLE IF NOT EXISTS LUGAR(
    id_lugar INT NOT NULL auto_increment,
    nombre_lugar VARCHAR(50) NOT NULL,
    tipo_lugar VARCHAR(12) NOT NULL CHECK(tipo_lugar IN('PAIS','ESTADO','MUNICIPIO','PARROQUIA','CALLE')),
    fk_lugar INT,
    PRIMARY KEY(id_lugar),
    FOREIGN KEY (fk_lugar) REFERENCES LUGAR(id_lugar)
);

create table if not exists PERSONA (
cedula_persona int not null unique,
nombre_persona varchar(200) not null,
apellido_persona varchar(200) not null,
correo_persona varchar(40),
fk_lugar int not null,
primary key (cedula_persona),
constraint fk_persona foreign key (fk_lugar) references LUGAR (id_lugar));

CREATE TABLE IF NOT EXISTS USUARIO(
    id_usuario INT NOT NULL auto_increment,
    nombre_usuario VARCHAR(10) NOT NULL UNIQUE,
  	passw_usuario VARCHAR(10) NOT NULL,
    fk_persona INT NOT NULL,
    PRIMARY KEY(id_usuario),
    FOREIGN KEY(fk_persona) REFERENCES PERSONA(cedula_persona)
);

CREATE TABLE IF NOT EXISTS HORARIO(
    id_horario INT NOT NULL auto_increment,
    hora_inicio_horario TIME NOT NULL,
    hora_final_horario TIME NOT NULL,
    dia_semana_hoario VARCHAR(9) NOT NULL CHECK(dia_semana_hoario IN('LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES')),
    PRIMARY KEY(id_horario)
);

CREATE TABLE IF NOT EXISTS TEMATICA(
    id_tematica INT NOT NULL auto_increment,
    nombre_tematica VARCHAR(20) NOT NULL,
    descripcion_tematica VARCHAR(100),
    PRIMARY KEY (id_tematica)
);

CREATE TABLE IF NOT EXISTS CATEGORIA(
    id_categoria INT NOT NULL auto_increment,
    nombre_categoria VARCHAR(50) NOT NULL,
    fk_categoria INT,
    PRIMARY KEY(id_categoria),
    FOREIGN KEY(fk_categoria) REFERENCES CATEGORIA(id_categoria)
);

create table if not exists SERVICIO (
id_servicio int not null auto_increment,
nombre_servicio varchar(60) not null,
modalidad_pago_servicio enum('HORA','CANTIDAD','NA') not null,
costo_servicio int,
precio_servicio int,
descuento_servicio int,
requiere_cita_servicio int not null,
detalles_servicio varchar(100),
fk_categoria int not null,
primary key (id_servicio),
constraint fk_servicio foreign key (fk_categoria) references CATEGORIA (id_categoria));

CREATE TABLE IF NOT EXISTS POST(
    id_post INT NOT NULL auto_increment,
    seccion_post VARCHAR(5) NOT NULL CHECK(seccion_post IN('BODA','XV','OTRO','DECORACION')),
    titulo_post VARCHAR(40) NOT NULL,
    cuerpo_post TEXT NOT NULL,
    PRIMARY KEY (id_post) 
);

CREATE TABLE IF NOT EXISTS SALON_FIESTA(
    id_servicio INT NOT NULL auto_increment,
 	capacidad_salon_fiesta INT NOT NULL,
 	vigilancia_salon_fiesta VARCHAR(20),
  	fk_lugar INT NOT NULL,
  	PRIMARY KEY(id_servicio),
 	FOREIGN KEY(fk_lugar) REFERENCES LUGAR(id_lugar),
	FOREIGN KEY(id_servicio) REFERENCES SERVICIO(id_servicio)
);

CREATE TABLE IF NOT EXISTS METODO_PAGO(
    id_metodo_pago INT NOT NULL auto_increment,
    descripcion_metodo_pago VARCHAR(100) NOT NULL,
    banco_metodo_pago VARCHAR(30) NOT NULL,
    numero_tdc int(16),
    fecha_vencimiento_tdc DATE,
    numero_tdd int(16),
    numero_transferencia VARCHAR(30),
    tipo VARCHAR(13) NOT NULL CHECK(tipo IN('TDC','TDD','TRANSFERENCIA')),
    PRIMARY KEY(id_metodo_pago)
);

CREATE TABLE IF NOT EXISTS RELIGION(
    id_religion INT NOT NULL auto_increment,
 	nombre_religion VARCHAR(20) NOT NULL,
  	PRIMARY KEY(id_religion)
);

CREATE TABLE IF NOT EXISTS TEMPLO(
    id_templo INT NOT NULL auto_increment,
    nombre_templo VARCHAR(150) NOT NULL,
    pagina_web_templo VARCHAR(150) NOT NULL,
    email_templo VARCHAR(150) NOT NULL,
    descripcion_templo VARCHAR(250),
    fk_persona INT NOT NULL, 
    fk_religion INT NOT NULL,
    fk_lugar INT NOT NULL,
    PRIMARY KEY(id_templo, fk_religion),
    FOREIGN KEY(fk_persona) REFERENCES PERSONA(cedula_persona),
    FOREIGN KEY(fk_religion) REFERENCES RELIGION(id_religion),
    FOREIGN KEY(fk_lugar) REFERENCES LUGAR(id_lugar)
);

CREATE TABLE IF NOT EXISTS PROVEEDOR(
    id_proveedor INT NOT NULL auto_increment,
    nombre_proveedor VARCHAR(50) NOT NULL,
    tipo_proveedor varchar(15) not null check(tipo_proveedor IN ('FLORES', 'ALIMENTOS', 'OTRO')),
    fk_lugar INT NOT NULL,
    PRIMARY KEY(id_proveedor),
    FOREIGN KEY(fk_lugar) REFERENCES LUGAR(id_lugar)
);

CREATE TABLE IF NOT EXISTS ORDEN_COMPRA(
    nro_orden_compra INT NOT NULL auto_increment,
 	fecha_orden_compra DATE NOT NULL,
  	total_orden_compra DOUBLE NOT NULL,
  	PRIMARY KEY(nro_orden_compra)
);

CREATE TABLE IF NOT EXISTS PRODUCTO(
    id_producto INT NOT NULL auto_increment,
    nombre_producto VARCHAR(20) NOT NULL,
    precio_producto DOUBLE NOT NULL,
    cantidad_disponible_producto INT NOT NULL,
    venta_ind_producto VARCHAR(2) NOT NULL CHECK(venta_ind_producto IN ('SI', 'NO')),
	descuento_producto INT,
    fk_categoria INT,
    PRIMARY KEY(id_producto),
    FOREIGN KEY(fk_categoria) REFERENCES CATEGORIA(id_categoria)
);

create table if not exists PRODUCTO_PROVEEDOR (
fk_proveedor int not null,
fk_producto int not null,
costo_und_producto_proveedor int not null,
primary key (fk_proveedor, fk_producto),
constraint fk_producto foreign key (fk_producto) references PRODUCTO (id_producto),
constraint fk_proveedor foreign key (fk_proveedor) references PROVEEDOR (id_proveedor));

CREATE TABLE IF NOT EXISTS DETALLE_COMPRA(
    cantidad_detalle_compra INT(5) NOT NULL,
    costo_total_detalle_compra INT(20) NOT NULL,
    fk_producto_proveedor INT NOT NULL,
    fk_producto_proveedor2 INT NOT NULL,
    fk_orden_compra INT NOT NULL,
    PRIMARY KEY(fk_producto_proveedor, fk_producto_proveedor2, fk_orden_compra),
    FOREIGN KEY(fk_producto_proveedor) REFERENCES PRODUCTO_PROVEEDOR(fk_producto),
    FOREIGN KEY(fk_producto_proveedor2) REFERENCES PRODUCTO_PROVEEDOR(fk_proveedor),
    FOREIGN KEY(fk_orden_compra) REFERENCES ORDEN_COMPRA(nro_orden_compra)
);

CREATE TABLE IF NOT EXISTS PUNTO_REFERENCIA(
    id_punto_refencia INT NOT NULL auto_increment,
    descripcion_punto_refencia VARCHAR(50) NOT NULL,
    fk_salon_fiesta INT NOT NULL,
    PRIMARY KEY(id_punto_refencia),
    FOREIGN KEY(fk_salon_fiesta) REFERENCES SALON_FIESTA(id_servicio)
);

CREATE TABLE IF NOT EXISTS DECORACION(
    id_servicio INT NOT NULL,
    fk_tematica INT NOT NULL,
    fk_persona INT NOT NULL,
    PRIMARY KEY(id_servicio),
    FOREIGN KEY (id_servicio) REFERENCES SERVICIO(id_servicio),
    FOREIGN KEY (fk_tematica) REFERENCES TEMATICA(id_tematica),
    FOREIGN KEY (fk_persona) REFERENCES PERSONA(cedula_persona)
);

create table if not exists TIPO_FIESTA (
id_tipo_fiesta int not null auto_increment,
nombre_tipo_fiesta varchar(60) not null,
descripcion_tipo_fiesta varchar(200),
primary key (id_tipo_fiesta));

CREATE TABLE IF NOT EXISTS FIESTA(
	id_fiesta INT NOT NULL auto_increment,
    fecha_realizacion_fiesta DATE NOT NULL,
 	hora_inicio_fiesta TIME NOT NULL,
 	hora_final_fiesta TIME NOT NULL,
 	cantidad_invitados_fiesta INT NOT NULL,
    fk_lugar INT NOT NULL,
    fk_tipo_fiesta INT NOT NULL,
	fk_tematica INT,
    PRIMARY KEY(id_fiesta),
 	FOREIGN KEY(fk_lugar) REFERENCES LUGAR(id_lugar),
	FOREIGN KEY(fk_tipo_fiesta) REFERENCES TIPO_FIESTA(id_tipo_fiesta),
 	FOREIGN KEY(fk_tematica) REFERENCES TEMATICA(id_tematica)
);

CREATE TABLE IF NOT EXISTS HORARIO_SERVICIO(
    fk_horario INT NOT NULL,
    fk_servicio INT NOT NULL,
    PRIMARY KEY (fk_horario, fk_servicio),
    FOREIGN KEY (fk_horario) REFERENCES HORARIO(id_horario),
    FOREIGN KEY (fk_servicio) REFERENCES SERVICIO(id_servicio)
);

CREATE TABLE IF NOT EXISTS CORTE_Y_COSTURA (
cedula_persona INT NOT NULL,
rol_cyc VARCHAR(10) NOT NULL,
PRIMARY KEY (cedula_persona),
FOREIGN KEY (cedula_persona) REFERENCES PERSONA(cedula_persona),
CONSTRAINT CHECK(rol_cyc='modista' OR rol_cyc='diseñador' OR rol_cyc='costurera')
);


create table if not exists TRABAJO_CYC ( 
id_trabajo_cyc INT NOT NULL auto_increment,
nombre_trabajo_cyc varchar(200) not null,
tiempo_realizacion_trabajo_cyc int not null,
tipo_tela_trabajo_cyc varchar(50) not null,
fk_cyc int not null,
primary key (id_trabajo_cyc, fk_cyc),
constraint fk_trabajo_cyc foreign key (fk_cyc) references CORTE_Y_COSTURA (cedula_persona));

create table if not exists JEFATURA (
id_jefatura int not null auto_increment,
nombre_jefatura varchar(200) not null,
fk_lugar int not null,
fk_persona int not null,
primary key (id_jefatura),
constraint fk_lugar foreign key (fk_lugar) references LUGAR (id_lugar),
constraint fk_persona_jefatura foreign key (fk_persona) references PERSONA (cedula_persona));

create table if not exists NOTARIA (
id_notaria int not null auto_increment,
nombre_notaria varchar(200) not null,
fk_lugar int not null,
primary key (id_notaria),
constraint fk_lugar_notaria foreign key (fk_lugar) references LUGAR (id_lugar));

create table if not exists COORDENADA (
id_coordenada int not null auto_increment,
x_coordenada int not null,
y_coordenada int not null,
fk_jefatura int,
fk_templo int,
fk_notaria int,
primary key (id_coordenada),
constraint fk_jefatura foreign key (fk_jefatura) references JEFATURA (id_jefatura),
constraint fk_templo foreign key (fk_templo) references TEMPLO (id_templo),
constraint fk_notaria foreign key (fk_notaria) references NOTARIA (id_notaria));

CREATE TABLE IF NOT EXISTS PRESUPUESTO(
    id_presupuesto INT NOT NULL auto_increment,
    fecha_presupuesto DATE NOT NULL,
    fk_persona INT NOT NULL,
    fk_fiesta INT NOT NULL,
    PRIMARY KEY(id_presupuesto),
    FOREIGN KEY(fk_persona) REFERENCES PERSONA(cedula_persona),
    FOREIGN KEY(fk_fiesta) REFERENCES FIESTA(id_fiesta)
);

CREATE TABLE IF NOT EXISTS CONTRATO(
    id_contrato INT NOT NULL auto_increment,
 	fecha_aprobado_contrato DATE NOT NULL,
    fecha_pagado_contrato DATE,
	monto_total_contrato DOUBLE NOT NULL,
    fk_presupuesto INT NOT NULL,
 	fk_usuario INT NOT NULL,
  	PRIMARY KEY(id_contrato),
    FOREIGN KEY(fk_presupuesto) REFERENCES PRESUPUESTO(id_presupuesto),
 	FOREIGN KEY(fk_usuario) REFERENCES USUARIO(id_usuario)
);

create table if not exists RESERVA (
id_reserva int not null auto_increment,
fecha_reserva date not null,
tiempo_reserva int not null,
fk_contrato int not null,
fk_servicio int not null,
fk_jefatura int not null,
fk_templo int not null,
primary key (id_reserva, fk_contrato),
constraint fk_contrato foreign key (fk_contrato) references CONTRATO (id_contrato),
constraint fk_servicio_reserva foreign key (fk_servicio) references SERVICIO (id_servicio),
constraint fk_jefatura_reserva foreign key (fk_jefatura) references JEFATURA (id_jefatura),
constraint fk_templo_reserva foreign key (fk_templo) references TEMPLO (id_templo));

CREATE TABLE IF NOT EXISTS CITA(
    id_reserva INT NOT NULL,
    id_reserva_2 INT NOT NULL,
    fk_lugar INT NOT NULL,
    PRIMARY KEY(id_reserva, id_reserva_2),
    FOREIGN KEY(id_reserva) REFERENCES RESERVA(id_reserva),
    FOREIGN KEY(id_reserva_2) REFERENCES RESERVA(fk_contrato),
    FOREIGN KEY(fk_lugar) REFERENCES LUGAR(id_lugar)
);

create table if not exists PRODUCTO_SERVICIO (
fk_servicio int not null,
fk_producto int not null,
primary key (fk_servicio, fk_producto),
constraint fk_servicio_producto_servicio foreign key (fk_servicio) references SERVICIO (id_servicio),
constraint fk_producto_producto_servicio foreign key (fk_producto) references PRODUCTO (id_producto));

CREATE TABLE IF NOT EXISTS AMBIENTE(
    id_ambiente INT NOT NULL auto_increment,
 	nombre_ambiente VARCHAR(20) NOT NULL,
  	PRIMARY KEY(id_ambiente)
);

create table if not exists AMBIENTE_SALON (
fk_salon_fiesta int not null,
fk_ambiente int not null,
primary key (fk_salon_fiesta, fk_ambiente),
constraint fk_salon_fiesta foreign key (fk_salon_fiesta) references SALON_FIESTA (id_servicio),
constraint fk_ambiente foreign key (fk_ambiente) references AMBIENTE (id_ambiente));

create table if not exists SERVICIO_PRESUPUESTO (
id_servicio_presupuesto int not null auto_increment,
precio_total_servicio_presupuesto int not null,
cantidad_servicio_presupuesto int,
detalles_servicio_presupuesto varchar(100),
fk_presupuesto int not null,
fk_servicio int not null,
primary key (id_servicio_presupuesto),
constraint fk_presupuesto_servicio foreign key (fk_presupuesto) references PRESUPUESTO (id_presupuesto),
constraint fk_servicio_presupuesto foreign key (fk_servicio) references SERVICIO (id_servicio));

create table if not exists PAGO (
id_pago int not null auto_increment,
monto_pago int not null,
fecha_realizacion_pago date not null,
fk_contrato int not null,
fk_metodo_de_pago int not null,
primary key (id_pago, fk_contrato),
constraint fk_contrato_pago foreign key (fk_contrato) references CONTRATO (id_contrato),
constraint fk_metodo_de_pago foreign key (fk_metodo_de_pago) references METODO_PAGO (id_metodo_pago));

create table if not exists PRODUCTO_PEDIDO (
cantidad_producto_pedido int not null,
fk_producto int not null,
fk_servicio_presupuesto int not null,
primary key (fk_producto, fk_servicio_presupuesto),
constraint fk_producto_pedido foreign key (fk_producto) references PRODUCTO (id_producto),
constraint fk_servicio_presupuesto_producto_pedido foreign key (fk_servicio_presupuesto) references SERVICIO_PRESUPUESTO (id_servicio_presupuesto));

create table if not exists ROL (
id_rol int not null auto_increment,
nombre_rol varchar(50) not null unique,
primary key (id_rol));

create table if not exists ROL_USUARIO (
fk_rol int not null,
fk_usuario int not null,
primary key (fk_rol, fk_usuario),
constraint fk_rol foreign key (fk_rol) references ROL (id_rol),
constraint fk_usuario foreign key (fk_usuario) references USUARIO (id_usuario));

create table if not exists PERMISO (
id_permiso int not null auto_increment,
nombre_permiso varchar(50) not null unique,
primary key (id_permiso));

create table if not exists ROL_PERMISO (
fk_rol int not null,
fk_permiso int not null,
primary key (fk_rol, fk_permiso),
constraint fk_rol_permiso foreign key (fk_rol) references ROL (id_rol),
constraint fk_permiso foreign key (fk_permiso) references PERMISO (id_permiso));

CREATE TABLE IF NOT EXISTS CONTRATO_TERCERO(
    id_contrato_tercero INT NOT NULL auto_increment,
 	fecha_aprobado_contrato_tercero DATE NOT NULL,
    fecha_pagado_contrato_tercero DATE,
 	fk_contrato INT NOT NULL,
    fk_servicio_presupuesto INT NOT NULL,
  	PRIMARY KEY(id_contrato_tercero),
    FOREIGN KEY(fk_contrato) REFERENCES CONTRATO(id_contrato),
 	FOREIGN KEY(fk_servicio_presupuesto) REFERENCES SERVICIO_PRESUPUESTO(id_servicio_presupuesto)
);

CREATE TABLE IF NOT EXISTS SERVICIO_TIPO_FIESTA(
    id_servicio_tipo_fiesta INT NOT NULL auto_increment,
 	nombre_servicio_tipo_fiesta VARCHAR(20) NOT NULL,
    descripcion_servicio_tipo_fiesta VARCHAR(100),
    fk_tipo_fiesta INT NOT NULL,
 	fk_servicio INT NOT NULL,
  	PRIMARY KEY(id_servicio_tipo_fiesta, fk_tipo_fiesta, fk_servicio),
    FOREIGN KEY(fk_tipo_fiesta) REFERENCES TIPO_FIESTA(id_tipo_fiesta),
 	FOREIGN KEY(fk_servicio) REFERENCES SERVICIO(id_servicio)
);

CREATE TABLE IF NOT EXISTS SERVICIO_TERCERIZADO(
    id_servicio INT NOT NULL auto_increment,
 	fk_persona INT NOT NULL,
	tipo_servicio_tercerizado VARCHAR(100),
  	PRIMARY KEY(id_servicio),
 	FOREIGN KEY(id_servicio) REFERENCES SERVICIO(id_servicio),
    FOREIGN KEY(fk_persona) REFERENCES PERSONA(cedula_persona)
);

CREATE TABLE IF NOT EXISTS ESTACIONAMIENTO(
    id_estacionamiento INT NOT NULL auto_increment,
 	cantidad_de_puestos_estacionamiento INT NOT NULL,
 	descripcion_estacionamiento VARCHAR(100),
  	fk_salon_fiesta INT NOT NULL,
  	PRIMARY KEY(id_estacionamiento),
 	FOREIGN KEY(fk_salon_fiesta) REFERENCES SALON_FIESTA(id_servicio)
);

create table if not exists CURSO_MATRIM (
id_curso_matrim int not null auto_increment,
fecha_inicio_curso_matrim date not null,
fecha_final_curso_matrim date not null,
costo_curso_matrim int not null,
descripcion_curso_matrim varchar(200),
cupos_curso_matrim int not null,
fk_templo int not null,
primary key (id_curso_matrim, fk_templo),
constraint fk_templo_curso foreign key (fk_templo) references TEMPLO (id_templo));

CREATE TABLE IF NOT EXISTS INSCRIPCION_CUR_M(
    fk_curso_matrim_1 INT NOT NULL,
	fk_curso_matrim_2 INT NOT NULL,
	fk_presupuesto INT NOT NULL,
    PRIMARY KEY(fk_curso_matrim_1, fk_curso_matrim_2, fk_presupuesto),
    FOREIGN KEY(fk_curso_matrim_1) REFERENCES CURSO_MATRIM(id_curso_matrim),
	FOREIGN KEY(fk_curso_matrim_2) REFERENCES CURSO_MATRIM(fk_templo),
	FOREIGN KEY(fk_presupuesto) REFERENCES PRESUPUESTO(id_presupuesto)
);

CREATE TABLE IF NOT EXISTS ESTADO (
id_estado INT NOT NULL auto_increment,
nombre_estado VARCHAR(20) NOT NULL UNIQUE,
PRIMARY KEY (id_estado)
);

CREATE TABLE IF NOT EXISTS ESTADO_CONTRATO (
fk_estado INT NOT NULL,
fk_contrato INT NOT NULL,
fecha_inicio_estado_contrato DATE NOT NULL,
fecha_fin_estado_contrato DATE,
PRIMARY KEY (fk_estado, fk_contrato),
FOREIGN KEY (fk_estado) REFERENCES ESTADO(id_estado),
FOREIGN KEY (fk_contrato) REFERENCES CONTRATO(id_contrato)
);

CREATE TABLE IF NOT EXISTS ESTADO_P_P (
fk_estado INT NOT NULL,
fk_producto_pedido_1 INT NOT NULL,
fk_producto_pedido_2 INT NOT NULL,
fecha_inicio_estado_p_p DATE NOT NULL,
fecha_fin_estado_p_p DATE,
PRIMARY KEY (fk_estado, fk_producto_pedido_1, fk_producto_pedido_2),
FOREIGN KEY (fk_estado) REFERENCES ESTADO(id_estado),
FOREIGN KEY (fk_producto_pedido_1) REFERENCES PRODUCTO_PEDIDO(fk_producto),
FOREIGN KEY (fk_producto_pedido_2) REFERENCES PRODUCTO_PEDIDO(fk_servicio_presupuesto)
);

CREATE TABLE IF NOT EXISTS ESTADO_PRESUPUESTO (
fk_estado INT NOT NULL,
fk_presupuesto INT NOT NULL,
fecha_inicio_estado_presupuesto DATE NOT NULL,
fecha_fin_estado_presupuesto DATE,
PRIMARY KEY (fk_estado, fk_presupuesto),
FOREIGN KEY (fk_estado) REFERENCES ESTADO(id_estado),
FOREIGN KEY (fk_presupuesto) REFERENCES PRESUPUESTO(id_presupuesto)
);

CREATE TABLE IF NOT EXISTS ESTADO_DETALLE (
fk_estado INT NOT NULL,
fk_detalle_compra_1 INT NOT NULL,
fk_detalle_compra_2 INT NOT NULL,
fk_detalle_compra_3 INT NOT NULL,
fecha_inicio_detalle DATE NOT NULL,
fecha_fin_detalle DATE,
PRIMARY KEY (fk_estado, fk_detalle_compra_1, fk_detalle_compra_2, fk_detalle_compra_3),
FOREIGN KEY (fk_estado) REFERENCES ESTADO(id_estado),
constraint fk1 FOREIGN KEY (fk_detalle_compra_1) REFERENCES DETALLE_COMPRA (fk_producto_proveedor),
constraint fk2 FOREIGN KEY (fk_detalle_compra_2) REFERENCES DETALLE_COMPRA (fk_producto_proveedor2),
constraint fk3 FOREIGN KEY (fk_detalle_compra_3) REFERENCES DETALLE_COMPRA (fk_orden_compra)
);

CREATE TABLE IF NOT EXISTS TELEFONO(
    id_telefono INT NOT NULL auto_increment,
    codigo_area_telefono TINYINT NOT NULL,
    numero_telefono TINYINT NOT NULL,
    fk_templo INT,
    fk_jefatura INT,
    fk_persona INT,
    fk_proveedor INT,
    fk_salon INT,
    PRIMARY KEY(id_telefono),
    FOREIGN KEY(fk_templo) REFERENCES TEMPLO(id_templo),
    FOREIGN KEY(fk_jefatura) REFERENCES JEFATURA(id_jefatura),
    FOREIGN KEY(fk_persona) REFERENCES PERSONA(cedula_persona),
    FOREIGN KEY(fk_proveedor) REFERENCES PROVEEDOR(id_proveedor),
    FOREIGN KEY(fk_salon) REFERENCES SALON_FIESTA(id_servicio)
);

CREATE TABLE IF NOT EXISTS IMAGEN(
    id_imagen INT NOT NULL auto_increment,
    ruta_imagen VARCHAR(200) NOT NULL,
    fk_templo INT,
    fk_trabajo_cyc INT,
    fk_trabajo_cyc_2 INT,
    fk_jefatura INT,
    fk_persona INT,
    fk_producto INT,
    fk_servicio INT,
    fk_post INT,
    PRIMARY KEY(id_imagen),
    FOREIGN KEY(fk_templo) REFERENCES TEMPLO(id_templo),
    FOREIGN KEY(fk_trabajo_cyc) REFERENCES TRABAJO_CYC(id_trabajo_cyc),
    FOREIGN KEY(fk_trabajo_cyc_2) REFERENCES TRABAJO_CYC(fk_cyc),
    FOREIGN KEY(fk_jefatura) REFERENCES JEFATURA(id_jefatura),
    FOREIGN KEY(fk_persona) REFERENCES PERSONA(cedula_persona),
    FOREIGN KEY(fk_producto) REFERENCES PRODUCTO(id_producto),
    FOREIGN KEY(fk_servicio) REFERENCES SERVICIO(id_servicio),
    FOREIGN KEY(fk_post) REFERENCES POST(id_post)
);