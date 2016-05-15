
DROP TABLE IF EXISTS conductor;
CREATE TABLE conductor (
    cedula_conductor VARCHAR(12) NOT NULL,
    nombre_conductor VARCHAR(45) NOT NULL,
    apellido_conductor VARCHAR(45) NOT NULL,
    PRIMARY KEY (cedula_conductor)
);

DROP TABLE IF EXISTS dispositivo;
CREATE TABLE dispositivo (
    id_dispositivo serial not null,
    id_unidad int,
    id_recorrido INT,
    PRIMARY KEY (id_dispositivo)
);

DROP TABLE IF EXISTS entrada;
CREATE TABLE entrada (
    fecha_entrada date NOT NULL,
    hora_entrada time NOT NULL,
    id_salida INT NOT NULL,
    id_incidencia INT NULL,
    id_entrada serial not null,
    PRIMARY KEY (id_entrada)
);

DROP TABLE IF EXISTS salida;
CREATE TABLE salida (
    cedula_conductor VARCHAR(12),
    id_recorrido INT NOT NULL,
    id_unidad INT NOT NULL,
    fecha_salida date NOT NULL,
    hora_salida time NOT NULL,
    id_salida serial not null,
    id_incidencia INT NULL,
    cedula_acompaniante VARCHAR(12),
    PRIMARY KEY (id_salida)
);

DROP TABLE IF EXISTS incidencia;
CREATE TABLE incidencia (
    id_incidencia serial not null,
    descripcion_incidencia varchar(300),
    PRIMARY KEY (id_incidencia)
);


DROP TABLE IF EXISTS punto_salida;
CREATE TABLE punto_salida (
    id_punto int not null,
    id_salida int not null,
    PRIMARY KEY (id_punto, id_salida)
);

DROP TABLE IF EXISTS punto_recorrido;
CREATE TABLE punto_recorrido (
    id_punto int not null,
    id_recorrido int not null,
    PRIMARY KEY (id_punto, id_recorrido)
);

DROP TABLE IF EXISTS punto;
CREATE TABLE punto (
    id_punto serial not null,
    latitud VARCHAR(45) NOT NULL,
    longitud VARCHAR(45) NOT NULL,
    fecha_punto date,
    hora_punto time,
    velocidad double precision,
    num_satelites INT,
    PRIMARY KEY (id_punto)
);



DROP TABLE IF EXISTS recorrido;
CREATE TABLE recorrido (
    nombre_recorrido VARCHAR(45) NOT NULL,
    id_recorrido serial not null,
    PRIMARY KEY (id_recorrido),
    UNIQUE (nombre_recorrido)
);

DROP TABLE IF EXISTS unidad;
CREATE TABLE unidad (
    id_unidad serial not null,
    placa_unidad VARCHAR(45) NOT NULL,
    modelo_unidad VARCHAR(45) NOT NULL,
    PRIMARY KEY (id_unidad)
);

DROP TABLE IF EXISTS usuario;
CREATE TABLE usuario (
    login_usuario VARCHAR(24) NOT NULL,
    password_usuario VARCHAR(255) NOT NULL,
    nivel_usuario INT DEFAULT 0 NOT NULL,
    nombre_usuario varchar(45) not null,
    apellido_usuario varchar(45) not null,
    id_usuario serial not null,
    UNIQUE (login_usuario),
    PRIMARY KEY (id_usuario)
);


ALTER TABLE salida ADD FOREIGN KEY (id_recorrido) REFERENCES recorrido(id_recorrido);
ALTER TABLE salida ADD FOREIGN KEY (cedula_conductor) REFERENCES conductor(cedula_conductor);
ALTER TABLE salida ADD FOREIGN KEY (id_unidad) REFERENCES unidad(id_unidad);
ALTER TABLE dispositivo ADD FOREIGN KEY (id_unidad) REFERENCES unidad(id_unidad);
ALTER TABLE entrada ADD FOREIGN KEY (id_salida) REFERENCES salida(id_salida);
ALTER TABLE dispositivo ADD FOREIGN KEY (id_recorrido) REFERENCES recorrido(id_recorrido);
ALTER TABLE salida ADD FOREIGN KEY (cedula_acompaniante) REFERENCES conductor(cedula_conductor);

ALTER TABLE salida ADD FOREIGN KEY (id_incidencia) REFERENCES incidencia(id_incidencia);
ALTER TABLE entrada ADD FOREIGN KEY (id_incidencia) REFERENCES incidencia(id_incidencia);

ALTER TABLE punto_salida ADD FOREIGN KEY (id_salida) REFERENCES salida(id_salida);
ALTER TABLE punto_recorrido ADD FOREIGN KEY (id_recorrido) REFERENCES recorrido(id_recorrido);

ALTER TABLE punto_salida ADD FOREIGN KEY (id_punto) REFERENCES punto(id_punto);
ALTER TABLE punto_recorrido ADD FOREIGN KEY (id_punto) REFERENCES punto(id_punto);