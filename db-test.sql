--
-- Name: conductor; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE conductor (
    id_conductor integer NOT NULL,
    nombre_conductor character varying(45) NOT NULL,
    apellido_conductor character varying(45) NOT NULL,
    cedula_conductor character varying(12) NOT NULL
);


--
-- Name: conductor_id_conductor_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE conductor_id_conductor_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: conductor_id_conductor_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE conductor_id_conductor_seq OWNED BY conductor.id_conductor;


--
-- Name: dispositivo; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE dispositivo (
    id_dispositivo integer NOT NULL,
    id_unidad integer,
    id_recorrido integer
);


--
-- Name: dispositivo_id_dispositivo_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE dispositivo_id_dispositivo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: dispositivo_id_dispositivo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE dispositivo_id_dispositivo_seq OWNED BY dispositivo.id_dispositivo;


--
-- Name: entrada; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE entrada (
    fecha_entrada date NOT NULL,
    hora_entrada time without time zone NOT NULL,
    id_salida integer NOT NULL,
    id_entrada integer NOT NULL
);


--
-- Name: entrada_id_entrada_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE entrada_id_entrada_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: entrada_id_entrada_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE entrada_id_entrada_seq OWNED BY entrada.id_entrada;


--
-- Name: entrada_incidencia; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE entrada_incidencia (
    id_entrada integer NOT NULL,
    id_incidencia integer NOT NULL,
    comentario_entrada_incidencia character varying(45)
);


--
-- Name: incidencia; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE incidencia (
    id_incidencia integer NOT NULL,
    descripcion_incidencia character varying(300) DEFAULT NULL::character varying,
    id_tipo_incidencia integer NOT NULL
);


--
-- Name: incidencia_id_incidencia_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE incidencia_id_incidencia_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: incidencia_id_incidencia_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE incidencia_id_incidencia_seq OWNED BY incidencia.id_incidencia;


--
-- Name: punto; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE punto (
    id_punto integer NOT NULL,
    latitud character varying(45) NOT NULL,
    longitud character varying(45) NOT NULL,
    fecha_punto date,
    hora_punto time without time zone,
    velocidad double precision,
    num_satelites integer
);


--
-- Name: punto_id_punto_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE punto_id_punto_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: punto_id_punto_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE punto_id_punto_seq OWNED BY punto.id_punto;


--
-- Name: punto_recorrido; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE punto_recorrido (
    id_punto integer NOT NULL,
    id_recorrido integer NOT NULL
);


--
-- Name: punto_salida; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE punto_salida (
    id_punto integer NOT NULL,
    id_salida integer NOT NULL
);


--
-- Name: recorrido; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE recorrido (
    nombre_recorrido character varying(45) NOT NULL,
    id_recorrido integer NOT NULL
);


--
-- Name: recorrido_id_recorrido_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE recorrido_id_recorrido_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: recorrido_id_recorrido_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE recorrido_id_recorrido_seq OWNED BY recorrido.id_recorrido;


--
-- Name: salida; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE salida (
    id_salida integer NOT NULL,
    id_conductor integer NOT NULL,
    id_recorrido integer NOT NULL,
    id_unidad integer NOT NULL,
    fecha_salida date NOT NULL,
    hora_salida time without time zone NOT NULL,
    id_acompaniante integer
);


--
-- Name: salida_id_salida_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE salida_id_salida_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: salida_id_salida_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE salida_id_salida_seq OWNED BY salida.id_salida;


--
-- Name: salida_incidencia; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE salida_incidencia (
    id_salida integer NOT NULL,
    id_incidencia integer NOT NULL,
    comentario_salida_incidencia character varying(45)
);


--
-- Name: tipo_incidencia; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE tipo_incidencia (
    id_tipo_incidencia integer NOT NULL,
    descripcion_tipo_incidencia character varying(45) NOT NULL
);


--
-- Name: tipo_incidencia_id_tipo_incidencia_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tipo_incidencia_id_tipo_incidencia_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tipo_incidencia_id_tipo_incidencia_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tipo_incidencia_id_tipo_incidencia_seq OWNED BY tipo_incidencia.id_tipo_incidencia;


--
-- Name: unidad; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE unidad (
    id_unidad integer NOT NULL,
    placa_unidad character varying(45) NOT NULL,
    modelo_unidad character varying(45) NOT NULL
);


--
-- Name: unidad_id_unidad_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE unidad_id_unidad_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: unidad_id_unidad_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE unidad_id_unidad_seq OWNED BY unidad.id_unidad;


--
-- Name: usuario; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE usuario (
    login_usuario character varying(24) NOT NULL,
    password_usuario character varying(255) NOT NULL,
    nivel_usuario integer DEFAULT 0 NOT NULL,
    nombre_usuario character varying(45) NOT NULL,
    apellido_usuario character varying(45) NOT NULL,
    id_usuario integer NOT NULL
);


--
-- Name: usuario_id_usuario_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE usuario_id_usuario_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: usuario_id_usuario_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE usuario_id_usuario_seq OWNED BY usuario.id_usuario;


--
-- Name: id_conductor; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY conductor ALTER COLUMN id_conductor SET DEFAULT nextval('conductor_id_conductor_seq'::regclass);


--
-- Name: id_dispositivo; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY dispositivo ALTER COLUMN id_dispositivo SET DEFAULT nextval('dispositivo_id_dispositivo_seq'::regclass);


--
-- Name: id_entrada; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY entrada ALTER COLUMN id_entrada SET DEFAULT nextval('entrada_id_entrada_seq'::regclass);


--
-- Name: id_incidencia; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY incidencia ALTER COLUMN id_incidencia SET DEFAULT nextval('incidencia_id_incidencia_seq'::regclass);


--
-- Name: id_punto; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY punto ALTER COLUMN id_punto SET DEFAULT nextval('punto_id_punto_seq'::regclass);


--
-- Name: id_recorrido; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY recorrido ALTER COLUMN id_recorrido SET DEFAULT nextval('recorrido_id_recorrido_seq'::regclass);


--
-- Name: id_salida; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY salida ALTER COLUMN id_salida SET DEFAULT nextval('salida_id_salida_seq'::regclass);


--
-- Name: id_tipo_incidencia; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tipo_incidencia ALTER COLUMN id_tipo_incidencia SET DEFAULT nextval('tipo_incidencia_id_tipo_incidencia_seq'::regclass);


--
-- Name: id_unidad; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY unidad ALTER COLUMN id_unidad SET DEFAULT nextval('unidad_id_unidad_seq'::regclass);


--
-- Name: id_usuario; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY usuario ALTER COLUMN id_usuario SET DEFAULT nextval('usuario_id_usuario_seq'::regclass);


--
-- Data for Name: usuario; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO usuario (login_usuario, password_usuario, nivel_usuario, nombre_usuario, apellido_usuario, id_usuario) VALUES ('administrador', '1234', 1, 'Administra', 'dor', 1);
INSERT INTO usuario (login_usuario, password_usuario, nivel_usuario, nombre_usuario, apellido_usuario, id_usuario) VALUES ('coordinador', '1234', 2, 'Coor', 'dinador', 2);
INSERT INTO usuario (login_usuario, password_usuario, nivel_usuario, nombre_usuario, apellido_usuario, id_usuario) VALUES ('secretario', '1234', 3, 'Secre', 'tario', 3);
INSERT INTO usuario (login_usuario, password_usuario, nivel_usuario, nombre_usuario, apellido_usuario, id_usuario) VALUES ('reportero', '1234', 4, 'Repor', 'Tero', 4);


--
-- Name: conductor_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY conductor
    ADD CONSTRAINT conductor_pkey PRIMARY KEY (id_conductor);


--
-- Name: dispositivo_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY dispositivo
    ADD CONSTRAINT dispositivo_pkey PRIMARY KEY (id_dispositivo);


--
-- Name: entrada_incidencia_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY entrada_incidencia
    ADD CONSTRAINT entrada_incidencia_pkey PRIMARY KEY (id_entrada, id_incidencia);


--
-- Name: entrada_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY entrada
    ADD CONSTRAINT entrada_pkey PRIMARY KEY (id_entrada);


--
-- Name: incidencia_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY incidencia
    ADD CONSTRAINT incidencia_pkey PRIMARY KEY (id_incidencia);


--
-- Name: punto_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY punto
    ADD CONSTRAINT punto_pkey PRIMARY KEY (id_punto);


--
-- Name: punto_recorrido_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY punto_recorrido
    ADD CONSTRAINT punto_recorrido_pkey PRIMARY KEY (id_punto, id_recorrido);


--
-- Name: punto_salida_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY punto_salida
    ADD CONSTRAINT punto_salida_pkey PRIMARY KEY (id_punto, id_salida);


--
-- Name: recorrido_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY recorrido
    ADD CONSTRAINT recorrido_pkey PRIMARY KEY (id_recorrido);


--
-- Name: salida_incidencia_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY salida_incidencia
    ADD CONSTRAINT salida_incidencia_pkey PRIMARY KEY (id_salida, id_incidencia);


--
-- Name: salida_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY salida
    ADD CONSTRAINT salida_pkey PRIMARY KEY (id_salida);


--
-- Name: tipo_incidencia_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tipo_incidencia
    ADD CONSTRAINT tipo_incidencia_pkey PRIMARY KEY (id_tipo_incidencia);


--
-- Name: unidad_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY unidad
    ADD CONSTRAINT unidad_pkey PRIMARY KEY (id_unidad);


--
-- Name: usuario_login_usuario_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT usuario_login_usuario_key UNIQUE (login_usuario);


--
-- Name: usuario_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT usuario_pkey PRIMARY KEY (id_usuario);


--
-- Name: dispositivo_ibfk_1; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY dispositivo
    ADD CONSTRAINT dispositivo_ibfk_1 FOREIGN KEY (id_unidad) REFERENCES unidad(id_unidad);


--
-- Name: dispositivo_ibfk_2; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY dispositivo
    ADD CONSTRAINT dispositivo_ibfk_2 FOREIGN KEY (id_recorrido) REFERENCES recorrido(id_recorrido);


--
-- Name: entrada_ibfk_1; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY entrada
    ADD CONSTRAINT entrada_ibfk_1 FOREIGN KEY (id_salida) REFERENCES salida(id_salida);


--
-- Name: fk_entrada_has_incidencia_entrada1; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY entrada_incidencia
    ADD CONSTRAINT fk_entrada_has_incidencia_entrada1 FOREIGN KEY (id_entrada) REFERENCES entrada(id_entrada);


--
-- Name: fk_entrada_has_incidencia_incidencia1; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY entrada_incidencia
    ADD CONSTRAINT fk_entrada_has_incidencia_incidencia1 FOREIGN KEY (id_incidencia) REFERENCES incidencia(id_incidencia);


--
-- Name: fk_incidencia_tipo_incidencia1; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY incidencia
    ADD CONSTRAINT fk_incidencia_tipo_incidencia1 FOREIGN KEY (id_tipo_incidencia) REFERENCES tipo_incidencia(id_tipo_incidencia);


--
-- Name: fk_salida_has_incidencia_incidencia1; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY salida_incidencia
    ADD CONSTRAINT fk_salida_has_incidencia_incidencia1 FOREIGN KEY (id_incidencia) REFERENCES incidencia(id_incidencia);


--
-- Name: fk_salida_has_incidencia_salida1; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY salida_incidencia
    ADD CONSTRAINT fk_salida_has_incidencia_salida1 FOREIGN KEY (id_salida) REFERENCES salida(id_salida);


--
-- Name: punto_recorrido_ibfk_1; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY punto_recorrido
    ADD CONSTRAINT punto_recorrido_ibfk_1 FOREIGN KEY (id_recorrido) REFERENCES recorrido(id_recorrido);


--
-- Name: punto_recorrido_ibfk_2; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY punto_recorrido
    ADD CONSTRAINT punto_recorrido_ibfk_2 FOREIGN KEY (id_punto) REFERENCES punto(id_punto);


--
-- Name: punto_salida_ibfk_1; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY punto_salida
    ADD CONSTRAINT punto_salida_ibfk_1 FOREIGN KEY (id_salida) REFERENCES salida(id_salida);


--
-- Name: punto_salida_ibfk_2; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY punto_salida
    ADD CONSTRAINT punto_salida_ibfk_2 FOREIGN KEY (id_punto) REFERENCES punto(id_punto);


--
-- Name: salida_ibfk_1; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY salida
    ADD CONSTRAINT salida_ibfk_1 FOREIGN KEY (id_recorrido) REFERENCES recorrido(id_recorrido);


--
-- Name: salida_ibfk_2; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY salida
    ADD CONSTRAINT salida_ibfk_2 FOREIGN KEY (id_conductor) REFERENCES conductor(id_conductor);


--
-- Name: salida_ibfk_3; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY salida
    ADD CONSTRAINT salida_ibfk_3 FOREIGN KEY (id_unidad) REFERENCES unidad(id_unidad);


--
-- Name: salida_ibfk_4; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY salida
    ADD CONSTRAINT salida_ibfk_4 FOREIGN KEY (id_acompaniante) REFERENCES conductor(id_conductor);


--
-- PostgreSQL database dump complete
--

