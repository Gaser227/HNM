/*DROP database formatos;*/
create database formatos;
use formatos;
/*
select * from empleado;
select * from horario;
*/

create table tipoContrato(
	clave varchar(3) not null primary key,
	nombre varchar(20)
);

create table categoria(
	id int primary key AUTO_INCREMENT,
	nombre varchar(100),
	tipoContrato varchar(3) not null,
	CONSTRAINT FK_tipo_contrato FOREIGN KEY(tipoContrato) REFERENCES tipoContrato(clave) ON UPDATE CASCADE ON DELETE CASCADE
);

create table adscripcion(
	clave varchar(5) not null primary key,
	nombre varchar(50),
	nombreCompleto varchar(75),
	claveReporta varchar(5)
);

create table horario(
	id int primary key AUTO_INCREMENT,
	nombreHorario varchar(50),
	turno varchar(20),
	defHorarios varchar(255)
);

create table empleado(
	id int primary key AUTO_INCREMENT,
	nomina int not null ,
	nombre varchar(80),
	telefono varchar(13),
	correo varchar(50),
	autoriza int,
	fechaInicio date,
	fechaTermino date,
	fechaRegistro date,
	registro varchar(80),
	firmaEmpleado varchar(50),
	contrasena varchar(70),
	cambiaContrasena int,
	estado int,
	idHorario int not null,
	idAdscripcion varchar(5) not null,
	idCategoria int not null,
	CONSTRAINT FK_horario_2 FOREIGN KEY(idHorario) REFERENCES horario(id) ON UPDATE CASCADE ON DELETE NO ACTION,
	CONSTRAINT FK_adscripcion FOREIGN KEY(idAdscripcion) REFERENCES adscripcion(clave) ON UPDATE CASCADE ON DELETE NO ACTION,
	CONSTRAINT FK_categoria FOREIGN KEY(idCategoria) REFERENCES categoria(id) ON UPDATE CASCADE ON DELETE NO ACTION
);


create table formatos(
	id int primary key,
	folio int not null,
	tipoSolicitud varchar(40),
	estadoSolicitud varchar(15),
	fechaCreacion date,
	totalFirmas int,
	idEmpleado int not null,
	CONSTRAINT FK_empleadoFormatos FOREIGN KEY(idEmpleado) REFERENCES empleado(id) ON UPDATE CASCADE ON DELETE CASCADE
);

create table firma(
	id int primary key AUTO_INCREMENT,
	nombreResponsable varchar(40),
	firma varchar(40),
	fechaFirma date,
	idFormato int,
	CONSTRAINT FK_formatosFirma FOREIGN KEY(idFormato) REFERENCES formatos(id) ON UPDATE CASCADE ON DELETE CASCADE
);

create table entradaSalida(
	id int primary key,
	horaEntradaCubrir time,
	horaSalidaCubrir time,
	tipoEntradaSalida varchar(8),
	tipoMotivo varchar(20),
	horaRegreso time,
	tiempoTotal time,
	asunto varchar(200),
	horaEntradaCO time,
	horaSalidaCO time,
	observacionesCO varchar(150),
	fechaJustificada date,
	idFormato int not null,
	CONSTRAINT FK_formatosEntradaSalida FOREIGN KEY(idFormato) REFERENCES formatos(id) ON UPDATE CASCADE ON DELETE CASCADE
);

create table intercambioJornada(
	id int primary key,
	fechaCambioGuardia date,
	turnoCambio varchar(20),
	numeroIntercambio int,
	nominaSuplente int,
	nombreSuplente varchar(40),
	categoriaSuplente varchar(50),
	tipoPlaza varchar(20),
	tipoPago varchar(20),
	idFormato int not null,
	CONSTRAINT FK_formatosIntercambioJornada FOREIGN KEY(idFormato) REFERENCES formatos(id) ON UPDATE CASCADE ON DELETE CASCADE
);

create table dobleTurno(
	id int primary key,
	motivo varchar(150),
	categoriaCubrir varchar(50),
	diasCubrir int,
	turno varchar(20),
	horario varchar(20),
	idFormato int not null,
	CONSTRAINT FK_formatosDobleTurno FOREIGN KEY(idFormato) REFERENCES formatos(id) ON UPDATE CASCADE ON DELETE CASCADE
);

create table oficioComision(
	id int primary key,
	lugarComision varchar(150),
	centroCostos varchar(50),
	fechaInicio date,
	fechaFin date,
	objetoComision varchar(50),
	medioTransporte varchar(40),
	nombreSuplente varchar(40),
	nominaSuplente int,
	tipoTrabajador varchar(20),
	dictamen varchar(150),
	idFormato int not null,
	CONSTRAINT FK_formatosOficioComision FOREIGN KEY(idFormato) REFERENCES formatos(id) ON UPDATE CASCADE ON DELETE CASCADE

);

create table solicitudLicencia(
	id int primary key,
	goceSueldo bit,
	nombreSuplente varchar(40),
	nominaSuplente int,
	observaciones varchar(150),
	motivo varchar(150),
	dictamen varchar(150),
	idFormato int not null,
	CONSTRAINT FK_formatosLicencia FOREIGN KEY(idFormato) REFERENCES formatos(id) ON UPDATE CASCADE ON DELETE CASCADE
 );

create table solicitudSuplencia(
	id int primary key,
	fechaPeriodoInicio date,
	fechaPeriodoFin date,
	nombreSuplente varchar(40),
	nominaSuplente int,
	motivoSustitucion varchar(150),
	idFormato int not null,
	CONSTRAINT FK_formatosSuplencia FOREIGN KEY(idFormato) REFERENCES formatos(id) ON UPDATE CASCADE ON DELETE CASCADE
);

create table vacaciones(
	id int primary key,
	diasDisfrutar int,
	periodo varchar(20),
	fechaInicioVacaciones date,
	fechaReinicioLabores date,
	diasPendientes int,
	nombreSuplente varchar(40),
	nominaSuplente int,
	observaciones varchar(150),
	idFormato int not null,
	CONSTRAINT FK_formatosVacaciones FOREIGN KEY(idFormato) REFERENCES formatos(id) ON UPDATE CASCADE ON DELETE CASCADE
);

create table solicitudTramite(
	id int primary key,
	motivo varchar(150),
	periodo varchar(20),
	rfcBeneficiario varchar(15),
	observaciones varchar(150),
	idFormato int not null,
	CONSTRAINT FK_formatosTramite FOREIGN KEY(idFormato) REFERENCES formatos(id) ON UPDATE CASCADE ON DELETE CASCADE
);

create table festividad(
	id int primary key AUTO_INCREMENT,
	nombreFestividad varchar(50),
	fecha DATE,
);

insert into tipoContrato(clave,nombre)
values
('BS','Base sindicalizado'),
('C','Confianza'),
('G','Cuerpo de gobierno'),
('RL','Regimen de ley'),
('S','Suplente');

insert into categoria(nombre,tipoContrato)
values
('ANALISTA ADMINISTRATIVO','BS'),
('ASISTENTE','BS'),
('ANALISTA ADMINISTRATIVO ESPECIALIZADO','BS'),
('AUXILIAR DE ALMACEN','BS'),
('AUXILIAR DE INTENDENCIA','BS'),
('AUXILIAR DE RECURSOS MATERIALES','BS'),
('AUXILIAR DE SERVICIOS GENERALES','BS'),
('BIOLOGO','BS'),
('CAJERA','BS'),
('CAMILLERO','BS'),
('CHOFER','BS'),
('CONTROL OPERATIVO DEL PERSONAL','BS'),
('COORDINADOR DE ANESTESIA','BS'),
('DESARROLLO ORGANIZACIONAL','BS'),
('ENCARGADO DE FARMACIA','BS'),
('ENCEFALOGRAFISTA','BS'),
('ENFERMERA AUXILIAR','BS'),
('ENFERMERA ESPECIALISTA','BS'),
('ENFERMERA GENERAL','BS'),
('ENFERMERA JEFE DE PISO','BS'),
('INHALOTERAPEUTA','BS'),
('LAVANDERO COSTURERO','BS'),
('MEDICO ESPECIALISTA','BS'),
('MEDICO ESPECIALISTA 1/2','BS'),
('MEDICO SUBESPECIALISTA','BS'),
('MEDICO SUBESPECIALISTA (MEDIO TIEMPO)','BS'),
('MEDICO SUBESPECIALISTA (T/ESP)','BS'),
('NUTRIOLOGO','BS'),
('OFICIAL DE MANTENIMIENTO "A"','BS'),
('OFICIAL DE MANTENIMIENTO "B"','BS'),
('ORIENTACION Y SEGURIDAD','BS'),
('PROCESOS Y REDES','BS'),
('PROYECTOS Y SISTEMAS','BS'),
('PSICOLOGO','BS'),
('QUIMICO','BS'),
('SECRETARIA DE SUBDIRECCION "A"','BS'),
('SECRETARIA EJECUTIVA','BS'),
('SUPERVISOR DE ARCHIVO','BS'),
('SUPERVISOR DE INTENDENCIA','BS'),
('SUPERVISOR DE ROPERIA','BS'),
('SUPERVISORA DE ENFERMERIA','BS'),
('TECNICO EN AUTOPSIAS','BS'),
('TECNICO EN MANTENIMIENTO','BS'),
('TECNICO HISTOTECNOLOGO','BS'),
('TECNICO LABORATORISTA','BS'),
('TECNICO RADIOLOGO','BS'),
('TERAPIA DEL LENGUAJE','BS'),
('TRABAJADORA SOCIAL','BS'),
('VIGILANTE','BS'),
('ASISTENTE ADMINISTRATIVO DE DIRECCION','C'),
('ASISTENTE ADMINISTRATIVO GENERAL','C'),
('ASISTENTE DE DIRECCION MEDICA','C'),
('AUXILIAR CONTABLE','C'),
('AUXILIAR DE FINANZAS Y CONTABILIDAD "A"','C'),
('AUXILIAR DE FINANZAS Y CONTABILIDAD "B"','C'),
('AUXILIAR DE INFORMATICA','C'),
('AUXILIAR DE NOMINA','C'),
('AUXILIAR DE RECURSOS HUMANOS "A"','C'),
('AUXILIAR DE RECURSOS HUMANOS "B"','C'),
('AUXILIAR DE RECURSOS MATERIALES Y CONTROL PATRIMONIAL "A"','C'),
('AUXILIAR DE RECURSOS MATERIALES Y CONTROL PATRIMONIAL "B"','C'),
('AUXILIAR JURIDICO','C'),
('COORDINADOR DE HEMATO-ONCOLOGIA','C'),
('INGENIERO "A"','C'),
('INGENIERO "B"','C'),
('INGENIERO BIOMEDICO','C'),
('JEFE DE AREA','G'),
('JEFE DE AREA "A"','G'),
('SUPERVISOR DE CAJAS','C'),
('SUPERVISOR DE RECURSOS MATERIALES Y CONTROL PATRIMONIAL','C'),
('COORDINADOR DE AREA','G'),
('DIRECTOR DE DIVISION','G'),
('DIRECTOR DE UNIDAD','G'),
('DIRECTOR GENERAL','G'),
('DIRECTOR OPERATIVO','G'),
('ENLACE SOCIAL','G'),
('SUBDIRECTOR DE AREA','G'),
('SUBDIRECTOR DE UNIDAD','G'),
('APOYO ADMINISTRATIVO EN SALUD A-5','RL'),
('APOYO ADMINISTRATIVO EN SALUD A-6','RL'),
('APOYO ADMINISTRATIVO EN SALUD A-7','RL'),
('APOYO ADMINISTRATIVO EN SALUD A-8','RL'),
('ENFERMERA GENERAL TITULADA A','RL'),
('JEFE DE BIOLOGICOS Y REACTIVOS','RL'),
('MEDICO ESPECIALISTA A','RL'),
('MEDICO ESPECIALISTA A 1/2','RL'),
('MEDICO ESPECIALISTA B','RL'),
('MEDICO GENERAL "B"','RL'),
('MEDICO GENETISTA','RL'),
('PROFESIONAL EN COMUNICACI�N HUMANA','RL'),
('PSICOLOGO ESPECIALIZADO','RL'),
('ANALISTA ADMINISTRATIVO SUP','S'),
('APOYO ADMINISTRATIVO EN SALUD A-4','S'),
('AUXILIAR DE INTENDENCIA SUP','S'),
('CAJERA SUP','S'),
('ENFERMERA AUXILIAR SUP','S'),
('ENFERMERA GENERAL SUP','S'),
('INHALOTERAPEUTA SUP','S'),
('MEDICO ESPECIALISTA SUP','S'),
('NUTRI�LOGA SUP','S'),
('OFICIAL DE MANTENIMIENTO','S'),
('T�CNICO HISTOTECNOLOGO SUP','S'),
('T�CNICO RADI�LOGO SUP','S'),
('TRABAJADORA SOCIAL SUP','S');

insert into adscripcion(clave,nombre,nombreCompleto,claveReporta)
values
('DG','Direcci�n General','Direcci�n General',''),	
('DM','Direcci�n de Divisi�n M�dica','Direcci�n de Divisi�n M�dica','DG'),
('DA','Direcci�n de Divisi�n Administrativa','Direcci�n de Divisi�n Administrativa','DG'),
('DO','Direcci�n Operativa	','Direcci�n Operativa','DG'),
('CE','Consulta Externa','Direcci�n de Unidad de Consulta Externa','DM'),
('H','Hospitalizaci�n','Direcci�n de Unidad de Hospitalizaci�n','DM'),
('MCU','Medicina Cr�tica y Urgencias','Direcci�n de Unidad de Medicina Cr�tica y Urgencias','DM'),
('CA','Cirug�a y Anestesia','Direcci�n de Unidad de Cirug�a y Anestesia','DM'),
('SAD','Servicios Auxiliares y de Diagn�stico','Direcci�n de Unidad de Servicios Auxiliares y de Diagn�stico','DM'),
('EI','Ense�anza e Investigaci�n','Direcci�n de Unidad de Ense�anza e Investigaci�n','DM'),
('CMC','Calidad y Mejora Continua','Direcci�n de Unidad de Calidad y Mejora Continua','DM'),
('E','Enfermer�a','Subdirecci�n de Unidad de Enfermer�a','DM'),
('TS','Trabajo Social','Subdirecci�n de Unidad de Trabajo Social','DM'),
('L','Laboratorio','Subdirecci�n de Unidad de Laboratorio','SAD'),
('SJ','Servicios Jur�dicos','Coordinaci�n de �rea de Servicios Jur�dicos','DA'),
('CMI','Conservaci�n y Mantenimiento de Infraestructura','Coordinaci�n de �rea de Conservaci�n y Mantenimiento de Infraestructura','DA'),
('AP','Administraci�n de Personal','Coordinaci�n de �rea de Administraci�n de Personal','DA'),
('RMCP','Recursos Materiales y Control Patrimonial','Coordinaci�n de �rea de Recursos Materiales y Control Patrimonial','DA'),
('FC','Finanzas y Contabilidad','Coordinaci�n de �rea de Finanzas y Contabilidad','DA'),
('PD','Planeaci�n y Desarrollo','Coordinaci�n de �rea de Planeaci�n y Desarrollo','DA'),
('SG','Servicios Generales','Coordinaci�n de �rea de Servicios Generales','DA'),
('SOMC','Subdirecci�n de Organizaci�n y M�todos de Calidad','Subdireci�n de Subdirecci�n de Organizaci�n y M�todos de Calidad','CMC'),
('SSP','Subdirecci�n de Seguridad del Paciente','Subdireci�n de Subdirecci�n de Seguridad del Paciente','CMC'),
('SSH','Subdirecci�n de Seguridad Hospitalaria','Subdireci�n de Subdirecci�n de Seguridad Hospitalaria','CMC'),
('IE','Inform�tica y Estad�stica','Subdirecci�n de �rea de Inform�tica y Estad�stica','PD');

insert into horario(nombreHorario,turno)
values(
	'Ejemplo',
	'Matutino'
);

insert into empleado(nomina,nombre,telefono,correo,autoriza,fechaInicio,fechaTermino,fechaRegistro,registro,firmaEmpleado,contrasena,cambiaContrasena,estado,idHorario,idAdscripcion,idCategoria)
values(
	710, --nomina,
	'RAMIREZ OCAMPO ROSLYN', --nombre,
	'7771674246',--telefono,
	'prueba@gmail.com',--correo,
	0,--autoriza,
	'01/07/2013', --fechaInicio,
	'01/07/2013', --fechaTermino,
	'01/07/2013',--fechaRegistro,
	'Administrador',--registro,
	'roslin/roslin.png',--firmaEmpleado,
	'',--contrasena,
	1,--cambiaContrasena,
	1,--estado,
	1,--idHorario,
	'AP',--idAdscripcion,
	80--idCategoria
);

/*UPDATE empleado SET estado=1 WHERE id=1;*/

insert into empleado(nomina,nombre,telefono,correo,autoriza,fechaInicio,fechaTermino,fechaRegistro,registro,firmaEmpleado,contrasena,cambiaContrasena,estado,idHorario,idAdscripcion,idCategoria)
values(
	710, --nomina,
	'RAMIREZ OCAMPO ROSLYN', --nombre,
	'7771674246',--telefono,
	'prueba@gmail.com',--Correo,
	0,--autoriza,
	'01/07/2013', --fechaInicio,
	'01/07/2013',--fechaTermino,
	'01/07/2013',--fechaRegistro,
	'Administrador',--registro,
	'roslin/roslin.png',--firmaEmpleado,
	'',--contrasena,
	1,--cambiaContrasena,
	1,--estado,
	1,--idHorario,
	'AP',--idAdscripcion,
	80--idCategoria
);
/*La tabla tiene 17 datos*/
/*Se ingresan 16 Datos*/
insert into empleado(nomina,nombre,telefono,correo,autoriza,fechaInicio,fechaTermino,fechaRegistro,registro,firmaEmpleado,contrasena,cambiaContrasena,estado,idHorario,idAdscripcion,idCategoria)
values(
	555, /*--nomina, 1*/
	'Navarro Jose', /*--nombre,2*/
	'7773750925',/*--telefono,3*/
	'sonicjos.ys@gmail.com',/*--Correo,4*/
	0,/*--autoriza,5*/
	'2022/08/25',/* --fechaInicio,/*6*/
	'2022/12/31',/*--fechaTermino,/*7*/
	'2022/08/20',/*--fechaRegistro,/*8*/
	'Administrador',/*--registro,/*9*/
	'roslin/roslin.png',/*--firmaEmpleado,/*10*/
	'',/*--contrasena,/*12*/
	1,/*--cambiaContrasena,/*13*/
	1,/*--estado,/*14*/
	1,/*--idHorario,/*15*/
	'AP',/*--idAdscripcion,/*15*/
	80/*--idCategoria/*16s*/
);

SELECT * FROM empleado;
