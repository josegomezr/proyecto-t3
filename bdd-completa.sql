-- -----------------------------------------------------
-- Schema proyecto
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table conductor
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS conductor (
  id_conductor SERIAL NOT NULL,
  nombre_conductor VARCHAR(45) NOT NULL,
  apellido_conductor VARCHAR(45) NOT NULL,
  cedula_conductor VARCHAR(12) NOT NULL,
  PRIMARY KEY (id_conductor));


-- -----------------------------------------------------
-- Table unidad
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS unidad (
  id_unidad SERIAL NOT NULL,
  placa_unidad VARCHAR(45) NOT NULL,
  modelo_unidad VARCHAR(45) NOT NULL,
  PRIMARY KEY (id_unidad));


-- -----------------------------------------------------
-- Table recorrido
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS recorrido (
  nombre_recorrido VARCHAR(45) NOT NULL,
  id_recorrido SERIAL NOT NULL,
  PRIMARY KEY (id_recorrido));


-- -----------------------------------------------------
-- Table dispositivo
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS dispositivo (
  id_dispositivo SERIAL NOT NULL,
  id_unidad INT NULL DEFAULT NULL,
  id_recorrido INT NULL DEFAULT NULL,
  PRIMARY KEY (id_dispositivo));

-- -----------------------------------------------------
-- Table salida
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS salida (
  id_salida SERIAL NOT NULL,
  id_conductor INT NOT NULL DEFAULT NULL,
  id_recorrido INT NOT NULL,
  id_unidad INT NOT NULL,
  fecha_salida DATE NOT NULL,
  hora_salida TIME NOT NULL,
  id_acompaniante INT NULL,
  PRIMARY KEY (id_salida));


-- -----------------------------------------------------
-- Table entrada
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS entrada (
  fecha_entrada DATE NOT NULL,
  hora_entrada TIME NOT NULL,
  id_salida INT NOT NULL,
  id_entrada SERIAL NOT NULL,
  PRIMARY KEY (id_entrada));


-- -----------------------------------------------------
-- Table tipo_incidencia
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS tipo_incidencia (
  id_tipo_incidencia INT NOT NULL,
  descripcion_incidencia VARCHAR(45) NOT NULL,
  PRIMARY KEY (id_tipo_incidencia));


-- -----------------------------------------------------
-- Table incidencia
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS incidencia (
  id_incidencia SERIAL NOT NULL,
  descripcion_incidencia VARCHAR(300) NULL DEFAULT NULL,
  id_tipo_incidencia INT NOT NULL,
  PRIMARY KEY (id_incidencia));


-- -----------------------------------------------------
-- Table punto
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS punto (
  id_punto SERIAL NOT NULL,
  latitud VARCHAR(45) NOT NULL,
  longitud VARCHAR(45) NOT NULL,
  fecha_punto DATE NULL DEFAULT NULL,
  hora_punto TIME NULL DEFAULT NULL,
  velocidad FLOAT NULL DEFAULT NULL,
  num_satelites INT NULL DEFAULT NULL,
  PRIMARY KEY (id_punto));


-- -----------------------------------------------------
-- Table punto_recorrido
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS punto_recorrido (
  id_punto INT NOT NULL,
  id_recorrido INT NOT NULL,
  PRIMARY KEY (id_punto, id_recorrido));


-- -----------------------------------------------------
-- Table punto_salida
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS punto_salida (
  id_punto INT NOT NULL,
  id_salida INT NOT NULL,
  PRIMARY KEY (id_punto, id_salida));


-- -----------------------------------------------------
-- Table usuario
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS usuario (
  login_usuario VARCHAR(24) NOT NULL,
  password_usuario VARCHAR(255) NOT NULL,
  nivel_usuario INT NOT NULL DEFAULT '0',
  nombre_usuario VARCHAR(45) NOT NULL,
  apellido_usuario VARCHAR(45) NOT NULL,
  id_usuario SERIAL NOT NULL,
  PRIMARY KEY (id_usuario),
  UNIQUE (login_usuario));


-- -----------------------------------------------------
-- Table entrada_incidencia
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS entrada_incidencia (
  id_entrada INT NOT NULL,
  id_incidencia INT NOT NULL,
  PRIMARY KEY (id_entrada, id_incidencia));


-- -----------------------------------------------------
-- Table salida_incidencia
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS salida_incidencia (
  id_salida INT NOT NULL,
  id_incidencia INT NOT NULL,
  PRIMARY KEY (id_salida, id_incidencia));


ALTER TABLE dispositivo ADD CONSTRAINT dispositivo_ibfk_1
    FOREIGN KEY (id_unidad)
    REFERENCES unidad (id_unidad);

ALTER TABLE dispositivo ADD CONSTRAINT dispositivo_ibfk_2
    FOREIGN KEY (id_recorrido)
    REFERENCES recorrido (id_recorrido);

ALTER TABLE salida ADD CONSTRAINT salida_ibfk_1
    FOREIGN KEY (id_recorrido)
    REFERENCES recorrido (id_recorrido);

ALTER TABLE salida ADD CONSTRAINT salida_ibfk_2
    FOREIGN KEY (id_conductor)
    REFERENCES conductor (id_conductor);

ALTER TABLE salida ADD CONSTRAINT salida_ibfk_3
    FOREIGN KEY (id_unidad)
    REFERENCES unidad (id_unidad);

ALTER TABLE salida ADD CONSTRAINT salida_ibfk_4
    FOREIGN KEY (id_acompaniante)
    REFERENCES conductor (id_conductor);

ALTER TABLE entrada ADD CONSTRAINT entrada_ibfk_1
    FOREIGN KEY (id_salida)
    REFERENCES salida (id_salida);

ALTER TABLE incidencia ADD CONSTRAINT fk_incidencia_tipo_incidencia1
    FOREIGN KEY (id_tipo_incidencia)
    REFERENCES tipo_incidencia (id_tipo_incidencia);

ALTER TABLE punto_recorrido ADD CONSTRAINT punto_recorrido_ibfk_1
    FOREIGN KEY (id_recorrido)
    REFERENCES recorrido (id_recorrido);

ALTER TABLE punto_recorrido ADD CONSTRAINT punto_recorrido_ibfk_2
    FOREIGN KEY (id_punto)
    REFERENCES punto (id_punto);

ALTER TABLE punto_salida ADD CONSTRAINT punto_salida_ibfk_1
    FOREIGN KEY (id_salida)
    REFERENCES salida (id_salida);

ALTER TABLE punto_salida ADD CONSTRAINT punto_salida_ibfk_2
    FOREIGN KEY (id_punto)
    REFERENCES punto (id_punto);

ALTER TABLE entrada_incidencia ADD CONSTRAINT fk_entrada_has_incidencia_entrada1
    FOREIGN KEY (id_entrada)
    REFERENCES entrada (id_entrada);

ALTER TABLE entrada_incidencia ADD CONSTRAINT fk_entrada_has_incidencia_incidencia1
    FOREIGN KEY (id_incidencia)
    REFERENCES incidencia (id_incidencia);

ALTER TABLE salida_incidencia ADD CONSTRAINT fk_salida_has_incidencia_salida1
    FOREIGN KEY (id_salida)
    REFERENCES salida (id_salida);

ALTER TABLE salida_incidencia ADD CONSTRAINT fk_salida_has_incidencia_incidencia1
    FOREIGN KEY (id_incidencia)
    REFERENCES incidencia (id_incidencia);

-- -----------------------------------------------------
-- Data for table tipo_incidencia
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO tipo_incidencia (id_tipo_incidencia, descripcion_incidencia) VALUES (1, 'Daños en la Carrocería');
INSERT INTO tipo_incidencia (id_tipo_incidencia, descripcion_incidencia) VALUES (2, 'Daños en los Vidrios');
INSERT INTO tipo_incidencia (id_tipo_incidencia, descripcion_incidencia) VALUES (3, 'Daños en el Motor');
INSERT INTO tipo_incidencia (id_tipo_incidencia, descripcion_incidencia) VALUES (4, 'Daños en los Neumáticos');


INSERT INTO incidencia (id_incidencia, descripcion_incidencia, id_tipo_incidencia) VALUES (1, 'Parabrisas Dañado', 2);
INSERT INTO incidencia (id_incidencia, descripcion_incidencia, id_tipo_incidencia) VALUES (2, 'No enciende', 3);
INSERT INTO incidencia (id_incidencia, descripcion_incidencia, id_tipo_incidencia) VALUES (3, 'Neumáticos desinflados', 4);
INSERT INTO incidencia (id_incidencia, descripcion_incidencia, id_tipo_incidencia) VALUES (4, 'Rayones en la Carroceria', 1);


INSERT INTO recorrido (nombre_recorrido, id_recorrido) VALUES ('Centro2', 1);
INSERT INTO conductor (id_conductor, cedula_conductor, nombre_conductor, apellido_conductor) VALUES (1, 'V-12345678', 'Luis', 'Martinez');
INSERT INTO conductor (id_conductor, cedula_conductor, nombre_conductor, apellido_conductor) VALUES (2, 'V-12345677', 'Alaneeeee', 'Brito');
INSERT INTO unidad (id_unidad, placa_unidad, modelo_unidad) VALUES (1, 'GEA 72C', 'Optra3');
INSERT INTO unidad (id_unidad, placa_unidad, modelo_unidad) VALUES (2, 'ABC DEF', 'dadsad');
INSERT INTO unidad (id_unidad, placa_unidad, modelo_unidad) VALUES (3, 'DEF 123', 'DPKASndai');
INSERT INTO dispositivo (id_dispositivo, id_unidad, id_recorrido) VALUES (430, 1, 1);
INSERT INTO salida (id_conductor, id_recorrido, id_unidad, fecha_salida, hora_salida, id_salida, id_acompaniante) VALUES (1, 1, 1, '2016-05-12', '23:27:00', 1, NULL);
INSERT INTO entrada (fecha_entrada, hora_entrada, id_salida, id_entrada) VALUES ('2016-05-12', '23:29:00', 1, 1);
INSERT INTO punto (id_punto, latitud, longitud, fecha_punto, hora_punto, velocidad, num_satelites) VALUES (1, '10.437676', '-64.141064', NULL, NULL, NULL, NULL);
INSERT INTO punto (id_punto, latitud, longitud, fecha_punto, hora_punto, velocidad, num_satelites) VALUES (2, '10.438837', '-64.142244', NULL, NULL, NULL, NULL);
INSERT INTO punto (id_punto, latitud, longitud, fecha_punto, hora_punto, velocidad, num_satelites) VALUES (3, '10.438098', '-64.142931', NULL, NULL, NULL, NULL);
INSERT INTO punto (id_punto, latitud, longitud, fecha_punto, hora_punto, velocidad, num_satelites) VALUES (4, '10.439111', '-64.144261', NULL, NULL, NULL, NULL);
INSERT INTO punto (id_punto, latitud, longitud, fecha_punto, hora_punto, velocidad, num_satelites) VALUES (5, '10.445357', '-64.151257', NULL, NULL, NULL, NULL);
INSERT INTO punto (id_punto, latitud, longitud, fecha_punto, hora_punto, velocidad, num_satelites) VALUES (6, '10.449356', '-64.156149', NULL, NULL, NULL, NULL);
INSERT INTO punto (id_punto, latitud, longitud, fecha_punto, hora_punto, velocidad, num_satelites) VALUES (7, '10.450823', '-64.158874', NULL, NULL, NULL, NULL);
INSERT INTO punto (id_punto, latitud, longitud, fecha_punto, hora_punto, velocidad, num_satelites) VALUES (8, '10.453123', '-64.160945', NULL, NULL, NULL, NULL);
INSERT INTO punto (id_punto, latitud, longitud, fecha_punto, hora_punto, velocidad, num_satelites) VALUES (9, '10.455085', '-64.163101', NULL, NULL, NULL, NULL);
INSERT INTO punto (id_punto, latitud, longitud, fecha_punto, hora_punto, velocidad, num_satelites) VALUES (10, '10.455666', '-64.166116', NULL, NULL, NULL, NULL);
INSERT INTO punto (id_punto, latitud, longitud, fecha_punto, hora_punto, velocidad, num_satelites) VALUES (11, '10.456457', '-64.170783', NULL, NULL, NULL, NULL);
INSERT INTO punto (id_punto, latitud, longitud, fecha_punto, hora_punto, velocidad, num_satelites) VALUES (12, '10.456847', '-64.171191', NULL, NULL, NULL, NULL);
INSERT INTO punto (id_punto, latitud, longitud, fecha_punto, hora_punto, velocidad, num_satelites) VALUES (13, '10.457027', '-64.17162', NULL, NULL, NULL, NULL);
INSERT INTO punto (id_punto, latitud, longitud, fecha_punto, hora_punto, velocidad, num_satelites) VALUES (14, '10.456626', '-64.171899', NULL, NULL, NULL, NULL);
INSERT INTO punto (id_punto, latitud, longitud, fecha_punto, hora_punto, velocidad, num_satelites) VALUES (15, '10.457301', '-64.172897', NULL, NULL, NULL, NULL);
INSERT INTO punto (id_punto, latitud, longitud, fecha_punto, hora_punto, velocidad, num_satelites) VALUES (16, '10.458314', '-64.173766', NULL, NULL, NULL, NULL);
INSERT INTO punto (id_punto, latitud, longitud, fecha_punto, hora_punto, velocidad, num_satelites) VALUES (17, '10.458884', '-64.173744', NULL, NULL, NULL, NULL);
INSERT INTO punto (id_punto, latitud, longitud, fecha_punto, hora_punto, velocidad, num_satelites) VALUES (18, '10.459538', '-64.174109', NULL, NULL, NULL, NULL);
INSERT INTO punto (id_punto, latitud, longitud, fecha_punto, hora_punto, velocidad, num_satelites) VALUES (19, '10.459401', '-64.174485', NULL, NULL, NULL, NULL);
INSERT INTO punto (id_punto, latitud, longitud, fecha_punto, hora_punto, velocidad, num_satelites) VALUES (20, '10.458884', '-64.174345', NULL, NULL, NULL, NULL);
INSERT INTO punto_recorrido (id_punto, id_recorrido) VALUES (1, 1);
INSERT INTO punto_recorrido (id_punto, id_recorrido) VALUES (2, 1);
INSERT INTO punto_recorrido (id_punto, id_recorrido) VALUES (3, 1);
INSERT INTO punto_recorrido (id_punto, id_recorrido) VALUES (4, 1);
INSERT INTO punto_recorrido (id_punto, id_recorrido) VALUES (5, 1);
INSERT INTO punto_recorrido (id_punto, id_recorrido) VALUES (6, 1);
INSERT INTO punto_recorrido (id_punto, id_recorrido) VALUES (7, 1);
INSERT INTO punto_recorrido (id_punto, id_recorrido) VALUES (8, 1);
INSERT INTO punto_recorrido (id_punto, id_recorrido) VALUES (9, 1);
INSERT INTO punto_recorrido (id_punto, id_recorrido) VALUES (10, 1);
INSERT INTO punto_recorrido (id_punto, id_recorrido) VALUES (11, 1);
INSERT INTO punto_recorrido (id_punto, id_recorrido) VALUES (12, 1);
INSERT INTO punto_recorrido (id_punto, id_recorrido) VALUES (13, 1);
INSERT INTO punto_recorrido (id_punto, id_recorrido) VALUES (14, 1);
INSERT INTO punto_recorrido (id_punto, id_recorrido) VALUES (15, 1);
INSERT INTO punto_recorrido (id_punto, id_recorrido) VALUES (16, 1);
INSERT INTO punto_recorrido (id_punto, id_recorrido) VALUES (17, 1);
INSERT INTO punto_recorrido (id_punto, id_recorrido) VALUES (18, 1);
INSERT INTO punto_recorrido (id_punto, id_recorrido) VALUES (19, 1);
INSERT INTO punto_recorrido (id_punto, id_recorrido) VALUES (20, 1);
INSERT INTO usuario (login_usuario, password_usuario, nivel_usuario, nombre_usuario, apellido_usuario, id_usuario) VALUES ('administrador', '1234', 1, 'Administra', 'dor', 1);
INSERT INTO usuario (login_usuario, password_usuario, nivel_usuario, nombre_usuario, apellido_usuario, id_usuario) VALUES ('coordinador', '1234', 2, 'Coor', 'dinador', 2);
INSERT INTO usuario (login_usuario, password_usuario, nivel_usuario, nombre_usuario, apellido_usuario, id_usuario) VALUES ('secretario', '1234', 3, 'Secre', 'tario', 3);
INSERT INTO usuario (login_usuario, password_usuario, nivel_usuario, nombre_usuario, apellido_usuario, id_usuario) VALUES ('reportero', '1234', 4, 'Repor', 'Tero', 4);

COMMIT;


