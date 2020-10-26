-- Creacion de la base de datos
CREATE DATABASE KodePrintDB

	-- Creacion de tabla USUARIO
	CREATE TABLE usuario ( `codigo` INT NOT NULL AUTO_INCREMENT , `usuario` VARCHAR(50) NOT NULL , `email` VARCHAR(50) NOT NULL, 
								`clave` VARCHAR(255) NOT NULL , `fecha_crea` DATE NOT NULL, `fecha_act` DATE,  
								`tipo` INT NOT NULL, PRIMARY KEY (`codigo`))

-- Creacion de tabla DEPARTAMENTO
CREATE TABLE departamento ( `id` INT NOT NULL AUTO_INCREMENT , `codigo` VARCHAR(2) NOT NULL , `nombre` VARCHAR(50) NOT NULL , 
							PRIMARY KEY (`id`))

-- Insertando Departamentos de Gautemal
INSERT INTO `departamento` (`codigo`, `nombre`) 
	VALUES 	('01', 'GUATEMALA'), ('02', 'EL PROGRESO'), ('03', 'SACATEPEQUEZ'), ('04', 'CHIMALTENANGO'),
            ('05', 'ESCUINTLA'), ('06', 'SANTA ROSA'), ('07', 'SOLOLA'), ('08', 'TOTONICAPAN'),
            ('09', 'QUETZALTENANGO'), ('10', 'SUCHITEPEQUEZ'), ('11', 'RETALHULEU '), ('12', 'SAN MARCOS'),
            ('13', 'HUEHUETENANGO'), ('14', 'EL QUICHE'), ('15', 'BAJA VERAPAZ'), ('16', 'ALTA VERAPAZ'),
            ('17', 'EL PETEN'), ('18', 'IZABAL'), ('19', 'ZACAPA'), ('20', 'CHIQUIMULA'),
            ('21', 'JALAPA'), ('22', 'JUTIAPA');

-- Creacion de tabla MUNICIPIO
CREATE TABLE municipio ( `id` INT NOT NULL AUTO_INCREMENT , `codigo` VARCHAR(2) NOT NULL , `nombre` VARCHAR(50) NOT NULL , `codigodepto` INT NOT NULL, 
							PRIMARY KEY (`id`),
							constraint fk_id_depto_muni foreign key (`codigodepto`) references `departamento` (`id`) on delete restrict on update restrict)

-- Insertando Municipios de Chiquimula
INSERT INTO `municipio` (`codigo`, `nombre`, `codigodepto`) 
	VALUES 	('01', 'CHIQUIMULA', '20'), ('02', 'SAN JOSE LA ARADA', '20'),
            ('03', 'SAN JUAN LA ERMITA', '20'), ('04', 'JOCOTAN', '20'),
            ('05', 'CAMOTAN', '20'), ('06', 'OLOPA', '20'),
            ('07', 'ESQUIPULAS', '20'), ('08', 'CONCEPCION LAS MINAS', '20'),
            ('09', 'QUEZALTEPEQUE', '20'), ('10', 'SAN JACINTO', '20'),
            ('11', 'IPALA ', '20');

-- Creacion de tabla DESARROLLADOR
CREATE TABLE desarrollador ( `codigo` INT NOT NULL AUTO_INCREMENT , `nombres` VARCHAR(50) NOT NULL , `apellidos` VARCHAR(50) NOT NULL , 
							`telefono` VARCHAR(15) NOT NULL , `direccion` VARCHAR(50) NOT NULL , `codigodepto` INT NOT NULL,
							`codigomuni` INT NOT NULL, `codigousuario` INT NOT NULL, PRIMARY KEY (`codigo`), `img` VARCHAR(250), `bio` TEXT(250),
							constraint fk_id_depto_dev foreign key (`codigodepto`) references `departamento` (`id`) on delete restrict on update restrict,
							constraint fk_id_muni_dev foreign key (`codigomuni`) references `municipio` (`id`) on delete restrict on update restrict,
							constraint fk_id_user_dev foreign key (`codigousuario`) references `usuario` (`codigo`) on delete restrict on update restrict)


-- Creacion de tabla Proyectos
CREATE TABLE proyecto ( `codigo` INT NOT NULL AUTO_INCREMENT , `nombre` VARCHAR(50) NOT NULL , `descripcion` TEXT(800) NOT NULL , 
							`url_video` VARCHAR(150), `fecha_crea` DATE NOT NULL, `img` VARCHAR(250),  PRIMARY KEY (`codigo`), `codigousuario` INT NOT NULL,
							constraint fk_id_dev_pro foreign key (`codigousuario`) references `usuario` (`codigo`) on delete restrict on update restrict)

-- Creacion de tabla Muchoas a Muchos Desarrollador_Proyuecto
CREATE TABLE desarrollador_proyecto ( `codigo` INT NOT NULL AUTO_INCREMENT , `fk_dev` INT NOT NULL , `fK_pro` INT NOT NULL ,PRIMARY KEY (`codigo`),
							constraint fk_dev foreign key (`fk_dev`) references `desarrollador` (`codigo`) on delete restrict on update restrict,
							constraint fK_pro foreign key (`fK_pro`) references `proyecto` (`codigo`) on delete restrict on update restrict)


	



