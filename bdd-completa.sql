CREATE TABLE chofer (
    cedula_chofer character varying(12) NOT NULL,
    nombre_chofer character varying(45) NOT NULL,
    apellido_chofer character varying(45) NOT NULL,
    PRIMARY KEY (cedula_chofer)
);

CREATE TABLE ci_sessions (
    session_id character varying(40) DEFAULT '0',
    ip_address character varying(45) DEFAULT '0',
    user_agent character varying(120) NOT NULL,
    last_activity integer DEFAULT 0,
    user_data text NOT NULL,
    PRIMARY KEY (session_id)
);

CREATE TABLE dispositivo (
    id_dispositivo serial NOT NULL,
    placa_unidad character varying(45),
    id_recorrido integer,
    PRIMARY KEY (id_dispositivo)
);

CREATE TABLE entrada (
    fecha_entrada date NOT NULL,
    hora_entrada time without time zone NOT NULL,
    id_salida integer NOT NULL,
    id_entrada serial NOT NULL,
    observacion_entrada character varying(200),
    PRIMARY KEY (id_entrada)
);

CREATE TABLE punto_salida (
    id_punto_salida integer NOT NULL,
    latitud character varying(45) NOT NULL,
    longitud character varying(45) NOT NULL,
    fecha_punto date,
    hora_punto time without time zone,
    velocidad double precision,
    id_salida integer,
    num_satelites integer,
    PRIMARY KEY (id_punto_salida)
);

CREATE TABLE punto_recorrido (
    id_punto_recorrido serial NOT NULL,
    latitud character varying(45) NOT NULL,
    longitud character varying(45) NOT NULL,
    id_recorrido integer,
    PRIMARY KEY (id_punto_recorrido)
);

CREATE TABLE recorrido (
    nombre_recorrido character varying(45) NOT NULL,
    id_recorrido serial NOT NULL,
    PRIMARY KEY (id_recorrido),
    UNIQUE (nombre_recorrido)
);

CREATE TABLE salida (
    cedula_chofer character varying(12),
    id_recorrido integer NOT NULL,
    placa_unidad character varying(8) NOT NULL,
    fecha_salida date NOT NULL,
    hora_salida time without time zone NOT NULL,
    id_salida serial NOT NULL,
    observacion_salida character varying(200),
    cedula_acompaniante character varying(12),
    PRIMARY KEY (id_salida)
);

CREATE TABLE unidad (
    placa_unidad character varying(45) NOT NULL,
    modelo_unidad character varying(45) NOT NULL,
    PRIMARY KEY (placa_unidad)
);

CREATE TABLE usuario (
    login_usuario character varying(24) NOT NULL,
    password_usuario character varying(255) NOT NULL,
    nivel_usuario integer DEFAULT 0 NOT NULL,
    nombre_usuario varchar(45) not null,
    apellido_usuario varchar(45) not null,
    id_usuario serial NOT NULL,
    UNIQUE (login_usuario),
    PRIMARY KEY (id_usuario)
);

ALTER TABLE salida ADD FOREIGN KEY (id_recorrido) REFERENCES recorrido(id_recorrido);
ALTER TABLE salida ADD FOREIGN KEY (cedula_chofer) REFERENCES chofer(cedula_chofer);
ALTER TABLE salida ADD FOREIGN KEY (placa_unidad) REFERENCES unidad(placa_unidad);
ALTER TABLE dispositivo ADD FOREIGN KEY (placa_unidad) REFERENCES unidad(placa_unidad);
ALTER TABLE entrada ADD FOREIGN KEY (id_salida) REFERENCES salida(id_salida);
ALTER TABLE dispositivo ADD FOREIGN KEY (id_recorrido) REFERENCES recorrido(id_recorrido);
ALTER TABLE punto_salida ADD FOREIGN KEY (id_salida) REFERENCES salida(id_salida);
ALTER TABLE punto_recorrido ADD FOREIGN KEY (id_recorrido) REFERENCES recorrido(id_recorrido);
ALTER TABLE salida ADD FOREIGN KEY (cedula_acompaniante) REFERENCES chofer(cedula_chofer);