--
-- PostgreSQL database dump
--

-- Dumped from database version 15.4 (Ubuntu 15.4-1.pgdg22.04+1)
-- Dumped by pg_dump version 15.4 (Ubuntu 15.4-1.pgdg22.04+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: adjudicacion_directas; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.adjudicacion_directas (
    id bigint NOT NULL,
    articulo character varying(20) NOT NULL,
    fraccion character varying(50),
    fecha_sesion date,
    numero_sesion integer,
    numero_cotizacion integer,
    archivo_aprobacion_original character varying(150),
    archivo_aprobacion_publica character varying(150),
    numero_proveedores_adjudicado integer DEFAULT 0,
    proveedores_adjudicado json,
    expediente_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.adjudicacion_directas OWNER TO david;

--
-- Name: adjudicacion_directas_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.adjudicacion_directas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.adjudicacion_directas_id_seq OWNER TO david;

--
-- Name: adjudicacion_directas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.adjudicacion_directas_id_seq OWNED BY public.adjudicacion_directas.id;


--
-- Name: anexos_adjudicacions; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.anexos_adjudicacions (
    id bigint NOT NULL,
    nombre character varying(50) NOT NULL,
    archivo_original character varying(150) NOT NULL,
    archivo_publica character varying(150) NOT NULL,
    adjudicacion_directa_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.anexos_adjudicacions OWNER TO david;

--
-- Name: anexos_adjudicacions_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.anexos_adjudicacions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.anexos_adjudicacions_id_seq OWNER TO david;

--
-- Name: anexos_adjudicacions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.anexos_adjudicacions_id_seq OWNED BY public.anexos_adjudicacions.id;


--
-- Name: anexos_contratos_marcos; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.anexos_contratos_marcos (
    id bigint NOT NULL,
    contrato_marco_id integer NOT NULL,
    nombre_documento character varying(150) NOT NULL,
    archivo_original character varying(150) NOT NULL,
    archivo_publico character varying(150) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.anexos_contratos_marcos OWNER TO david;

--
-- Name: anexos_contratos_marcos_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.anexos_contratos_marcos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.anexos_contratos_marcos_id_seq OWNER TO david;

--
-- Name: anexos_contratos_marcos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.anexos_contratos_marcos_id_seq OWNED BY public.anexos_contratos_marcos.id;


--
-- Name: anexos_publicas; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.anexos_publicas (
    id bigint NOT NULL,
    nombre character varying(50) NOT NULL,
    archivo_original character varying(150) NOT NULL,
    archivo_publica character varying(150) NOT NULL,
    licitacion_publica_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.anexos_publicas OWNER TO david;

--
-- Name: anexos_publicas_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.anexos_publicas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.anexos_publicas_id_seq OWNER TO david;

--
-- Name: anexos_publicas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.anexos_publicas_id_seq OWNED BY public.anexos_publicas.id;


--
-- Name: anexos_restringidas; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.anexos_restringidas (
    id bigint NOT NULL,
    nombre character varying(50) NOT NULL,
    archivo_original character varying(150) NOT NULL,
    archivo_publica character varying(150) NOT NULL,
    invitacion_restringida_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.anexos_restringidas OWNER TO david;

--
-- Name: anexos_restringidas_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.anexos_restringidas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.anexos_restringidas_id_seq OWNER TO david;

--
-- Name: anexos_restringidas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.anexos_restringidas_id_seq OWNED BY public.anexos_restringidas.id;


--
-- Name: bien_servicios; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.bien_servicios (
    id bigint NOT NULL,
    cabms character varying(20) NOT NULL,
    especificacion text NOT NULL,
    unidad_medida character varying(30) NOT NULL,
    cantidad integer NOT NULL,
    cotizado boolean DEFAULT false NOT NULL,
    precio_maximo double precision DEFAULT '0'::double precision NOT NULL,
    requisicion_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.bien_servicios OWNER TO david;

--
-- Name: bien_servicios_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.bien_servicios_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.bien_servicios_id_seq OWNER TO david;

--
-- Name: bien_servicios_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.bien_servicios_id_seq OWNED BY public.bien_servicios.id;


--
-- Name: cancelar_compras; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.cancelar_compras (
    id bigint NOT NULL,
    cancelacion character varying(20) NOT NULL,
    motivo character varying(50) NOT NULL,
    descripcion text NOT NULL,
    urg_id integer NOT NULL,
    orden_compra_id integer NOT NULL,
    usuario_id integer NOT NULL,
    proveedor_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.cancelar_compras OWNER TO david;

--
-- Name: cancelar_compras_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.cancelar_compras_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cancelar_compras_id_seq OWNER TO david;

--
-- Name: cancelar_compras_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.cancelar_compras_id_seq OWNED BY public.cancelar_compras.id;


--
-- Name: carritos_compras; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.carritos_compras (
    id bigint NOT NULL,
    requisicion_id bigint NOT NULL,
    proveedor_ficha_producto_id bigint NOT NULL,
    cantidad_producto integer DEFAULT 0 NOT NULL,
    color character varying(100) NOT NULL,
    comprado integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.carritos_compras OWNER TO david;

--
-- Name: carritos_compras_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.carritos_compras_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.carritos_compras_id_seq OWNER TO david;

--
-- Name: carritos_compras_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.carritos_compras_id_seq OWNED BY public.carritos_compras.id;


--
-- Name: cat_productos; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.cat_productos (
    id bigint NOT NULL,
    numero_ficha character varying(150) NOT NULL,
    version double precision NOT NULL,
    capitulo character varying(100) NOT NULL,
    partida character varying(300) NOT NULL,
    cabms character varying(20) NOT NULL,
    descripcion character varying(300) NOT NULL,
    nombre_corto character varying(50) NOT NULL,
    especificaciones text NOT NULL,
    medida character varying(30) NOT NULL,
    validacion_tecnica boolean DEFAULT false,
    tipo_prueba character varying(50),
    archivo_ficha_tecnica character varying(150) NOT NULL,
    estatus boolean DEFAULT true NOT NULL,
    habilitado boolean DEFAULT false NOT NULL,
    contrato_marco_id integer NOT NULL,
    validacion_id integer,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.cat_productos OWNER TO david;

--
-- Name: cat_productos_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.cat_productos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cat_productos_id_seq OWNER TO david;

--
-- Name: cat_productos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.cat_productos_id_seq OWNED BY public.cat_productos.id;


--
-- Name: contratos; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.contratos (
    id bigint NOT NULL,
    fecha_inicio date,
    fecha_fin date,
    nombre_proveedor character varying(100),
    rfc_proveedor character varying(15),
    representante_proveedor character varying(150),
    domicilio_proveedor character varying(250),
    telefono_proveedor character varying(10),
    correo_proveedor character varying(150),
    fecha_entrega date,
    ccg character varying(10),
    responsable_almacen character varying(150),
    direccion_almacen character varying(250),
    telefono_almacen character varying(50),
    razon_social character varying(100),
    rfc_fiscal character varying(15),
    domicilio_fiscal character varying(100),
    metodo_pago character varying(50),
    forma_pago character varying(50),
    uso_cfdi character varying(100),
    estatus boolean DEFAULT false NOT NULL,
    urg_id integer NOT NULL,
    orden_compra_id integer NOT NULL,
    proveedor_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.contratos OWNER TO david;

--
-- Name: contratos_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.contratos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.contratos_id_seq OWNER TO david;

--
-- Name: contratos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.contratos_id_seq OWNED BY public.contratos.id;


--
-- Name: contratos_marcos; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.contratos_marcos (
    id bigint NOT NULL,
    numero_cm character varying(150) NOT NULL,
    nombre_cm character varying(150) NOT NULL,
    imagen character varying(150),
    objetivo text NOT NULL,
    f_inicio date NOT NULL,
    f_fin date NOT NULL,
    capitulo_partida json NOT NULL,
    compras_verdes boolean NOT NULL,
    validacion_tecnica boolean NOT NULL,
    validaciones_seleccionadas json NOT NULL,
    sector json NOT NULL,
    liberado boolean DEFAULT false NOT NULL,
    porcentaje integer DEFAULT 0 NOT NULL,
    eliminado boolean DEFAULT false NOT NULL,
    user_id_responsable integer NOT NULL,
    urg_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.contratos_marcos OWNER TO david;

--
-- Name: contratos_marcos_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.contratos_marcos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.contratos_marcos_id_seq OWNER TO david;

--
-- Name: contratos_marcos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.contratos_marcos_id_seq OWNED BY public.contratos_marcos.id;


--
-- Name: contratos_marcos_urgs; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.contratos_marcos_urgs (
    id bigint NOT NULL,
    urg_id bigint NOT NULL,
    contrato_marco_id bigint NOT NULL,
    fecha_firma date NOT NULL,
    a_terminos_especificos character varying(250) NOT NULL,
    estatus boolean NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.contratos_marcos_urgs OWNER TO david;

--
-- Name: contratos_marcos_urgs_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.contratos_marcos_urgs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.contratos_marcos_urgs_id_seq OWNER TO david;

--
-- Name: contratos_marcos_urgs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.contratos_marcos_urgs_id_seq OWNED BY public.contratos_marcos_urgs.id;


--
-- Name: expedientes_contratos_marcos; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.expedientes_contratos_marcos (
    id bigint NOT NULL,
    f_creacion date NOT NULL,
    metodo character varying(50) NOT NULL,
    num_procedimiento character varying(50) NOT NULL,
    imagen character varying(150),
    liberado boolean DEFAULT false NOT NULL,
    porcentaje integer DEFAULT 0 NOT NULL,
    contrato_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.expedientes_contratos_marcos OWNER TO david;

--
-- Name: expedientes_contratos_marcos_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.expedientes_contratos_marcos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.expedientes_contratos_marcos_id_seq OWNER TO david;

--
-- Name: expedientes_contratos_marcos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.expedientes_contratos_marcos_id_seq OWNED BY public.expedientes_contratos_marcos.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO david;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.failed_jobs_id_seq OWNER TO david;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: grupo_revisors; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.grupo_revisors (
    id bigint NOT NULL,
    convocatoria character varying(10) NOT NULL,
    emite character varying(100) NOT NULL,
    objeto text NOT NULL,
    motivo text NOT NULL,
    numero_oficio character varying(20) NOT NULL,
    archivo_invitacion character varying(150) NOT NULL,
    archivo_ficha_tecnica character varying(150) NOT NULL,
    fecha_mesa date,
    lugar character varying(150),
    comentarios text,
    numero_asistieron integer DEFAULT 0 NOT NULL,
    asistieron json,
    observaciones text,
    archivo_minuta character varying(150) NOT NULL,
    contrato_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.grupo_revisors OWNER TO david;

--
-- Name: grupo_revisors_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.grupo_revisors_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.grupo_revisors_id_seq OWNER TO david;

--
-- Name: grupo_revisors_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.grupo_revisors_id_seq OWNED BY public.grupo_revisors.id;


--
-- Name: habilitar_productos; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.habilitar_productos (
    id bigint NOT NULL,
    precio_maximo double precision,
    fecha_estudio date,
    archivo_estudio_original character varying(150),
    archivo_estudio_publico character varying(150),
    fecha_formulario date,
    fecha_carga date,
    fecha_administrativa date,
    fecha_tecnica date,
    fecha_publicacion date,
    cat_producto_id integer NOT NULL,
    grupo_revisor_id integer,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.habilitar_productos OWNER TO david;

--
-- Name: habilitar_productos_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.habilitar_productos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.habilitar_productos_id_seq OWNER TO david;

--
-- Name: habilitar_productos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.habilitar_productos_id_seq OWNED BY public.habilitar_productos.id;


--
-- Name: habilitar_proveedores; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.habilitar_proveedores (
    id bigint NOT NULL,
    fecha_adhesion date,
    archivo_adhesion character varying(150),
    habilitado boolean,
    proveedor_id integer NOT NULL,
    expediente_id integer NOT NULL,
    contrato_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.habilitar_proveedores OWNER TO david;

--
-- Name: habilitar_proveedores_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.habilitar_proveedores_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.habilitar_proveedores_id_seq OWNER TO david;

--
-- Name: habilitar_proveedores_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.habilitar_proveedores_id_seq OWNED BY public.habilitar_proveedores.id;


--
-- Name: incidencia_urgs; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.incidencia_urgs (
    id bigint NOT NULL,
    motivo character varying(100) NOT NULL,
    descripcion text NOT NULL,
    etapa integer NOT NULL,
    urg_id integer NOT NULL,
    orden_compra_id integer NOT NULL,
    proveedor_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.incidencia_urgs OWNER TO david;

--
-- Name: incidencia_urgs_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.incidencia_urgs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.incidencia_urgs_id_seq OWNER TO david;

--
-- Name: incidencia_urgs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.incidencia_urgs_id_seq OWNED BY public.incidencia_urgs.id;


--
-- Name: invitacion_restringidas; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.invitacion_restringidas (
    id bigint NOT NULL,
    articulo character varying(20) NOT NULL,
    fraccion character varying(50),
    fecha_sesion date,
    numero_sesion integer,
    numero_cotizacion integer NOT NULL,
    numero_proveedores_invitados integer DEFAULT 0,
    proveedores_invitados json,
    archivo_aprobacion_original character varying(150),
    archivo_aprobacion_publica character varying(150),
    numero_proveedores_participaron integer DEFAULT 0,
    proveedores_participaron json,
    archivo_aclaracion_original character varying(150),
    archivo_aclaracion_publica character varying(150),
    numero_proveedores_propuesta integer DEFAULT 0,
    proveedores_propuesta json,
    numero_proveedores_descalificados integer DEFAULT 0,
    proveedores_descalificados json,
    archivo_presentacion_original character varying(150),
    archivo_presentacion_publico character varying(150),
    numero_proveedores_aprobados integer DEFAULT 0,
    proveedores_aprobados json,
    numero_proveedores_adjudicados integer DEFAULT 0,
    proveedores_adjudicados json,
    expediente_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.invitacion_restringidas OWNER TO david;

--
-- Name: invitacion_restringidas_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.invitacion_restringidas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.invitacion_restringidas_id_seq OWNER TO david;

--
-- Name: invitacion_restringidas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.invitacion_restringidas_id_seq OWNED BY public.invitacion_restringidas.id;


--
-- Name: licitacion_publicas; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.licitacion_publicas (
    id bigint NOT NULL,
    tiangis boolean NOT NULL,
    tipo_licitacion character varying(50) NOT NULL,
    tipo_contratacion character varying(50) NOT NULL,
    fecha_convocatoria date NOT NULL,
    numero_proveedores_base integer DEFAULT 0,
    proveedores_base json,
    archivo_base_licitacion character varying(150),
    fecha_aclaracion date,
    archivo_acta_declaracion_original character varying(150),
    archivo_acta_declaracion_publico character varying(150),
    fecha_propuesta date,
    numero_proveedores_propuesta integer DEFAULT 0,
    proveedores_propuesta json,
    numero_proveedores_descalificados integer DEFAULT 0,
    proveedores_descalificados json,
    archivo_acta_presentacion_original character varying(150),
    archivo_acta_presentacion_publico character varying(150),
    fecha_fallo date,
    numero_proveedores_aprobados integer DEFAULT 0,
    proveedores_aprobados json,
    numero_proveedores_adjudicados integer DEFAULT 0,
    proveedores_adjudicados json,
    archivo_acta_fallo_original character varying(150),
    archivo_acta_fallo_publica character varying(150),
    archivo_oficio_adjudicacion_original character varying(150),
    archivo_oficio_adjudicacion_publico character varying(150),
    expediente_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.licitacion_publicas OWNER TO david;

--
-- Name: licitacion_publicas_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.licitacion_publicas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.licitacion_publicas_id_seq OWNER TO david;

--
-- Name: licitacion_publicas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.licitacion_publicas_id_seq OWNED BY public.licitacion_publicas.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO david;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.migrations_id_seq OWNER TO david;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: orden_compra_biens; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.orden_compra_biens (
    id bigint NOT NULL,
    cabms character varying(20) NOT NULL,
    nombre character varying(200) NOT NULL,
    cantidad integer NOT NULL,
    precio double precision NOT NULL,
    medida character varying(30) NOT NULL,
    color character varying(30) NOT NULL,
    tamanio character varying(100) NOT NULL,
    estatus integer,
    proveedor_ficha_producto_id integer NOT NULL,
    proveedor_id integer NOT NULL,
    urg_id integer NOT NULL,
    orden_compra_id integer NOT NULL,
    requisicion_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.orden_compra_biens OWNER TO david;

--
-- Name: orden_compra_biens_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.orden_compra_biens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.orden_compra_biens_id_seq OWNER TO david;

--
-- Name: orden_compra_biens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.orden_compra_biens_id_seq OWNED BY public.orden_compra_biens.id;


--
-- Name: orden_compra_envios; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.orden_compra_envios (
    id bigint NOT NULL,
    fecha_envio date NOT NULL,
    comentarios text NOT NULL,
    fecha_entrega_almacen date,
    nota_remision character varying(150),
    fecha_entrega_aceptada date,
    estatus boolean,
    orden_compra_id integer NOT NULL,
    proveedor_id integer NOT NULL,
    urg_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.orden_compra_envios OWNER TO david;

--
-- Name: orden_compra_envios_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.orden_compra_envios_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.orden_compra_envios_id_seq OWNER TO david;

--
-- Name: orden_compra_envios_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.orden_compra_envios_id_seq OWNED BY public.orden_compra_envios.id;


--
-- Name: orden_compra_estatuses; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.orden_compra_estatuses (
    id bigint NOT NULL,
    confirmacion integer DEFAULT 1 NOT NULL,
    confirmacion_estatus_urg character varying(50),
    confirmacion_estatus_proveedor character varying(50),
    confirmacion_boton_urg character varying(50),
    confirmacion_boton_proveedor character varying(50),
    contrato integer DEFAULT 0 NOT NULL,
    contrato_estatus_urg character varying(50),
    contrato_estatus_proveedor character varying(50),
    contrato_boton_urg character varying(50),
    contrato_boton_proveedor character varying(50),
    envio integer DEFAULT 0 NOT NULL,
    envio_estatus_urg character varying(50),
    envio_estatus_proveedor character varying(50),
    envio_boton_urg character varying(50),
    envio_boton_proveedor character varying(50),
    entrega integer DEFAULT 0 NOT NULL,
    entrega_estatus_urg character varying(50),
    entrega_estatus_proveedor character varying(50),
    entrega_boton_urg character varying(50),
    entrega_boton_proveedor character varying(50),
    facturacion integer DEFAULT 0 NOT NULL,
    facturacion_estatus_urg character varying(50),
    facturacion_estatus_proveedor character varying(50),
    facturacion_boton_urg character varying(50),
    facturacion_boton_proveedor character varying(50),
    pago integer DEFAULT 0 NOT NULL,
    pago_estatus_urg character varying(50),
    pago_estatus_proveedor character varying(50),
    pago_boton_urg character varying(50),
    pago_boton_proveedor character varying(50),
    evaluacion integer DEFAULT 0 NOT NULL,
    evaluacion_estatus_urg character varying(50),
    evaluacion_estatus_proveedor character varying(50),
    evaluacion_boton_urg character varying(50),
    evaluacion_boton_proveedor character varying(50),
    finalizada integer DEFAULT 0 NOT NULL,
    indicador_urg character varying(50),
    indicador_proveedor character varying(50),
    indicador_estatus_urg integer,
    indicador_estatus_proveedor integer,
    alerta_urg character varying(100),
    alerta_proveedor character varying(100),
    orden_compra_id integer NOT NULL,
    urg_id integer NOT NULL,
    proveedor_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.orden_compra_estatuses OWNER TO david;

--
-- Name: orden_compra_estatuses_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.orden_compra_estatuses_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.orden_compra_estatuses_id_seq OWNER TO david;

--
-- Name: orden_compra_estatuses_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.orden_compra_estatuses_id_seq OWNED BY public.orden_compra_estatuses.id;


--
-- Name: orden_compra_firmas; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.orden_compra_firmas (
    id bigint NOT NULL,
    rfc character varying(15) NOT NULL,
    nombre character varying(50) NOT NULL,
    primer_apellido character varying(50) NOT NULL,
    segundo_apellido character varying(50),
    puesto character varying(150),
    telefono character varying(10),
    extension character varying(5),
    correo character varying(150) NOT NULL,
    identificador integer NOT NULL,
    folio_consulta character varying(150),
    sello text,
    fecha_firma character varying(50),
    contrato_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.orden_compra_firmas OWNER TO david;

--
-- Name: orden_compra_firmas_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.orden_compra_firmas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.orden_compra_firmas_id_seq OWNER TO david;

--
-- Name: orden_compra_firmas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.orden_compra_firmas_id_seq OWNED BY public.orden_compra_firmas.id;


--
-- Name: orden_compra_prorrogas; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.orden_compra_prorrogas (
    id bigint NOT NULL,
    fecha_solicitud date NOT NULL,
    fecha_entrega_compromiso date NOT NULL,
    dias_solicitados integer NOT NULL,
    motivo character varying(50) NOT NULL,
    descripcion text NOT NULL,
    justificacion character varying(100),
    solicitud character varying(100) NOT NULL,
    estatus boolean,
    fecha_aceptacion date,
    motivo_rechazo character varying(50),
    descripcion_rechazo text,
    orden_compra_id integer NOT NULL,
    proveedor_id integer NOT NULL,
    urg_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.orden_compra_prorrogas OWNER TO david;

--
-- Name: orden_compra_prorrogas_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.orden_compra_prorrogas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.orden_compra_prorrogas_id_seq OWNER TO david;

--
-- Name: orden_compra_prorrogas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.orden_compra_prorrogas_id_seq OWNED BY public.orden_compra_prorrogas.id;


--
-- Name: orden_compra_proveedors; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.orden_compra_proveedors (
    id bigint NOT NULL,
    fecha_entrega date,
    motivo_rechazo character varying(50),
    descripcion_rechazo text,
    urg_id integer NOT NULL,
    orden_compra_id integer NOT NULL,
    proveedor_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.orden_compra_proveedors OWNER TO david;

--
-- Name: orden_compra_proveedors_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.orden_compra_proveedors_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.orden_compra_proveedors_id_seq OWNER TO david;

--
-- Name: orden_compra_proveedors_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.orden_compra_proveedors_id_seq OWNED BY public.orden_compra_proveedors.id;


--
-- Name: orden_compras; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.orden_compras (
    id bigint NOT NULL,
    orden_compra character varying(10) NOT NULL,
    urg_id integer NOT NULL,
    requisicion_id integer NOT NULL,
    usuario_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.orden_compras OWNER TO david;

--
-- Name: orden_compras_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.orden_compras_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.orden_compras_id_seq OWNER TO david;

--
-- Name: orden_compras_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.orden_compras_id_seq OWNED BY public.orden_compras.id;


--
-- Name: password_resets; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.password_resets (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_resets OWNER TO david;

--
-- Name: personal_access_tokens; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.personal_access_tokens OWNER TO david;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.personal_access_tokens_id_seq OWNER TO david;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


--
-- Name: productos_favoritos_urg; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.productos_favoritos_urg (
    id bigint NOT NULL,
    proveedor_ficha_producto_id bigint NOT NULL,
    urg_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.productos_favoritos_urg OWNER TO david;

--
-- Name: productos_favoritos_urg_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.productos_favoritos_urg_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.productos_favoritos_urg_id_seq OWNER TO david;

--
-- Name: productos_favoritos_urg_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.productos_favoritos_urg_id_seq OWNED BY public.productos_favoritos_urg.id;


--
-- Name: productos_preguntas_respuestas; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.productos_preguntas_respuestas (
    id bigint NOT NULL,
    proveedor_ficha_producto_id bigint NOT NULL,
    urg_id bigint NOT NULL,
    tema_pregunta character varying(100),
    pregunta text,
    respuesta text,
    estatus boolean DEFAULT false NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.productos_preguntas_respuestas OWNER TO david;

--
-- Name: productos_preguntas_respuestas_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.productos_preguntas_respuestas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.productos_preguntas_respuestas_id_seq OWNER TO david;

--
-- Name: productos_preguntas_respuestas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.productos_preguntas_respuestas_id_seq OWNED BY public.productos_preguntas_respuestas.id;


--
-- Name: proveedores; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.proveedores (
    id bigint NOT NULL,
    folio_padron character varying(20) NOT NULL,
    rfc character varying(15) NOT NULL,
    password character varying(100),
    constancia character varying(50) NOT NULL,
    nombre character varying(100) NOT NULL,
    persona character varying(20) NOT NULL,
    nacionalidad character varying(20) NOT NULL,
    mipyme character varying(5) NOT NULL,
    tipo_pyme character varying(50),
    codigo_postal integer NOT NULL,
    colonia character varying(100) NOT NULL,
    alcaldia character varying(100) NOT NULL,
    entidad_federativa character varying(100) NOT NULL,
    pais character varying(50) NOT NULL,
    tipo_vialidad character varying(50) NOT NULL,
    vialidad character varying(100) NOT NULL,
    numero_exterior character varying(50) NOT NULL,
    numero_interior character varying(50),
    nombre_legal character varying(50),
    primer_apellido_legal character varying(50),
    segundo_apellido_legal character varying(50),
    telefono_legal character varying(10) NOT NULL,
    extension_legal character varying(5),
    celular_legal character varying(10) NOT NULL,
    correo_legal character varying(100) NOT NULL,
    nombre_tres character varying(50),
    primer_apellido_tres character varying(50),
    segundo_apellido_tres character varying(50),
    cargo_tres character varying(100),
    telefono_tres character varying(10),
    extension_tres character varying(5),
    celular_tres character varying(10),
    correo_tres character varying(100),
    nombre_dos character varying(50),
    primer_apellido_dos character varying(50),
    segundo_apellido_dos character varying(50),
    cargo_dos character varying(100),
    telefono_dos character varying(10),
    extension_dos character varying(5),
    celular_dos character varying(10),
    correo_dos character varying(100),
    nombre_uno character varying(50),
    primer_apellido_uno character varying(50),
    segundo_apellido_uno character varying(50),
    cargo_uno character varying(100),
    telefono_uno character varying(10),
    extension_uno character varying(5),
    celular_uno character varying(10),
    correo_uno character varying(100),
    confirmacion character varying(8),
    confirmacion_fecha timestamp(0) without time zone,
    perfil_completo boolean DEFAULT false NOT NULL,
    estatus boolean DEFAULT true NOT NULL,
    imagen character varying(200),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.proveedores OWNER TO david;

--
-- Name: proveedores_fichas_productos; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.proveedores_fichas_productos (
    id bigint NOT NULL,
    producto_id bigint NOT NULL,
    proveedor_id bigint NOT NULL,
    id_producto character varying(100) NOT NULL,
    version double precision NOT NULL,
    caracteristicas text NOT NULL,
    estatus_inicio boolean DEFAULT false NOT NULL,
    nombre_producto character varying(200),
    descripcion_producto text,
    foto_uno character varying(250),
    foto_dos character varying(250),
    foto_tres character varying(250),
    foto_cuatro character varying(250),
    foto_cinco character varying(250),
    foto_seis character varying(250),
    estatus_producto boolean DEFAULT false NOT NULL,
    doc_ficha_tecnica character varying(250),
    doc_adicional_uno character varying(250),
    doc_adicional_dos character varying(250),
    doc_adicional_tres character varying(250),
    estatus_ficha_tec boolean DEFAULT false NOT NULL,
    marca character varying(100),
    modelo character varying(100),
    material character varying(100),
    composicion character varying(100),
    tamanio character varying(50),
    color json,
    dimensiones json,
    estatus_caracteristicas boolean DEFAULT false NOT NULL,
    sku character varying(15),
    fabricante character varying(150),
    pais_origen character varying(150),
    grado_integracion_nacional character varying(150),
    presentacion character varying(150),
    disenio character varying(150),
    acabado character varying(150),
    forma character varying(150),
    aspecto character varying(150),
    etiqueta character varying(150),
    envase character varying(150),
    empaque character varying(150),
    tiempo_entrega integer,
    temporalidad character varying(50),
    documentacion_incluida json,
    estatus_entrega boolean DEFAULT false NOT NULL,
    precio_unitario double precision,
    unidad_minima_venta integer,
    stock integer,
    vigencia integer DEFAULT 0 NOT NULL,
    estatus_precio boolean DEFAULT false NOT NULL,
    validacion_precio boolean,
    validacion_administracion boolean,
    validacion_tecnica boolean,
    publicado boolean DEFAULT false NOT NULL,
    validacion_cuenta integer DEFAULT 0 NOT NULL,
    validacion_tecnica_prueba character varying(250),
    estatus_validacion_tec boolean DEFAULT false NOT NULL,
    estatus boolean DEFAULT false NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.proveedores_fichas_productos OWNER TO david;

--
-- Name: proveedores_fichas_productos_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.proveedores_fichas_productos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.proveedores_fichas_productos_id_seq OWNER TO david;

--
-- Name: proveedores_fichas_productos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.proveedores_fichas_productos_id_seq OWNED BY public.proveedores_fichas_productos.id;


--
-- Name: proveedores_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.proveedores_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.proveedores_id_seq OWNER TO david;

--
-- Name: proveedores_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.proveedores_id_seq OWNED BY public.proveedores.id;


--
-- Name: rechazar_compras; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.rechazar_compras (
    id bigint NOT NULL,
    rechazo character varying(20) NOT NULL,
    motivo character varying(50) NOT NULL,
    descripcion text NOT NULL,
    proveedor_id integer NOT NULL,
    orden_compra_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.rechazar_compras OWNER TO david;

--
-- Name: rechazar_compras_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.rechazar_compras_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.rechazar_compras_id_seq OWNER TO david;

--
-- Name: rechazar_compras_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.rechazar_compras_id_seq OWNED BY public.rechazar_compras.id;


--
-- Name: reportar_urgs; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.reportar_urgs (
    id bigint NOT NULL,
    motivo character varying(100) NOT NULL,
    descripcion text NOT NULL,
    etapa integer NOT NULL,
    urg_id integer NOT NULL,
    orden_compra_id integer NOT NULL,
    proveedor_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.reportar_urgs OWNER TO david;

--
-- Name: reportar_urgs_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.reportar_urgs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.reportar_urgs_id_seq OWNER TO david;

--
-- Name: reportar_urgs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.reportar_urgs_id_seq OWNED BY public.reportar_urgs.id;


--
-- Name: requisiciones; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.requisiciones (
    id bigint NOT NULL,
    requisicion character varying(10) NOT NULL,
    objeto_requisicion text NOT NULL,
    fecha_autorizacion date NOT NULL,
    monto_autorizado double precision NOT NULL,
    monto_por_confirmar double precision DEFAULT '0'::double precision NOT NULL,
    monto_adjudicado double precision DEFAULT '0'::double precision NOT NULL,
    monto_pagado double precision DEFAULT '0'::double precision NOT NULL,
    clave_partida json NOT NULL,
    urg_id integer NOT NULL,
    estatus boolean NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.requisiciones OWNER TO david;

--
-- Name: requisiciones_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.requisiciones_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.requisiciones_id_seq OWNER TO david;

--
-- Name: requisiciones_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.requisiciones_id_seq OWNED BY public.requisiciones.id;


--
-- Name: rols; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.rols (
    id bigint NOT NULL,
    rol character varying(50) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.rols OWNER TO david;

--
-- Name: rols_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.rols_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.rols_id_seq OWNER TO david;

--
-- Name: rols_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.rols_id_seq OWNED BY public.rols.id;


--
-- Name: solicitud_compras; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.solicitud_compras (
    id bigint NOT NULL,
    orden_compra character varying(10) NOT NULL,
    requisicion character varying(10) NOT NULL,
    urg character varying(200) NOT NULL,
    responsable character varying(150) NOT NULL,
    telefono character varying(10) NOT NULL,
    correo character varying(100) NOT NULL,
    extension character varying(5),
    direccion_almacen character varying(200) NOT NULL,
    responsable_almacen character varying(150) NOT NULL,
    telefono_almacen character varying(10) NOT NULL,
    correo_almacen character varying(100) NOT NULL,
    extension_almacen character varying(5),
    condicion_entrega text NOT NULL,
    producto json NOT NULL,
    orden_compra_id integer NOT NULL,
    urg_id integer NOT NULL,
    requisicion_id integer NOT NULL,
    usuario_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.solicitud_compras OWNER TO david;

--
-- Name: solicitud_compras_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.solicitud_compras_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.solicitud_compras_id_seq OWNER TO david;

--
-- Name: solicitud_compras_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.solicitud_compras_id_seq OWNED BY public.solicitud_compras.id;


--
-- Name: submenus; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.submenus (
    id bigint NOT NULL,
    fecha_inicio_alta date,
    fecha_fin_alta date,
    alta boolean DEFAULT false NOT NULL,
    fecha_inicio_expediente date,
    fecha_fin_expediente date,
    expediente boolean DEFAULT false NOT NULL,
    fecha_inicio_revisor date,
    fecha_fin_revisor date,
    revisor boolean DEFAULT false NOT NULL,
    fecha_inicio_proveedor date,
    fecha_fin_proveedor date,
    proveedor boolean DEFAULT false NOT NULL,
    fecha_inicio_producto date,
    fecha_fin_producto date,
    producto boolean DEFAULT false NOT NULL,
    fecha_inicio_urg date,
    fecha_fin_urg date,
    urg boolean DEFAULT false NOT NULL,
    contrato_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.submenus OWNER TO david;

--
-- Name: submenus_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.submenus_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.submenus_id_seq OWNER TO david;

--
-- Name: submenus_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.submenus_id_seq OWNED BY public.submenus.id;


--
-- Name: urgs; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.urgs (
    id bigint NOT NULL,
    ccg character varying(100) NOT NULL,
    tipo character varying(100) NOT NULL,
    nombre character varying(150) NOT NULL,
    direccion character varying(250) NOT NULL,
    fecha_adhesion date NOT NULL,
    archivo character varying(150) NOT NULL,
    validadora boolean DEFAULT false NOT NULL,
    estatus boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.urgs OWNER TO david;

--
-- Name: urgs_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.urgs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.urgs_id_seq OWNER TO david;

--
-- Name: urgs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.urgs_id_seq OWNED BY public.urgs.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    rfc character varying(15) NOT NULL,
    curp character varying(20) NOT NULL,
    nombre character varying(50) NOT NULL,
    primer_apellido character varying(100) NOT NULL,
    segundo_apellido character varying(100),
    estatus boolean DEFAULT true NOT NULL,
    cargo character varying(150),
    email character varying(200),
    genero character varying(50),
    password character varying(255) NOT NULL,
    telefono character varying(10),
    extension character varying(5),
    rol_id integer NOT NULL,
    urg_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.users OWNER TO david;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO david;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: validacion_administrativas; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.validacion_administrativas (
    id bigint NOT NULL,
    aceptada boolean NOT NULL,
    fecha_revision date NOT NULL,
    comentario text NOT NULL,
    producto_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.validacion_administrativas OWNER TO david;

--
-- Name: validacion_administrativas_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.validacion_administrativas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.validacion_administrativas_id_seq OWNER TO david;

--
-- Name: validacion_administrativas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.validacion_administrativas_id_seq OWNED BY public.validacion_administrativas.id;


--
-- Name: validacion_economicas; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.validacion_economicas (
    id bigint NOT NULL,
    precio double precision NOT NULL,
    producto_id integer NOT NULL,
    intento integer NOT NULL,
    validado boolean NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.validacion_economicas OWNER TO david;

--
-- Name: validacion_economicas_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.validacion_economicas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.validacion_economicas_id_seq OWNER TO david;

--
-- Name: validacion_economicas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.validacion_economicas_id_seq OWNED BY public.validacion_economicas.id;


--
-- Name: validaciones_tecnicas; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.validaciones_tecnicas (
    id bigint NOT NULL,
    direccion character varying(200),
    siglas character varying(10),
    estatus boolean DEFAULT true NOT NULL,
    urg_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.validaciones_tecnicas OWNER TO david;

--
-- Name: validaciones_tecnicas_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.validaciones_tecnicas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.validaciones_tecnicas_id_seq OWNER TO david;

--
-- Name: validaciones_tecnicas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.validaciones_tecnicas_id_seq OWNED BY public.validaciones_tecnicas.id;


--
-- Name: validador_tecnicos; Type: TABLE; Schema: public; Owner: david
--

CREATE TABLE public.validador_tecnicos (
    id bigint NOT NULL,
    aceptada boolean NOT NULL,
    fecha_revision date NOT NULL,
    comentario text NOT NULL,
    producto_id integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.validador_tecnicos OWNER TO david;

--
-- Name: validador_tecnicos_id_seq; Type: SEQUENCE; Schema: public; Owner: david
--

CREATE SEQUENCE public.validador_tecnicos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.validador_tecnicos_id_seq OWNER TO david;

--
-- Name: validador_tecnicos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: david
--

ALTER SEQUENCE public.validador_tecnicos_id_seq OWNED BY public.validador_tecnicos.id;


--
-- Name: adjudicacion_directas id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.adjudicacion_directas ALTER COLUMN id SET DEFAULT nextval('public.adjudicacion_directas_id_seq'::regclass);


--
-- Name: anexos_adjudicacions id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.anexos_adjudicacions ALTER COLUMN id SET DEFAULT nextval('public.anexos_adjudicacions_id_seq'::regclass);


--
-- Name: anexos_contratos_marcos id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.anexos_contratos_marcos ALTER COLUMN id SET DEFAULT nextval('public.anexos_contratos_marcos_id_seq'::regclass);


--
-- Name: anexos_publicas id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.anexos_publicas ALTER COLUMN id SET DEFAULT nextval('public.anexos_publicas_id_seq'::regclass);


--
-- Name: anexos_restringidas id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.anexos_restringidas ALTER COLUMN id SET DEFAULT nextval('public.anexos_restringidas_id_seq'::regclass);


--
-- Name: bien_servicios id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.bien_servicios ALTER COLUMN id SET DEFAULT nextval('public.bien_servicios_id_seq'::regclass);


--
-- Name: cancelar_compras id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.cancelar_compras ALTER COLUMN id SET DEFAULT nextval('public.cancelar_compras_id_seq'::regclass);


--
-- Name: carritos_compras id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.carritos_compras ALTER COLUMN id SET DEFAULT nextval('public.carritos_compras_id_seq'::regclass);


--
-- Name: cat_productos id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.cat_productos ALTER COLUMN id SET DEFAULT nextval('public.cat_productos_id_seq'::regclass);


--
-- Name: contratos id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.contratos ALTER COLUMN id SET DEFAULT nextval('public.contratos_id_seq'::regclass);


--
-- Name: contratos_marcos id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.contratos_marcos ALTER COLUMN id SET DEFAULT nextval('public.contratos_marcos_id_seq'::regclass);


--
-- Name: contratos_marcos_urgs id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.contratos_marcos_urgs ALTER COLUMN id SET DEFAULT nextval('public.contratos_marcos_urgs_id_seq'::regclass);


--
-- Name: expedientes_contratos_marcos id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.expedientes_contratos_marcos ALTER COLUMN id SET DEFAULT nextval('public.expedientes_contratos_marcos_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: grupo_revisors id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.grupo_revisors ALTER COLUMN id SET DEFAULT nextval('public.grupo_revisors_id_seq'::regclass);


--
-- Name: habilitar_productos id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.habilitar_productos ALTER COLUMN id SET DEFAULT nextval('public.habilitar_productos_id_seq'::regclass);


--
-- Name: habilitar_proveedores id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.habilitar_proveedores ALTER COLUMN id SET DEFAULT nextval('public.habilitar_proveedores_id_seq'::regclass);


--
-- Name: incidencia_urgs id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.incidencia_urgs ALTER COLUMN id SET DEFAULT nextval('public.incidencia_urgs_id_seq'::regclass);


--
-- Name: invitacion_restringidas id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.invitacion_restringidas ALTER COLUMN id SET DEFAULT nextval('public.invitacion_restringidas_id_seq'::regclass);


--
-- Name: licitacion_publicas id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.licitacion_publicas ALTER COLUMN id SET DEFAULT nextval('public.licitacion_publicas_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: orden_compra_biens id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_biens ALTER COLUMN id SET DEFAULT nextval('public.orden_compra_biens_id_seq'::regclass);


--
-- Name: orden_compra_envios id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_envios ALTER COLUMN id SET DEFAULT nextval('public.orden_compra_envios_id_seq'::regclass);


--
-- Name: orden_compra_estatuses id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_estatuses ALTER COLUMN id SET DEFAULT nextval('public.orden_compra_estatuses_id_seq'::regclass);


--
-- Name: orden_compra_firmas id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_firmas ALTER COLUMN id SET DEFAULT nextval('public.orden_compra_firmas_id_seq'::regclass);


--
-- Name: orden_compra_prorrogas id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_prorrogas ALTER COLUMN id SET DEFAULT nextval('public.orden_compra_prorrogas_id_seq'::regclass);


--
-- Name: orden_compra_proveedors id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_proveedors ALTER COLUMN id SET DEFAULT nextval('public.orden_compra_proveedors_id_seq'::regclass);


--
-- Name: orden_compras id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compras ALTER COLUMN id SET DEFAULT nextval('public.orden_compras_id_seq'::regclass);


--
-- Name: personal_access_tokens id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);


--
-- Name: productos_favoritos_urg id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.productos_favoritos_urg ALTER COLUMN id SET DEFAULT nextval('public.productos_favoritos_urg_id_seq'::regclass);


--
-- Name: productos_preguntas_respuestas id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.productos_preguntas_respuestas ALTER COLUMN id SET DEFAULT nextval('public.productos_preguntas_respuestas_id_seq'::regclass);


--
-- Name: proveedores id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.proveedores ALTER COLUMN id SET DEFAULT nextval('public.proveedores_id_seq'::regclass);


--
-- Name: proveedores_fichas_productos id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.proveedores_fichas_productos ALTER COLUMN id SET DEFAULT nextval('public.proveedores_fichas_productos_id_seq'::regclass);


--
-- Name: rechazar_compras id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.rechazar_compras ALTER COLUMN id SET DEFAULT nextval('public.rechazar_compras_id_seq'::regclass);


--
-- Name: reportar_urgs id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.reportar_urgs ALTER COLUMN id SET DEFAULT nextval('public.reportar_urgs_id_seq'::regclass);


--
-- Name: requisiciones id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.requisiciones ALTER COLUMN id SET DEFAULT nextval('public.requisiciones_id_seq'::regclass);


--
-- Name: rols id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.rols ALTER COLUMN id SET DEFAULT nextval('public.rols_id_seq'::regclass);


--
-- Name: solicitud_compras id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.solicitud_compras ALTER COLUMN id SET DEFAULT nextval('public.solicitud_compras_id_seq'::regclass);


--
-- Name: submenus id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.submenus ALTER COLUMN id SET DEFAULT nextval('public.submenus_id_seq'::regclass);


--
-- Name: urgs id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.urgs ALTER COLUMN id SET DEFAULT nextval('public.urgs_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Name: validacion_administrativas id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.validacion_administrativas ALTER COLUMN id SET DEFAULT nextval('public.validacion_administrativas_id_seq'::regclass);


--
-- Name: validacion_economicas id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.validacion_economicas ALTER COLUMN id SET DEFAULT nextval('public.validacion_economicas_id_seq'::regclass);


--
-- Name: validaciones_tecnicas id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.validaciones_tecnicas ALTER COLUMN id SET DEFAULT nextval('public.validaciones_tecnicas_id_seq'::regclass);


--
-- Name: validador_tecnicos id; Type: DEFAULT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.validador_tecnicos ALTER COLUMN id SET DEFAULT nextval('public.validador_tecnicos_id_seq'::regclass);


--
-- Data for Name: adjudicacion_directas; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.adjudicacion_directas (id, articulo, fraccion, fecha_sesion, numero_sesion, numero_cotizacion, archivo_aprobacion_original, archivo_aprobacion_publica, numero_proveedores_adjudicado, proveedores_adjudicado, expediente_id, created_at, updated_at) FROM stdin;
1	Articulo 57	\N	\N	\N	56	\N	\N	1	{"proveedores":[{"rfc":"CPI111003TR3","seleccionado":"1"},{"rfc":"KIW131025QH7","seleccionado":"1"}]}	1	2023-04-13 17:51:59	2023-04-19 16:47:35
2	Articulo 57	\N	\N	\N	45	\N	\N	3	{"proveedores":[{"rfc":"CPI111003TR3","seleccionado":"1"},{"rfc":"KIW131025QH7","seleccionado":"1"},{"rfc":"IME771021CS7","seleccionado":"1"}]}	3	2023-04-19 17:01:59	2023-04-19 17:02:05
3	Articulo 57	\N	\N	\N	5	\N	\N	4	{"proveedores":[{"rfc":"AAC011022218","seleccionado":"1"},{"rfc":"CPI111003TR3","seleccionado":"1"},{"rfc":"KIW131025QH7","seleccionado":"1"},{"rfc":"IME771021CS7","seleccionado":"1"}]}	5	2023-06-19 16:52:26	2023-06-19 16:52:32
\.


--
-- Data for Name: anexos_adjudicacions; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.anexos_adjudicacions (id, nombre, archivo_original, archivo_publica, adjudicacion_directa_id, created_at, updated_at) FROM stdin;
1	Dictamen	3.pdf	4.pdf	1	2023-04-17 12:48:36	2023-04-17 12:48:36
2	Acta de selección de proveedores	7.pdf	4.pdf	1	2023-04-17 12:48:48	2023-04-17 12:48:48
3	Dictamen	2.pdf	3.pdf	2	2023-04-19 17:02:19	2023-04-19 17:02:19
4	Oto	12.pdf	10.pdf	2	2023-04-19 17:02:31	2023-04-19 17:02:31
5	Dictamen	3.pdf	6.pdf	3	2023-06-19 16:52:43	2023-06-19 16:52:43
6	Oto	6.pdf	10.pdf	3	2023-06-19 16:52:56	2023-06-19 16:52:56
\.


--
-- Data for Name: anexos_contratos_marcos; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.anexos_contratos_marcos (id, contrato_marco_id, nombre_documento, archivo_original, archivo_publico, created_at, updated_at) FROM stdin;
1	2	Estudio de demanda	16942059880vaJRfVtrFTyWC71.pdf	1694205988mHvCjiO4m2GOczC2.pdf	2023-09-08 14:46:28	2023-09-08 14:46:28
\.


--
-- Data for Name: anexos_publicas; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.anexos_publicas (id, nombre, archivo_original, archivo_publica, licitacion_publica_id, created_at, updated_at) FROM stdin;
1	Dictamen	10.pdf	13.pdf	1	2023-06-19 16:55:50	2023-06-19 16:55:50
2	Acta de selección de proveedores	10.pdf	1.pdf	1	2023-06-19 16:56:04	2023-06-19 16:56:04
3	Dictamen	11.pdf	14.pdf	2	2023-06-19 17:01:16	2023-06-19 17:01:16
4	Oto	10.pdf	4.pdf	2	2023-06-19 17:01:26	2023-06-19 17:01:26
\.


--
-- Data for Name: anexos_restringidas; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.anexos_restringidas (id, nombre, archivo_original, archivo_publica, invitacion_restringida_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: bien_servicios; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.bien_servicios (id, cabms, especificacion, unidad_medida, cantidad, cotizado, precio_maximo, requisicion_id, created_at, updated_at) FROM stdin;
1	2161000054	JABON DE TOCADOR 100 GRS.	PIEZA	100	f	0	1	\N	\N
2	2111000032	LAPIZ BICOLOR PARA MARCAR O RESALTAR TEXTOS	CAJA	200	t	10	1	\N	2023-06-27 13:21:28
5	2111000032	LAPIZ BICOLOR PARA MARCAR O RESALTAR TEXTOS	CAJA	200	t	10	2	\N	2023-06-27 13:22:05
6	2111000032	LAPIZ BICOLOR AZUL/VERDE	CAJA	200	t	10	2	\N	2023-06-27 13:22:05
3	3132000002	AGUA PARA LIMPIENZA	LITROS	10000	t	50	2	\N	2023-06-27 13:22:05
4	3461000002	botellas	PIEZA	20000	t	23	2	\N	2023-06-27 13:22:05
\.


--
-- Data for Name: cancelar_compras; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.cancelar_compras (id, cancelacion, motivo, descripcion, urg_id, orden_compra_id, usuario_id, proveedor_id, created_at, updated_at) FROM stdin;
1	19281C04092023	Error al seleccionar características	gff	1	1	1	3	2023-09-04 12:55:43	2023-09-04 12:55:43
\.


--
-- Data for Name: carritos_compras; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.carritos_compras (id, requisicion_id, proveedor_ficha_producto_id, cantidad_producto, color, comprado, created_at, updated_at) FROM stdin;
1	1	4	1	azul	0	2023-06-02 14:11:52	2023-06-30 13:11:18
7	2	4	1	azul	0	2023-06-23 18:09:07	2023-07-03 13:19:31
5	2	5	3	trasparentes	0	2023-06-13 13:59:31	2023-07-21 17:57:31
8	2	3	2	negro	0	2023-06-23 18:12:01	2023-07-21 17:57:31
2	1	4	2	azul	1	2023-06-02 15:17:52	2023-09-04 12:53:06
3	1	3	3	negro	1	2023-06-02 15:18:04	2023-09-04 12:53:06
4	1	2	4	AMARRILLO	1	2023-06-02 15:19:38	2023-09-04 12:53:06
6	1	5	5	trasparente	1	2023-06-13 13:59:39	2023-09-04 12:53:06
\.


--
-- Data for Name: cat_productos; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.cat_productos (id, numero_ficha, version, capitulo, partida, cabms, descripcion, nombre_corto, especificaciones, medida, validacion_tecnica, tipo_prueba, archivo_ficha_tecnica, estatus, habilitado, contrato_marco_id, validacion_id, created_at, updated_at) FROM stdin;
2	almacenCDMX2023-04-19134610000021.0	1	3000 - SERVICIOS GENERALES	3461 - ALMACENAJE, ENVASE Y EMBALAJE	3461000002	ALMACENAJE, ENVASE Y EMBALAJE	almacen	as	paquete	t	resistencia	informe BID actualizado.docx	t	t	2	2	2023-04-19 17:10:31	2023-04-19 17:11:51
1	gallinaCDMX2023-04-14157310000021.0	1	5000 - BIENES MUEBLES, INMUEBLES E INTANGIBLES	5731 - AVES	5731000002	GALLINA	gallina	vdf	equipo	t	laboratorio	Primer informe.docx	t	t	1	2	2023-04-14 13:01:33	2023-04-24 13:48:47
3	bicolorCDMX2023-05-10121110000321.0	1	2000 - MATERIALES Y SUMINISTROS	2431 - CAL, YESO Y PRODUCTOS DE YESO	2431000002	BLANCO DE ESPAÑA	bicolor	bicolor	frasco	\N	\N	Primer informe.docx	t	t	1	\N	2023-05-10 10:11:01	2023-06-13 13:25:45
4	bicolor2CDMX2023-05-10121110000321.0	1	2000 - MATERIALES Y SUMINISTROS	2111 - MATERIALES, ÚTILES Y EQUIPOS MENORES DE OFICINA	2111000032	BICOLORES	bicolor2	bicolor2	paca	\N	\N	informe BID actualizado.docx	t	t	2	\N	2023-05-10 12:40:39	2023-06-30 17:55:32
5	agua-TratadasCDMX2023-08-03531320000021.0	1	3000 - SERVICIOS GENERALES	3132 - AGUA TRATADA	3132000002	AGUA TRATADA	agua Tratadas	compra de agua tratada	litro	\N	\N	Primer informe.docx	t	f	1	\N	2023-06-05 12:36:14	2023-08-03 12:20:53
\.


--
-- Data for Name: contratos; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.contratos (id, fecha_inicio, fecha_fin, nombre_proveedor, rfc_proveedor, representante_proveedor, domicilio_proveedor, telefono_proveedor, correo_proveedor, fecha_entrega, ccg, responsable_almacen, direccion_almacen, telefono_almacen, razon_social, rfc_fiscal, domicilio_fiscal, metodo_pago, forma_pago, uso_cfdi, estatus, urg_id, orden_compra_id, proveedor_id, created_at, updated_at) FROM stdin;
1	2023-09-13	2023-11-17	CORPORATIVO PIARI SA DE CV	CPI111003TR3	SERGIO IVAN ARIAS PINEDA	CALLE, EMILIANO ZAPATA No. Ext.29, No. Int.20, Santa María Aztahuacán, C.P.9500, Iztapalapa, Ciudad de México	5571556554	marketing@piari.com.mx	2023-10-06	02CD04	C. Alberto Cruz García	Calle Coras esq. Segunda Cerrada De Nahuatlacas Manzana 117 Lote 9, Ajusco Huayamilpas, Coyoacán, 04300, CDMX	56178822 y 56178697	GOBIERNO DE LA CIUDAD DE MÉXICO	GDF9712054NA	PLAZA DE LA CONSTITUCIÓN S/N, CENTRO DE LA CIUDAD DE MÉXICO, 06000	PUE (Pago en una sola exhibición)	TRANSFERENCIA INTERBANCARIA	GASTOS EN GENERAL	f	1	1	1	2023-09-04 12:56:15	2023-09-14 14:35:59
\.


--
-- Data for Name: contratos_marcos; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.contratos_marcos (id, numero_cm, nombre_cm, imagen, objetivo, f_inicio, f_fin, capitulo_partida, compras_verdes, validacion_tecnica, validaciones_seleccionadas, sector, liberado, porcentaje, eliminado, user_id_responsable, urg_id, created_at, updated_at) FROM stdin;
3	Inventore-3-2023-CDMX	Inventore	\N	hgcb	2023-06-30	2024-03-16	{"10000":{"capitulo":"2","partida":"2181","descripcion":"MATERIALES PARA EL REGISTRO E IDENTIFICACI\\u00d3N DE BIENES Y PERSONAS"}}	f	f	[{"id_val_sel":"No hay validaciones"}]	[{"sector":"cooperativas"}]	f	78	f	1	1	2023-06-19 16:58:30	2023-08-03 17:57:42
4	Et-4-2023-CDMX	Et	\N	ok	2023-08-10	2023-09-21	[{"capitulo":"3","partida":"3271","descripcion":"ARRENDAMIENTO DE ACTIVOS INTANGIBLES"}]	f	f	[{"id_val_sel":"No hay validaciones"}]	[{"sector":"campesinos"},{"sector":"sr"}]	f	10	f	3	1	2023-08-07 13:54:44	2023-08-07 13:54:44
2	Quam2-2-2023-CDMX	Quam2	1694126695aab1e16e-0bbb-4a92-b62b-466902e6c38b.jpeg	Lorem, ipsum, dolor sit amet consectetur adipisicing elit. Laborum corporis nihil impedit, ex, officiis  Lorem, ipsum, dolor sit amet consectetur adipisicing elit. Laborum corporis nihil impedit, ex, officiis dolor rem saepe suscipit totam eligendi est optio minima dolores quae quas consequatur officia tempora obcaecati Lorem, ipsum, dolor sit amet consectetur adipisicing elit. Laborum corporis nihil impedit, ex, officiis dolor rem saepe suscipit totam eligendi est optio minima dolores quae quas consequatur officia tempora obcaecati	2023-04-19	2025-03-21	{"10000":{"capitulo":"3","partida":"3131","descripcion":"AGUA POTABLE"}}	f	f	[{"id_val_sel":"No hay validaciones"}]	[{"sector":"cooperativas"}]	t	100	f	2	1	2023-04-19 16:58:20	2023-09-08 15:10:35
5	hjdjh-5-2023-CDMX	hjdjh	\N	ok	2023-08-24	2024-12-14	{"10000":{"capitulo":"3","partida":"3271","descripcion":"ARRENDAMIENTO DE ACTIVOS INTANGIBLES"},"1":{"capitulo":"3","partida":"3461","descripcion":"ALMACENAJE, ENVASE Y EMBALAJE"},"2":{"capitulo":"3","partida":"3231","descripcion":"ARRENDAMIENTO DE MOBILIARIO Y EQUIPO DE ADMINISTRACI\\u00d3N, EDUCACIONAL Y RECREATIVO"}}	f	f	[{"id_val_sel":"No hay validaciones"}]	[{"sector":"sr"}]	f	10	f	2	1	2023-08-07 16:41:45	2023-09-07 17:57:23
6	sd-6-2023-CDMX	sd	\N	hshdsyd bhdsbdsdhb ywqgwyuqgwuywq s ajsbjabsjhabsjba wqyw xaksxkajbsa ushuasuihasiuahsiuhiuhiuhasb sajasbjasbjhbas jasbhashbash	2023-09-20	2024-09-14	{"10000":{"capitulo":"2","partida":"2161","descripcion":"MATERIAL DE LIMPIEZA."},"10001":{"capitulo":"2","partida":"2461","descripcion":"MATERIAL EL\\u00c9CTRICO Y ELECTR\\u00d3NICO"},"10002":{"capitulo":"2","partida":"2751","descripcion":"BLANCOS Y OTROS PRODUCTOS TEXTILES, EXCEPTO PRENDAS DE VESTIR"},"1":{"capitulo":"2","partida":"2181","descripcion":"MATERIALES PARA EL REGISTRO E IDENTIFICACI\\u00d3N DE BIENES Y PERSONAS"}}	t	t	[{"id_val_sel":"1"}]	[{"sector":"mipymes"},{"sector":"elpm"},{"sector":"sr"}]	f	10	f	3	1	2023-09-07 17:59:51	2023-09-07 18:01:04
1	Quam-1-2023-CDMX	Quam	\N	test	2023-04-27	2024-04-13	{"10000":{"capitulo":"5","partida":"5731","descripcion":"AVES"},"10001":{"capitulo":"5","partida":"5941","descripcion":"DERECHOS"},"10002":{"capitulo":"5","partida":"5711","descripcion":"BOVINOS"}}	t	t	[{"id_val_sel":"1"},{"id_val_sel":"2"}]	[{"sector":"campesinos"},{"sector":"cooperativas"},{"sector":"sr"}]	t	76	f	1	1	2023-04-13 17:49:16	2023-09-08 12:33:05
\.


--
-- Data for Name: contratos_marcos_urgs; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.contratos_marcos_urgs (id, urg_id, contrato_marco_id, fecha_firma, a_terminos_especificos, estatus, created_at, updated_at) FROM stdin;
1	2	2	2023-06-09	1684341588qSgqlzgEttluDLyCM_URG_OC.pdf	t	2023-05-17 10:39:48	2023-05-17 10:39:48
2	1	2	2023-05-18	1684436581knwr5ZiIzjKaws312.pdf	t	2023-05-18 13:03:02	2023-09-11 15:01:49
3	1	1	2023-05-16	1684537266Um2Ghm5vNog4UEQ13.pdf	f	2023-05-19 17:01:06	2023-09-14 13:28:16
\.


--
-- Data for Name: expedientes_contratos_marcos; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.expedientes_contratos_marcos (id, f_creacion, metodo, num_procedimiento, imagen, liberado, porcentaje, contrato_id, created_at, updated_at) FROM stdin;
1	2023-04-06	Convocatoria Directa Contrato Marco	Adj-Dir1	1681429779software-bug.png	t	100	1	2023-04-13 17:49:28	2023-04-17 12:48:51
3	2023-04-19	Convocatoria Directa Contrato Marco	caom	\N	t	100	2	2023-04-19 16:59:56	2023-04-19 17:02:34
4	2023-04-14	Convocatoria Directa Contrato Marco	S	\N	f	0	1	2023-04-26 11:45:56	2023-04-26 11:45:56
5	2023-06-21	Convocatoria Directa Contrato Marco	S	\N	t	100	1	2023-06-19 16:50:50	2023-06-19 16:53:13
2	2023-04-16	Convocatoria Pública Contrato Marco	LicPu-1	\N	t	100	1	2023-04-13 17:54:30	2023-06-19 16:56:07
6	2023-06-16	Convocatoria Pública Contrato Marco	p	\N	t	100	3	2023-06-19 16:58:54	2023-06-19 17:01:28
7	2023-06-24	Convocatoria Restringida Contrato Marco	sfdghj	\N	f	0	3	2023-06-30 17:40:28	2023-06-30 17:40:28
9	2023-08-18	Convocatoria Restringida Contrato Marco	dssd	\N	f	0	2	2023-08-30 14:15:25	2023-08-30 14:15:25
8	2023-08-25	Convocatoria Pública Contrato Marco	dsd	\N	f	17	2	2023-08-04 17:19:18	2023-08-31 11:11:25
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: grupo_revisors; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.grupo_revisors (id, convocatoria, emite, objeto, motivo, numero_oficio, archivo_invitacion, archivo_ficha_tecnica, fecha_mesa, lugar, comentarios, numero_asistieron, asistieron, observaciones, archivo_minuta, contrato_id, created_at, updated_at) FROM stdin;
1	448	ds	dfdzf	fdfdf	fdf	6.pdf	7.pdf	2023-04-07	TEST	dsdcv	2	{"urg":[{"nombre":"Coyoac\\u00e1n","seleccionado":"1"},{"nombre":"Secretar\\u00eda de Administraci\\u00f3n y Finanzas","seleccionado":"1"}]}	sdv	5.pdf	1	2023-04-13 17:58:48	2023-04-13 17:58:48
2	1977	DGRMSG	real	real	eral	4.pdf	5.pdf	2023-02-28	34	\N	2	{"urg":[{"nombre":"Coyoac\\u00e1n","seleccionado":"1"},{"nombre":"Secretar\\u00eda de Administraci\\u00f3n y Finanzas","seleccionado":"1"}]}	rfsr	6.pdf	1	2023-04-17 12:39:06	2023-04-17 12:39:06
3	1977	DGRMSG	real	real	eral	10.pdf	5.pdf	2023-02-28	34	\N	2	{"urg":[{"nombre":"Coyoac\\u00e1n","seleccionado":"1"},{"nombre":"Secretar\\u00eda de Administraci\\u00f3n y Finanzas","seleccionado":"1"}]}	rfsr	13.pdf	2	2023-04-19 17:11:24	2023-04-19 17:11:24
\.


--
-- Data for Name: habilitar_productos; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.habilitar_productos (id, precio_maximo, fecha_estudio, archivo_estudio_original, archivo_estudio_publico, fecha_formulario, fecha_carga, fecha_administrativa, fecha_tecnica, fecha_publicacion, cat_producto_id, grupo_revisor_id, created_at, updated_at) FROM stdin;
1	54	2023-04-22	16814989355.pdf	16814989356.pdf	2023-04-15	2023-04-22	2023-04-30	2023-05-13	2023-05-20	1	1	2023-04-14 13:01:33	2023-04-14 13:02:15
2	23	2023-04-19	168194591114.pdf	16819459115.pdf	2023-04-12	2023-04-15	2023-04-22	2023-04-21	2023-04-29	2	3	2023-04-19 17:10:31	2023-04-19 17:11:51
3	11	2023-05-24	168373517013.pdf	168373517014.pdf	2023-05-16	2023-05-20	2023-05-23	2023-05-26	2023-05-28	3	1	2023-05-10 10:11:01	2023-05-12 11:08:42
4	10	2023-05-19	168374421013.pdf	168374421010.pdf	2023-05-06	2023-05-14	2023-05-18	2023-05-21	2023-05-17	4	3	2023-05-10 12:40:39	2023-05-17 11:02:22
5	50	2023-06-22	16859902154.pdf	168599021511.pdf	2023-06-21	2023-06-24	2023-06-22	2023-07-01	2023-06-22	5	1	2023-06-05 12:36:14	2023-06-05 12:36:55
\.


--
-- Data for Name: habilitar_proveedores; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.habilitar_proveedores (id, fecha_adhesion, archivo_adhesion, habilitado, proveedor_id, expediente_id, contrato_id, created_at, updated_at) FROM stdin;
1	2023-04-13	16817573734.pdf	t	2	1	1	2023-04-17 12:48:26	2023-04-17 12:49:33
2	2023-04-20	168194447013.pdf	t	1	1	1	2023-04-19 16:47:35	2023-04-19 16:47:50
4	2023-04-13	168194540113.pdf	t	2	3	2	2023-04-19 17:02:05	2023-04-19 17:03:21
5	2023-04-16	168194539210.pdf	t	3	3	2	2023-04-19 17:02:05	2023-05-16 17:25:21
6	\N	\N	\N	4	5	1	2023-06-19 16:52:32	2023-06-19 16:52:32
7	\N	\N	\N	1	5	1	2023-06-19 16:52:32	2023-06-19 16:52:32
8	\N	\N	\N	2	5	1	2023-06-19 16:52:32	2023-06-19 16:52:32
9	\N	\N	\N	3	5	1	2023-06-19 16:52:32	2023-06-19 16:52:32
10	\N	\N	\N	2	2	1	2023-06-19 16:55:18	2023-06-19 16:55:18
11	\N	\N	\N	3	2	1	2023-06-19 16:55:18	2023-06-19 16:55:18
12	\N	\N	\N	4	6	3	2023-06-19 17:00:35	2023-06-19 17:00:35
13	\N	\N	\N	1	6	3	2023-06-19 17:00:35	2023-06-19 17:00:35
3	2023-04-06	1688158893eldocumento-7.pdf	t	1	3	2	2023-04-19 17:02:05	2023-06-30 15:01:33
\.


--
-- Data for Name: incidencia_urgs; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.incidencia_urgs (id, motivo, descripcion, etapa, urg_id, orden_compra_id, proveedor_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: invitacion_restringidas; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.invitacion_restringidas (id, articulo, fraccion, fecha_sesion, numero_sesion, numero_cotizacion, numero_proveedores_invitados, proveedores_invitados, archivo_aprobacion_original, archivo_aprobacion_publica, numero_proveedores_participaron, proveedores_participaron, archivo_aclaracion_original, archivo_aclaracion_publica, numero_proveedores_propuesta, proveedores_propuesta, numero_proveedores_descalificados, proveedores_descalificados, archivo_presentacion_original, archivo_presentacion_publico, numero_proveedores_aprobados, proveedores_aprobados, numero_proveedores_adjudicados, proveedores_adjudicados, expediente_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: licitacion_publicas; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.licitacion_publicas (id, tiangis, tipo_licitacion, tipo_contratacion, fecha_convocatoria, numero_proveedores_base, proveedores_base, archivo_base_licitacion, fecha_aclaracion, archivo_acta_declaracion_original, archivo_acta_declaracion_publico, fecha_propuesta, numero_proveedores_propuesta, proveedores_propuesta, numero_proveedores_descalificados, proveedores_descalificados, archivo_acta_presentacion_original, archivo_acta_presentacion_publico, fecha_fallo, numero_proveedores_aprobados, proveedores_aprobados, numero_proveedores_adjudicados, proveedores_adjudicados, archivo_acta_fallo_original, archivo_acta_fallo_publica, archivo_oficio_adjudicacion_original, archivo_oficio_adjudicacion_publico, expediente_id, created_at, updated_at) FROM stdin;
1	t	Nacional	Adquisición de bienes	2023-04-14	4	{"proveedores":[{"rfc":"AAC011022218","seleccionado":"1"},{"rfc":"CPI111003TR3","seleccionado":"1"},{"rfc":"KIW131025QH7","seleccionado":"1"},{"rfc":"IME771021CS7","seleccionado":"1"}]}	6.pdf	2023-06-20	6.pdf	10.pdf	2023-06-23	4	{"proveedores":[{"rfc":"AAC011022218","seleccionado":"1"},{"rfc":"CPI111003TR3","seleccionado":"1"},{"rfc":"KIW131025QH7","seleccionado":"1"},{"rfc":"IME771021CS7","seleccionado":"1"}]}	0	{"proveedores":[{"rfc":"AAC011022218","seleccionado":0},{"rfc":"CPI111003TR3","seleccionado":0},{"rfc":"KIW131025QH7","seleccionado":0},{"rfc":"IME771021CS7","seleccionado":0}]}	10.pdf	10.pdf	2023-06-22	4	{"proveedores":[{"rfc":"AAC011022218","seleccionado":"1"},{"rfc":"CPI111003TR3","seleccionado":"1"},{"rfc":"KIW131025QH7","seleccionado":"1"},{"rfc":"IME771021CS7","seleccionado":"1"}]}	2	{"proveedores":[{"rfc":"AAC011022218","seleccionado":0},{"rfc":"CPI111003TR3","seleccionado":0},{"rfc":"KIW131025QH7","seleccionado":1},{"rfc":"IME771021CS7","seleccionado":1}]}	5.pdf	14.pdf	13.pdf	6.pdf	2	2023-04-13 17:54:49	2023-06-19 16:55:18
2	t	Nacional	Adquisición de bienes	2023-06-24	4	{"proveedores":[{"rfc":"AAC011022218","seleccionado":"1"},{"rfc":"CPI111003TR3","seleccionado":"1"},{"rfc":"KIW131025QH7","seleccionado":"1"},{"rfc":"IME771021CS7","seleccionado":"1"}]}	9.pdf	2023-06-15	10.pdf	13.pdf	2023-06-09	4	{"proveedores":[{"rfc":"AAC011022218","seleccionado":"1"},{"rfc":"CPI111003TR3","seleccionado":"1"},{"rfc":"KIW131025QH7","seleccionado":"1"},{"rfc":"IME771021CS7","seleccionado":"1"}]}	0	{"proveedores":[{"rfc":"AAC011022218","seleccionado":0},{"rfc":"CPI111003TR3","seleccionado":0},{"rfc":"KIW131025QH7","seleccionado":0},{"rfc":"IME771021CS7","seleccionado":0}]}	10.pdf	9.pdf	2023-06-23	4	{"proveedores":[{"rfc":"AAC011022218","seleccionado":"1"},{"rfc":"CPI111003TR3","seleccionado":"1"},{"rfc":"KIW131025QH7","seleccionado":"1"},{"rfc":"IME771021CS7","seleccionado":"1"}]}	2	{"proveedores":[{"rfc":"AAC011022218","seleccionado":1},{"rfc":"CPI111003TR3","seleccionado":1},{"rfc":"KIW131025QH7","seleccionado":0},{"rfc":"IME771021CS7","seleccionado":0}]}	13.pdf	5.pdf	14.pdf	3.pdf	6	2023-06-19 16:59:26	2023-06-19 17:00:35
3	t	Nacional	Prestación de servicios	2023-08-25	0	\N	\N	\N	\N	\N	\N	0	\N	0	\N	\N	\N	\N	0	\N	0	\N	\N	\N	\N	\N	8	2023-08-31 11:11:24	2023-08-31 11:11:24
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.migrations (id, migration, batch) FROM stdin;
197	2014_10_12_100000_create_password_resets_table	1
198	2019_08_19_000000_create_failed_jobs_table	1
199	2019_12_14_000001_create_personal_access_tokens_table	1
200	2022_09_01_150406_create_rols_table	1
201	2022_09_01_154741_create_proveedores_table	1
202	2022_09_01_154830_create_urgs_table	1
203	2022_09_01_154831_create_users_table	1
204	2022_09_01_171550_create_contratos_marcos_table	1
205	2022_09_01_171551_create_expedientes_contratos_marcos_table	1
206	2022_09_01_173600_create_adjudicacion_directas_table	1
207	2022_09_01_180137_create_invitacion_restringidas_table	1
208	2022_09_01_181615_create_licitacion_publicas_table	1
209	2022_09_01_211823_create_anexos_adjudicacions_table	1
210	2022_09_01_211936_create_anexos_restringidas_table	1
211	2022_09_01_211948_create_anexos_publicas_table	1
212	2022_09_13_155058_create_validaciones_tecnicas_table	1
213	2022_10_17_201810_create_anexos_contratos_marcos_table	1
214	2022_11_16_221508_create_cat_productos_table	1
215	2022_11_25_205418_create_grupo_revisors_table	1
216	2022_12_08_171655_create_contratos_marcos_urgs_table	1
217	2022_12_20_172649_create_proveedores_fichas_productos_table	1
218	2022_12_22_190543_create_habilitar_proveedores_table	1
219	2023_01_02_163935_create_habilitar_productos_table	1
220	2023_01_19_101650_create_submenus_table	1
221	2023_02_02_110030_create_productos_preguntas_respuestas_table	1
222	2023_02_13_114439_create_validacion_economicas_table	1
223	2023_02_16_175232_create_validacion_administrativas_table	1
224	2023_02_17_145543_create_validador_tecnicos_table	1
225	2023_04_12_161419_create_productos_favoritos_urg_table	2
232	2023_04_24_165723_create_requisiciones_table	3
233	2023_05_08_175848_create_bien_servicios_table	3
235	2023_05_08_143950_create_carritos_compras_table	4
444	2023_06_26_124226_create_orden_compras_table	5
445	2023_06_26_180229_create_solicitud_compras_table	5
446	2023_06_28_170026_create_orden_compra_biens_table	5
447	2023_07_13_114037_create_orden_compra_proveedors_table	5
448	2023_07_13_114101_create_orden_compra_estatuses_table	5
449	2023_07_18_133606_create_reportar_urgs_table	5
450	2023_07_18_133639_create_incidencia_urgs_table	5
451	2023_07_18_181543_create_contratos_table	5
452	2023_08_01_123631_create_cancelar_compras_table	5
453	2023_08_09_123749_create_orden_compra_firmas_table	5
454	2023_08_22_111928_create_rechazar_compras_table	5
455	2023_08_28_113904_create_orden_compra_envios_table	5
456	2023_08_28_113949_create_orden_compra_prorrogas_table	5
\.


--
-- Data for Name: orden_compra_biens; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.orden_compra_biens (id, cabms, nombre, cantidad, precio, medida, color, tamanio, estatus, proveedor_ficha_producto_id, proveedor_id, urg_id, orden_compra_id, requisicion_id, created_at, updated_at) FROM stdin;
1	2111000032	COMPUTADORA	2	10	paca	azul	cuadrado	4	4	3	1	1	1	2023-09-04 12:53:06	2023-09-04 12:55:43
2	2111000032	teclado	3	10	paca	negro	RECTANGULAR	4	3	3	1	1	1	2023-09-04 12:53:06	2023-09-04 12:55:43
3	5731000002	gallina2	4	53	equipo	AMARRILLO	POLLO	1	2	1	1	1	1	2023-09-04 12:53:06	2023-09-04 12:56:15
4	3132000002	agua tra	5	35	litro	trasparente	galon	1	5	1	1	1	1	2023-09-04 12:53:06	2023-09-04 12:56:15
\.


--
-- Data for Name: orden_compra_envios; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.orden_compra_envios (id, fecha_envio, comentarios, fecha_entrega_almacen, nota_remision, fecha_entrega_aceptada, estatus, orden_compra_id, proveedor_id, urg_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: orden_compra_estatuses; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.orden_compra_estatuses (id, confirmacion, confirmacion_estatus_urg, confirmacion_estatus_proveedor, confirmacion_boton_urg, confirmacion_boton_proveedor, contrato, contrato_estatus_urg, contrato_estatus_proveedor, contrato_boton_urg, contrato_boton_proveedor, envio, envio_estatus_urg, envio_estatus_proveedor, envio_boton_urg, envio_boton_proveedor, entrega, entrega_estatus_urg, entrega_estatus_proveedor, entrega_boton_urg, entrega_boton_proveedor, facturacion, facturacion_estatus_urg, facturacion_estatus_proveedor, facturacion_boton_urg, facturacion_boton_proveedor, pago, pago_estatus_urg, pago_estatus_proveedor, pago_boton_urg, pago_boton_proveedor, evaluacion, evaluacion_estatus_urg, evaluacion_estatus_proveedor, evaluacion_boton_urg, evaluacion_boton_proveedor, finalizada, indicador_urg, indicador_proveedor, indicador_estatus_urg, indicador_estatus_proveedor, alerta_urg, alerta_proveedor, orden_compra_id, urg_id, proveedor_id, created_at, updated_at) FROM stdin;
1	2	Orden cancelada	Orden cancelada	Orden cancelada	Orden cancelada	0	\N	\N	Alta de contrato	Firmar contrato	0	\N	\N	Seguimiento	Confirmar envío	0	\N	\N	Aceptar pedido	Sustitución de bienes	0	\N	\N	Aceptar prefactura	Enviar prefactura	0	\N	\N	Adjuntar CLC	Validar pago	0	\N	\N	Calificar compra	Ver evaluacióon	0	Cancelada	Cancelada	3	3	La compra fue cancelada	La compra fue cancelada	1	1	3	2023-09-04 12:53:06	2023-09-04 12:55:43
2	2	Se aceptó Orden completa	Se aceptó Orden completa	Orden de compra	Orden de compra	0	En espera	En espera	Alta de contrato	Firmar contrato	0	\N	\N	Seguimiento	Confirmar envío	0	\N	\N	Aceptar pedido	Sustitución de bienes	0	\N	\N	Aceptar prefactura	Enviar prefactura	0	\N	\N	Adjuntar CLC	Validar pago	0	\N	\N	Calificar compra	Ver evaluacióon	0	En espera	En espera	0	0	Confirmación exitosa	Confirmación exitosa	1	1	1	2023-09-04 12:53:06	2023-09-04 12:56:16
\.


--
-- Data for Name: orden_compra_firmas; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.orden_compra_firmas (id, rfc, nombre, primer_apellido, segundo_apellido, puesto, telefono, extension, correo, identificador, folio_consulta, sello, fecha_firma, contrato_id, created_at, updated_at) FROM stdin;
1	JILA9103187I6	JOSE ADRIAN	JIMENEZ	LOPEZ	JEFE DE UNIDAD DEPARTAMENTAL DE COMPRAS Y CONTROL DE MATERIALES	5689421589	4589	adrian.jimenez.df@gmail.com	1	\N	\N	\N	1	2023-09-04 14:00:28	2023-09-04 14:01:03
2	JILA9103187I6	JOSE ADRIAN	JIMENEZ	LOPEZ	JEFE DE UNIDAD DEPARTAMENTAL DE COMPRAS Y CONTROL DE MATERIALES	5689421589	4589	adrian.jimenez.df@gmail.com	4	\N	\N	\N	1	2023-09-04 14:01:12	2023-09-04 14:01:12
3	FOGG8510192N2	GUILLERMO NATIVIDAD	FLORES	GARDUÑO	SUBDIRECTOR DE ATENCIóN OPERATIVA	5689421589	4589	gmo.floresg@gmail.com	5	\N	\N	\N	1	2023-09-04 14:01:20	2023-09-04 14:01:20
4	FOGG8510192N2	GUILLERMO NATIVIDAD	FLORES	GARDUÑO	SUBDIRECTOR DE ATENCIóN OPERATIVA	5689421589	4589	gmo.floresg@gmail.com	2	\N	\N	\N	1	2023-09-04 14:01:38	2023-09-04 14:01:38
\.


--
-- Data for Name: orden_compra_prorrogas; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.orden_compra_prorrogas (id, fecha_solicitud, fecha_entrega_compromiso, dias_solicitados, motivo, descripcion, justificacion, solicitud, estatus, fecha_aceptacion, motivo_rechazo, descripcion_rechazo, orden_compra_id, proveedor_id, urg_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: orden_compra_proveedors; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.orden_compra_proveedors (id, fecha_entrega, motivo_rechazo, descripcion_rechazo, urg_id, orden_compra_id, proveedor_id, created_at, updated_at) FROM stdin;
1	\N	\N	\N	1	1	3	2023-09-04 12:53:06	2023-09-04 12:53:06
2	2023-10-06	\N	\N	1	1	1	2023-09-04 12:53:06	2023-09-04 12:56:16
\.


--
-- Data for Name: orden_compras; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.orden_compras (id, orden_compra, urg_id, requisicion_id, usuario_id, created_at, updated_at) FROM stdin;
1	1928-1	1	1	1	2023-09-04 12:53:06	2023-09-04 12:53:06
\.


--
-- Data for Name: password_resets; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.password_resets (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: personal_access_tokens; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: productos_favoritos_urg; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.productos_favoritos_urg (id, proveedor_ficha_producto_id, urg_id, created_at, updated_at, deleted_at) FROM stdin;
1	4	1	2023-06-13 13:55:07	2023-06-13 13:55:07	\N
\.


--
-- Data for Name: productos_preguntas_respuestas; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.productos_preguntas_respuestas (id, proveedor_ficha_producto_id, urg_id, tema_pregunta, pregunta, respuesta, estatus, created_at, updated_at) FROM stdin;
1	4	1	Características	?????	\N	t	2023-05-19 12:05:11	2023-05-19 12:05:11
2	4	1	Presentación	ya sirve el modo responsivo???????????	\N	t	2023-05-19 12:06:26	2023-05-19 12:06:26
\.


--
-- Data for Name: proveedores; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.proveedores (id, folio_padron, rfc, password, constancia, nombre, persona, nacionalidad, mipyme, tipo_pyme, codigo_postal, colonia, alcaldia, entidad_federativa, pais, tipo_vialidad, vialidad, numero_exterior, numero_interior, nombre_legal, primer_apellido_legal, segundo_apellido_legal, telefono_legal, extension_legal, celular_legal, correo_legal, nombre_tres, primer_apellido_tres, segundo_apellido_tres, cargo_tres, telefono_tres, extension_tres, celular_tres, correo_tres, nombre_dos, primer_apellido_dos, segundo_apellido_dos, cargo_dos, telefono_dos, extension_dos, celular_dos, correo_dos, nombre_uno, primer_apellido_uno, segundo_apellido_uno, cargo_uno, telefono_uno, extension_uno, celular_uno, correo_uno, confirmacion, confirmacion_fecha, perfil_completo, estatus, imagen, created_at, updated_at) FROM stdin;
4	WK08SEO-XZRTPMV	AAC011022218	$2y$10$/c4Kwf5uV74Wp6QqxssMr.BzHOU8irOAKCijsRlZuQPCrpVfuMyRu	true	ARRENDADORA AEREA CORPORATIVA SA DE CV	Moral	Mexico	No	\N	4530	Insurgentes Cuicuilco	Coyoacán	Ciudad de México	Mexico	CALLE	LAS PRADERAS	109	\N	JAIME	MURGUIA	TAPIA	5554003932	\N	5559487165	jmurguia@prodigy.net.mx	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	t	t	https://tianguisdigital.finanzas.cdmx.gob.mx/storage/perfil/AAC011022218/foto	2023-04-20 17:30:36	2023-06-29 16:03:06
2	4T4PHHW-OPS7WAJ	KIW131025QH7	$2y$10$lA7YtsIgrTgOTeY8PX8jdeqcUHSTePle60mRQgPnoqvUSGYb2mFz.	true	KIWIIENTERPRISE SA DE CV	Moral	Mexico	No	\N	9710	Los Ángeles Apanoaya	Iztapalapa	Ciudad de México	Mexico	CALLE	GIRASOL	19	\N	GABRIELA	SUAREZ	RIVERA	5558401465	\N	5558401465	kiwiienterprise@gmail.com	Nemo explicabo Reru	Earum esse sed	Suscipit quaerat	Qui qui tempore similique	8885065895	95458	0865478895	lirufysuwo@mailinator.com	Nostrud explicabo	Earum quaerat amet	Veritatis rerum	Dicta facere repellendus	5445805698	10485	5456589547	huca@mailinator.com	Quo ex porro	Cupiditate commodi	Mollit id ut sit unde	Consequatur libero	1445896345	58589	5642014587	jugile@mailinator.com	c29mJYyn	2023-04-18 12:36:10	t	t	https://tianguisdigital.finanzas.cdmx.gob.mx/storage/perfil/KIW131025QH7/foto	2023-04-17 12:45:35	2023-04-18 12:36:27
3	2EW2SPO-EAOBFUN	IME771021CS7	$2y$10$lA7YtsIgrTgOTeY8PX8jdeqcUHSTePle60mRQgPnoqvUSGYb2mFz.	true	INSTALACIONES Y MANTENIMIENTO EN EQUIPO DE RADIO COMUNICACIÓN SAPI DE CV	Moral	Mexico	No	\N	9300	Guadalupe del Moral	Iztapalapa	Ciudad de México	Mexico	AVENIDA	JAVIER ROJO GOMEZ	514	\N	LUIS ANGEL	SOTO	BERNARDINO	5557581623	4012	5520515170	lsoto@inmer.com	Magnam eum aut illo	Incididunt necessitatibus	Cum rem delectus	Optio consequuntur	5156984785	76878	2236541884	fitub@mailinator.com	Assumenda dignissimos	Soluta eum voluptatem	Nulla architecto amet	Ab inventore provident	3586247854	39145	9424789631	kevyryta@mailinator.com	Nesciunt repudiandae	Tempora ipsum dolore	Accusamus quisquam	In proident sint fugiat eu neque esse facere e	6278521459	72287	4435478956	veteza@mailinator.com	ndZQb6So	2023-04-19 17:20:43	t	t	https://tianguisdigital.finanzas.cdmx.gob.mx/storage/perfil/IME771021CS7/foto	2023-04-18 16:27:42	2023-04-19 17:21:31
1	DQFPXT8-GPJWR47	CPI111003TR3	$2y$10$lA7YtsIgrTgOTeY8PX8jdeqcUHSTePle60mRQgPnoqvUSGYb2mFz.	true	CORPORATIVO PIARI SA DE CV	Moral	Mexico	No	\N	9500	Santa María Aztahuacán	Iztapalapa	Ciudad de México	Mexico	CALLE	EMILIANO ZAPATA	29	20	SERGIO IVAN	ARIAS	PINEDA	5571556554	\N	5565813585	marketing@piari.com.mx	Reprehenderit pariat	Fugit omnis voluptas	Itaque laboriosam	Molestiae voluptatibus	4545896587	58569	9665840458	ribitu@mailinator.com	Magna ipsam proident	Quod excepteur est	Consequatur	Libero aut molestiae	5648956785	37205	9365207895	sotavy@mailinator.com	Dicta mollit dolor	Est ea soluta laboris	Ut sed aut est	Aut laboriosam eos	8278546085	68895	9214578950	modoroven@mailinator.com	gB4GWHFg	2023-04-14 11:09:53	t	t	https://tianguisdigital.finanzas.cdmx.gob.mx	2023-04-13 17:07:43	2023-08-28 14:36:36
\.


--
-- Data for Name: proveedores_fichas_productos; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.proveedores_fichas_productos (id, producto_id, proveedor_id, id_producto, version, caracteristicas, estatus_inicio, nombre_producto, descripcion_producto, foto_uno, foto_dos, foto_tres, foto_cuatro, foto_cinco, foto_seis, estatus_producto, doc_ficha_tecnica, doc_adicional_uno, doc_adicional_dos, doc_adicional_tres, estatus_ficha_tec, marca, modelo, material, composicion, tamanio, color, dimensiones, estatus_caracteristicas, sku, fabricante, pais_origen, grado_integracion_nacional, presentacion, disenio, acabado, forma, aspecto, etiqueta, envase, empaque, tiempo_entrega, temporalidad, documentacion_incluida, estatus_entrega, precio_unitario, unidad_minima_venta, stock, vigencia, estatus_precio, validacion_precio, validacion_administracion, validacion_tecnica, publicado, validacion_cuenta, validacion_tecnica_prueba, estatus_validacion_tec, estatus, created_at, updated_at, deleted_at) FROM stdin;
7	3	1	2431000002-07	1	BICOLOR	t	españa	españa es	1692046185E8DIlJtV.jpg	\N	\N	\N	\N	\N	t	1692046193C3qLrLD913.pdf	\N	\N	\N	t	\N	\N	\N	\N	\N	\N	\N	f	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	f	\N	\N	\N	0	f	\N	\N	\N	f	0	\N	f	f	2023-08-14 14:49:16	2023-08-14 14:49:53	\N
6	2	1	3461000002-06	1	AS	t	botella	botella de plastico	1687478859uEqja3Lt.jpg	\N	\N	\N	\N	\N	t	1687478868SyzR6pya13.pdf	\N	\N	\N	t	Fugit maxime	158sa	plastico	\N	litro	[{"el_color":"trasparente"},{"el_color":"negro"}]	[{"largo":"45","ancho":"58","alto":"69","peso":"1","unidad_largo":"1","unidad_ancho":"1","unidad_alto":"1","unidad_peso":"1"}]	t	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	45	0	[{"catalogo":false,"folletos":false,"garantia":false,"manuales":false,"otro":false}]	t	16	1	652	30	t	t	t	t	t	1	1687478987RQ7UAbjR14.pdf	t	t	2023-06-22 18:06:25	2023-06-22 18:11:06	\N
3	4	3	2111000032-03	1	BICOLOR2	t	teclado	teclados mecanicos	1684279579xmaFVeUN.png	1684279586h34TqBkZ.png	\N	\N	\N	\N	t	1684280759Nv5QrgNiCM_URG_OC.pdf	1684279732jlFH8DaaCM_URG_OC.pdf	16842807665AAC3V4OCM_URG_OC.pdf	\N	t	HP	\N	PLASTICO	\N	RECTANGULAR	[{"el_color":"negro"},{"el_color":"azul"},{"el_color":"gris"}]	[{"largo":"10","ancho":"15","alto":"20","peso":"10","unidad_largo":"1","unidad_ancho":"1","unidad_alto":"1","unidad_peso":"1"}]	t	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	1	0	[{"catalogo":false,"folletos":false,"garantia":false,"manuales":false,"otro":false}]	t	10	5	100	90	t	t	t	\N	t	2	\N	f	t	2023-05-16 17:25:44	2023-05-18 13:03:57	\N
5	5	1	3132000002-05	1	COMPRA DE AGUA TRATADA	t	agua tra	agua tratada para limpieza	1685990275Vtf6gAP7.png	\N	\N	\N	\N	\N	t	1685990283j9Vgh14T11.pdf	\N	\N	\N	t	Fugit maxime	158sa	platico	\N	galon	[{"el_color":"trasparente"}]	[{"largo":"4","ancho":"56","alto":"25","peso":"85","unidad_largo":"1","unidad_ancho":"1","unidad_alto":"1","unidad_peso":"1"}]	t	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	56	0	[{"catalogo":false,"folletos":false,"garantia":false,"manuales":false,"otro":false}]	t	35	19	1000	30	t	t	t	\N	t	1	\N	f	t	2023-06-05 12:37:30	2023-06-05 12:40:12	\N
2	1	1	5731000002-02	1	VDF	t	gallina2	gallina negra	1681505021XunzUV0K.jpg	\N	\N	\N	\N	\N	t	1681505029mIWYBPGd11.pdf	\N	\N	\N	t	LOS POLLOS HERMANOS	NISI ILLUM	ERROR	NULLA FACERE	POLLO	[{"el_color":"AMARRILLO"},{"el_color":"dfsg"},{"el_color":"dsfg"},{"el_color":"dfgg"},{"el_color":"dfg"},{"el_color":"dsfgdf"},{"el_color":"dsf"},{"el_color":"gdfs"},{"el_color":"gdfs"}]	[{"largo":"45","ancho":"68","alto":"5","peso":"36","unidad_largo":"1","unidad_ancho":"1","unidad_alto":"1","unidad_peso":"1"}]	t	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	56	0	[{"catalogo":false,"folletos":false,"garantia":false,"manuales":false,"otro":false}]	t	53	69	1000	60	t	t	t	t	t	2	1681505086Oj2HAVQQ5.pdf	t	t	2023-04-14 14:43:26	2023-06-02 16:41:51	\N
1	1	1	5731000002-01	1	VDF	t	GALLINA	GALLINA NORMAL	1682030863fn7OipGk.png	\N	\N	\N	\N	\N	t	16814989607AMQC1us4.pdf	\N	\N	\N	t	EIUSMOD	UT POSSIMUS	DOLORES DOLOR	HIC UT	POLLO	[{"el_color":"AMARRILLO"},{"el_color":"BLANCO"}]	[{"largo":"45","ancho":"12","alto":"98","peso":"2","unidad_largo":"1","unidad_ancho":"1","unidad_alto":"1","unidad_peso":"1"}]	t	ET	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	450	0	[{"catalogo":false,"folletos":false,"garantia":false,"manuales":false,"otro":false}]	t	54	56	3000	60	t	t	t	t	t	7	1681499015bACPCY3I3.pdf	t	t	2023-04-14 13:02:22	2023-07-27 17:37:01	\N
4	4	3	2111000032-04	1	BICOLOR2	t	COMPUTADORA	EQUIPOS DE COMPUTO	1682030863fn7OipGk.png	1684454865cOm9bpAM.jpeg	\N	\N	\N	\N	t	1684341782ql7JeZfoCM_URG_OC.pdf	1684341786SlyfFhavCM_URG_OC.pdf	\N	\N	t	dell	12456341	plastico	plastico	cuadrado	[{"el_color":"azul"},{"el_color":"negro"},{"el_color":"amarillo"},{"el_color":"blanco"}]	\N	t	1234567894261	dell	china	10%	rectangular	cuadrado	mate	rectangular	cuadrado	1231450	negro	carton	500	0	[{"catalogo":true,"folletos":true,"garantia":true,"manuales":true,"otro":true}]	t	10	1	100	90	t	t	t	\N	t	5	\N	f	t	2023-05-17 10:41:46	2023-05-18 18:08:41	\N
\.


--
-- Data for Name: rechazar_compras; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.rechazar_compras (id, rechazo, motivo, descripcion, proveedor_id, orden_compra_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: reportar_urgs; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.reportar_urgs (id, motivo, descripcion, etapa, urg_id, orden_compra_id, proveedor_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: requisiciones; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.requisiciones (id, requisicion, objeto_requisicion, fecha_autorizacion, monto_autorizado, monto_por_confirmar, monto_adjudicado, monto_pagado, clave_partida, urg_id, estatus, created_at, updated_at) FROM stdin;
1	1928	COMPRA DE ARTÍCULOS DE PAPELERÍA DE LA PARTIDA XXX.	2022-03-17	1000000	0	0	0	{"clave_partida":[{"clave_presupuestaria":"109C001268294P00411112022311100","partida":"2231","valor_estimado":"1000000"}]}	1	f	\N	\N
2	1930	COMPRA DE ARTÍCULOS DE LIMPIENZA	2022-03-17	900000	0	0	0	{"clave_partida":[{"clave_presupuestaria":"109E001288294O00411112022311100","partida":"2240","valor_estimado":"900000"}]}	1	f	\N	\N
\.


--
-- Data for Name: rols; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.rols (id, rol, created_at, updated_at) FROM stdin;
1	Administrador Maestro	2023-03-27 13:58:19	2023-03-27 13:58:19
2	Administrador General Responsable	2023-03-27 13:58:19	2023-03-27 13:58:19
3	Administrador General Enlace	2023-03-27 13:58:19	2023-03-27 13:58:19
4	URG Maestro	2023-03-27 13:58:19	2023-03-27 13:58:19
5	URG Enlace	2023-03-27 13:58:19	2023-03-27 13:58:19
6	Validador Tecnico	2023-03-27 13:58:19	2023-03-27 13:58:19
7	Responsable firma	2023-03-27 13:58:19	2023-03-27 13:58:19
\.


--
-- Data for Name: solicitud_compras; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.solicitud_compras (id, orden_compra, requisicion, urg, responsable, telefono, correo, extension, direccion_almacen, responsable_almacen, telefono_almacen, correo_almacen, extension_almacen, condicion_entrega, producto, orden_compra_id, urg_id, requisicion_id, usuario_id, created_at, updated_at) FROM stdin;
1	1928-1	1928	09C001 - Secretaría de Administración y Finanzas	GUILLERMO NATIVIDAD FLORES GARDUÑO	5689421589	gmo.floresg@gmail.com	4589	Lateral Río Churubusco S/N, Xoco, Benito Juárez, 03330, CDMX	david	4586897852	a@a.com	689	ok	{"producto":[{"proveedor":"INSTALACIONES Y MANTENIMIENTO EN EQUIPO DE RADIO COMUNICACI\\u00d3N SAPI DE CV","data":[{"producto":"COMPUTADORA","imagen":"1682030863fn7OipGk.png","nombre":"COMPUTADORA","cabms":"2111000032","unidad_medida":"paca","cantidad":2,"precio":"10","tamanio":"cuadrado","color":"azul","marca":"dell"},{"producto":"teclado","imagen":"1684279579xmaFVeUN.png","nombre":"teclado","cabms":"2111000032","unidad_medida":"paca","cantidad":3,"precio":"10","tamanio":"RECTANGULAR","color":"negro","marca":"HP"}]},{"proveedor":"CORPORATIVO PIARI SA DE CV","data":[{"producto":"gallina2","imagen":"1681505021XunzUV0K.jpg","nombre":"gallina2","cabms":"5731000002","unidad_medida":"equipo","cantidad":4,"precio":"53","tamanio":"POLLO","color":"AMARRILLO","marca":"LOS POLLOS HERMANOS"},{"producto":"agua tra","imagen":"1685990275Vtf6gAP7.png","nombre":"agua tra","cabms":"3132000002","unidad_medida":"litro","cantidad":5,"precio":"35","tamanio":"galon","color":"trasparente","marca":"Fugit maxime"}]}]}	1	1	1	1	2023-09-04 12:53:06	2023-09-04 12:53:06
\.


--
-- Data for Name: submenus; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.submenus (id, fecha_inicio_alta, fecha_fin_alta, alta, fecha_inicio_expediente, fecha_fin_expediente, expediente, fecha_inicio_revisor, fecha_fin_revisor, revisor, fecha_inicio_proveedor, fecha_fin_proveedor, proveedor, fecha_inicio_producto, fecha_fin_producto, producto, fecha_inicio_urg, fecha_fin_urg, urg, contrato_id, created_at, updated_at) FROM stdin;
3	\N	\N	f	\N	\N	t	\N	\N	f	\N	\N	f	\N	\N	f	\N	\N	f	3	2023-06-19 16:58:30	2023-06-19 17:01:28
2	2023-08-03	2023-08-17	f	\N	\N	t	\N	\N	t	\N	\N	t	\N	\N	t	\N	\N	t	2	2023-04-19 16:58:20	2023-08-03 16:47:08
1	2023-08-10	2023-08-18	f	\N	\N	f	\N	\N	t	\N	\N	t	\N	\N	t	\N	\N	t	1	2023-04-13 17:49:16	2023-08-07 13:33:54
4	\N	\N	f	\N	\N	f	\N	\N	f	\N	\N	f	\N	\N	f	\N	\N	f	4	2023-08-07 13:54:44	2023-08-07 13:54:44
5	\N	\N	f	\N	\N	f	\N	\N	f	\N	\N	f	\N	\N	f	\N	\N	f	5	2023-08-07 16:41:45	2023-08-07 16:41:45
6	\N	\N	f	\N	\N	f	\N	\N	f	\N	\N	f	\N	\N	f	\N	\N	f	6	2023-09-07 17:59:51	2023-09-07 17:59:51
\.


--
-- Data for Name: urgs; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.urgs (id, ccg, tipo, nombre, direccion, fecha_adhesion, archivo, validadora, estatus, created_at, updated_at) FROM stdin;
3	09C001	1	Secretaría de Administración y Finanzas	Dr. Lavista No. 144, Acceso 2, Sótano - Doctores - Cuauhtémoc - 06720 - CDMX	2023-06-16	1687559192tqFxd2yfsszfm9r13.pdf	f	t	2023-06-23 16:26:32	2023-06-23 16:26:32
1	09C001	1	Secretaría de Administración y Finanzas	Dr. Lavista No. 144, Acceso 2, Sótano - Doctores - Cuauhtémoc - 06720 - CDMX	2023-04-19	1681427310h17ugCDfeQ1ugHF2.pdf	t	t	2023-04-13 17:08:30	2023-06-28 14:30:33
2	02CD04	4	Coyoacán	Calle Coras esq. Segunda Cerrada De Nahuatlacas Manzana 117 Lote 9 - Ajusco Huayamilpas - Coyoacán - 04300 - CDMX	2023-04-20	1681427877akOM8kuMy0jerRF2.pdf	t	t	2023-04-13 17:17:57	2023-06-28 14:34:07
4	06CD05	1	Agencia de Atención Animal	Circuito Correr es Salud S/N esq. Circuito de los Compositores - 2a. Sección del Bosque de Chapultepec - Miguel Hidalgo - 11800 - CDMX	2023-06-21	1687984371Kx4epC4QGYDrJAb12.pdf	t	t	2023-06-28 14:32:51	2023-08-07 13:47:20
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.users (id, rfc, curp, nombre, primer_apellido, segundo_apellido, estatus, cargo, email, genero, password, telefono, extension, rol_id, urg_id, created_at, updated_at) FROM stdin;
4	GACJ7405239E6	GACJ740523HDFYRN00	JUAN MANUEL	GAYOSSO	DE LA CRUZ	t	TECNICO PROFESIONAL EN EDICIONES	gayosso1974@gmail.com	MASCULINO	$2y$10$2cnee54VxyWxe.NGTX5.eux/TFiaDNsmNdYd8OGTzdRRVEUjt94D.	5689421589	4589	6	2	2023-03-21 13:58:19	2023-03-21 13:58:19
3	JILA9103187I6	JILA910318HDFMPD02	JOSE ADRIAN	JIMENEZ	LOPEZ	t	JEFE DE UNIDAD DEPARTAMENTAL DE COMPRAS Y CONTROL DE MATERIALES	adrian.jimenez.df@gmail.com	MASCULINO	$2y$10$2cnee54VxyWxe.NGTX5.eux/TFiaDNsmNdYd8OGTzdRRVEUjt94D.	5689421589	4589	2	1	2023-03-21 13:58:19	2023-04-18 14:46:32
1	FOGG8510192N2	FOGG851019HDFLRL02	GUILLERMO NATIVIDAD	FLORES	GARDUÑO	t	SUBDIRECTOR DE ATENCIóN OPERATIVA	gmo.floresg@gmail.com	MASCULINO	$2y$10$2cnee54VxyWxe.NGTX5.eux/TFiaDNsmNdYd8OGTzdRRVEUjt94D.	5689421589	4589	1	1	2023-03-21 13:58:19	2023-04-21 16:59:13
2	AISJ8110279R4	HEMR690831MTCRRM00	RAMONA	HERNANDEZ	MORALES	t	DIRECTOR EJECUTIVO  B	rhm3108@gmail.com	FEMENINO	$2y$10$2cnee54VxyWxe.NGTX5.eux/TFiaDNsmNdYd8OGTzdRRVEUjt94D.	5689421589	4589	1	1	2023-03-21 13:58:19	2023-03-21 13:58:19
\.


--
-- Data for Name: validacion_administrativas; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.validacion_administrativas (id, aceptada, fecha_revision, comentario, producto_id, created_at, updated_at) FROM stdin;
1	t	2023-04-12	kbjhb	1	2023-04-14 13:54:14	2023-04-14 13:54:14
2	t	2023-04-06	sfdd	2	2023-04-14 14:58:19	2023-04-14 14:58:19
3	t	2023-05-05	s	1	2023-05-11 13:29:55	2023-05-11 13:29:55
4	t	2023-05-11	d	2	2023-05-11 13:30:27	2023-05-11 13:30:27
5	t	2023-05-05	cambio	1	2023-05-17 17:50:09	2023-05-17 17:50:09
6	t	2023-05-13	ok	3	2023-05-18 13:03:51	2023-05-18 13:03:51
7	t	2023-05-03	ok	4	2023-05-18 14:19:55	2023-05-18 14:19:55
8	t	2023-05-12	ok	4	2023-05-18 18:07:01	2023-05-18 18:07:01
9	t	2023-05-18	ok	4	2023-05-18 18:08:37	2023-05-18 18:08:37
10	t	2023-06-14	ok	5	2023-06-05 12:40:09	2023-06-05 12:40:09
11	t	2023-06-16	ok	6	2023-06-22 18:10:14	2023-06-22 18:10:14
\.


--
-- Data for Name: validacion_economicas; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.validacion_economicas (id, precio, producto_id, intento, validado, created_at, updated_at) FROM stdin;
1	55	1	1	f	2023-04-14 13:03:41	2023-04-14 13:03:41
2	55	1	2	f	2023-04-14 13:14:03	2023-04-14 13:14:03
3	55	1	3	f	2023-04-14 13:19:52	2023-04-14 13:19:52
4	55	1	4	f	2023-04-14 13:45:27	2023-04-14 13:45:27
5	54	1	5	t	2023-04-14 13:46:01	2023-04-14 13:46:01
6	54	1	6	t	2023-04-14 13:46:27	2023-04-14 13:46:27
7	53	2	1	t	2023-04-14 14:44:53	2023-04-14 14:44:53
8	10	3	1	t	2023-05-17 10:32:17	2023-05-17 10:32:17
9	10	3	2	t	2023-05-17 10:35:10	2023-05-17 10:35:10
10	500	4	1	f	2023-05-17 10:47:12	2023-05-17 10:47:12
11	10	4	2	t	2023-05-18 13:11:54	2023-05-18 13:11:54
12	10	4	3	t	2023-05-18 14:18:16	2023-05-18 14:18:16
13	10	4	4	t	2023-05-18 18:06:23	2023-05-18 18:06:23
14	10	4	5	t	2023-05-18 18:07:59	2023-05-18 18:07:59
15	53	2	2	t	2023-06-02 16:41:51	2023-06-02 16:41:51
16	54	1	7	t	2023-06-02 16:43:59	2023-06-02 16:43:59
17	35	5	1	t	2023-06-05 12:39:36	2023-06-05 12:39:36
18	16	6	1	t	2023-06-22 18:09:57	2023-06-22 18:09:57
\.


--
-- Data for Name: validaciones_tecnicas; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.validaciones_tecnicas (id, direccion, siglas, estatus, urg_id, created_at, updated_at) FROM stdin;
1	direccion	dgtc	t	1	2023-04-13 17:17:27	2023-06-28 14:30:33
2	Culpa explicabo Sae	cy	t	2	2023-04-13 17:18:10	2023-06-28 14:34:07
3	\N	\N	t	4	2023-06-28 14:32:51	2023-08-07 13:47:20
\.


--
-- Data for Name: validador_tecnicos; Type: TABLE DATA; Schema: public; Owner: david
--

COPY public.validador_tecnicos (id, aceptada, fecha_revision, comentario, producto_id, created_at, updated_at) FROM stdin;
1	t	2023-04-12	dsd	1	2023-04-14 14:07:13	2023-04-14 14:07:13
2	f	2023-04-08	dsd	2	2023-04-17 11:36:19	2023-04-17 11:36:19
3	t	2023-05-05	s	1	2023-05-11 13:30:39	2023-05-11 13:30:39
4	t	2023-05-11	s	2	2023-05-11 13:30:55	2023-05-11 13:30:55
5	t	2023-06-08	ok	6	2023-06-22 18:10:44	2023-06-22 18:10:44
\.


--
-- Name: adjudicacion_directas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.adjudicacion_directas_id_seq', 3, true);


--
-- Name: anexos_adjudicacions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.anexos_adjudicacions_id_seq', 6, true);


--
-- Name: anexos_contratos_marcos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.anexos_contratos_marcos_id_seq', 1, true);


--
-- Name: anexos_publicas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.anexos_publicas_id_seq', 4, true);


--
-- Name: anexos_restringidas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.anexos_restringidas_id_seq', 1, false);


--
-- Name: bien_servicios_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.bien_servicios_id_seq', 1, false);


--
-- Name: cancelar_compras_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.cancelar_compras_id_seq', 1, true);


--
-- Name: carritos_compras_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.carritos_compras_id_seq', 8, true);


--
-- Name: cat_productos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.cat_productos_id_seq', 5, true);


--
-- Name: contratos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.contratos_id_seq', 1, true);


--
-- Name: contratos_marcos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.contratos_marcos_id_seq', 6, true);


--
-- Name: contratos_marcos_urgs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.contratos_marcos_urgs_id_seq', 3, true);


--
-- Name: expedientes_contratos_marcos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.expedientes_contratos_marcos_id_seq', 9, true);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: grupo_revisors_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.grupo_revisors_id_seq', 3, true);


--
-- Name: habilitar_productos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.habilitar_productos_id_seq', 5, true);


--
-- Name: habilitar_proveedores_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.habilitar_proveedores_id_seq', 13, true);


--
-- Name: incidencia_urgs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.incidencia_urgs_id_seq', 1, false);


--
-- Name: invitacion_restringidas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.invitacion_restringidas_id_seq', 1, false);


--
-- Name: licitacion_publicas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.licitacion_publicas_id_seq', 3, true);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.migrations_id_seq', 456, true);


--
-- Name: orden_compra_biens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.orden_compra_biens_id_seq', 4, true);


--
-- Name: orden_compra_envios_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.orden_compra_envios_id_seq', 1, false);


--
-- Name: orden_compra_estatuses_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.orden_compra_estatuses_id_seq', 2, true);


--
-- Name: orden_compra_firmas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.orden_compra_firmas_id_seq', 4, true);


--
-- Name: orden_compra_prorrogas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.orden_compra_prorrogas_id_seq', 1, false);


--
-- Name: orden_compra_proveedors_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.orden_compra_proveedors_id_seq', 2, true);


--
-- Name: orden_compras_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.orden_compras_id_seq', 1, true);


--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 1, false);


--
-- Name: productos_favoritos_urg_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.productos_favoritos_urg_id_seq', 1, true);


--
-- Name: productos_preguntas_respuestas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.productos_preguntas_respuestas_id_seq', 2, true);


--
-- Name: proveedores_fichas_productos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.proveedores_fichas_productos_id_seq', 7, true);


--
-- Name: proveedores_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.proveedores_id_seq', 10, true);


--
-- Name: rechazar_compras_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.rechazar_compras_id_seq', 1, false);


--
-- Name: reportar_urgs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.reportar_urgs_id_seq', 1, false);


--
-- Name: requisiciones_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.requisiciones_id_seq', 1, false);


--
-- Name: rols_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.rols_id_seq', 1, false);


--
-- Name: solicitud_compras_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.solicitud_compras_id_seq', 1, true);


--
-- Name: submenus_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.submenus_id_seq', 6, true);


--
-- Name: urgs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.urgs_id_seq', 4, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.users_id_seq', 1, false);


--
-- Name: validacion_administrativas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.validacion_administrativas_id_seq', 11, true);


--
-- Name: validacion_economicas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.validacion_economicas_id_seq', 18, true);


--
-- Name: validaciones_tecnicas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.validaciones_tecnicas_id_seq', 3, true);


--
-- Name: validador_tecnicos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: david
--

SELECT pg_catalog.setval('public.validador_tecnicos_id_seq', 5, true);


--
-- Name: adjudicacion_directas adjudicacion_directas_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.adjudicacion_directas
    ADD CONSTRAINT adjudicacion_directas_pkey PRIMARY KEY (id);


--
-- Name: anexos_adjudicacions anexos_adjudicacions_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.anexos_adjudicacions
    ADD CONSTRAINT anexos_adjudicacions_pkey PRIMARY KEY (id);


--
-- Name: anexos_contratos_marcos anexos_contratos_marcos_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.anexos_contratos_marcos
    ADD CONSTRAINT anexos_contratos_marcos_pkey PRIMARY KEY (id);


--
-- Name: anexos_publicas anexos_publicas_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.anexos_publicas
    ADD CONSTRAINT anexos_publicas_pkey PRIMARY KEY (id);


--
-- Name: anexos_restringidas anexos_restringidas_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.anexos_restringidas
    ADD CONSTRAINT anexos_restringidas_pkey PRIMARY KEY (id);


--
-- Name: bien_servicios bien_servicios_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.bien_servicios
    ADD CONSTRAINT bien_servicios_pkey PRIMARY KEY (id);


--
-- Name: cancelar_compras cancelar_compras_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.cancelar_compras
    ADD CONSTRAINT cancelar_compras_pkey PRIMARY KEY (id);


--
-- Name: carritos_compras carritos_compras_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.carritos_compras
    ADD CONSTRAINT carritos_compras_pkey PRIMARY KEY (id);


--
-- Name: cat_productos cat_productos_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.cat_productos
    ADD CONSTRAINT cat_productos_pkey PRIMARY KEY (id);


--
-- Name: contratos_marcos contratos_marcos_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.contratos_marcos
    ADD CONSTRAINT contratos_marcos_pkey PRIMARY KEY (id);


--
-- Name: contratos_marcos_urgs contratos_marcos_urgs_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.contratos_marcos_urgs
    ADD CONSTRAINT contratos_marcos_urgs_pkey PRIMARY KEY (id);


--
-- Name: contratos contratos_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.contratos
    ADD CONSTRAINT contratos_pkey PRIMARY KEY (id);


--
-- Name: expedientes_contratos_marcos expedientes_contratos_marcos_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.expedientes_contratos_marcos
    ADD CONSTRAINT expedientes_contratos_marcos_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: grupo_revisors grupo_revisors_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.grupo_revisors
    ADD CONSTRAINT grupo_revisors_pkey PRIMARY KEY (id);


--
-- Name: habilitar_productos habilitar_productos_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.habilitar_productos
    ADD CONSTRAINT habilitar_productos_pkey PRIMARY KEY (id);


--
-- Name: habilitar_proveedores habilitar_proveedores_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.habilitar_proveedores
    ADD CONSTRAINT habilitar_proveedores_pkey PRIMARY KEY (id);


--
-- Name: incidencia_urgs incidencia_urgs_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.incidencia_urgs
    ADD CONSTRAINT incidencia_urgs_pkey PRIMARY KEY (id);


--
-- Name: invitacion_restringidas invitacion_restringidas_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.invitacion_restringidas
    ADD CONSTRAINT invitacion_restringidas_pkey PRIMARY KEY (id);


--
-- Name: licitacion_publicas licitacion_publicas_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.licitacion_publicas
    ADD CONSTRAINT licitacion_publicas_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: orden_compra_biens orden_compra_biens_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_biens
    ADD CONSTRAINT orden_compra_biens_pkey PRIMARY KEY (id);


--
-- Name: orden_compra_envios orden_compra_envios_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_envios
    ADD CONSTRAINT orden_compra_envios_pkey PRIMARY KEY (id);


--
-- Name: orden_compra_estatuses orden_compra_estatuses_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_estatuses
    ADD CONSTRAINT orden_compra_estatuses_pkey PRIMARY KEY (id);


--
-- Name: orden_compra_firmas orden_compra_firmas_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_firmas
    ADD CONSTRAINT orden_compra_firmas_pkey PRIMARY KEY (id);


--
-- Name: orden_compra_prorrogas orden_compra_prorrogas_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_prorrogas
    ADD CONSTRAINT orden_compra_prorrogas_pkey PRIMARY KEY (id);


--
-- Name: orden_compra_proveedors orden_compra_proveedors_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_proveedors
    ADD CONSTRAINT orden_compra_proveedors_pkey PRIMARY KEY (id);


--
-- Name: orden_compras orden_compras_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compras
    ADD CONSTRAINT orden_compras_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_token_unique; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);


--
-- Name: productos_favoritos_urg productos_favoritos_urg_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.productos_favoritos_urg
    ADD CONSTRAINT productos_favoritos_urg_pkey PRIMARY KEY (id);


--
-- Name: productos_preguntas_respuestas productos_preguntas_respuestas_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.productos_preguntas_respuestas
    ADD CONSTRAINT productos_preguntas_respuestas_pkey PRIMARY KEY (id);


--
-- Name: proveedores_fichas_productos proveedores_fichas_productos_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.proveedores_fichas_productos
    ADD CONSTRAINT proveedores_fichas_productos_pkey PRIMARY KEY (id);


--
-- Name: proveedores proveedores_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.proveedores
    ADD CONSTRAINT proveedores_pkey PRIMARY KEY (id);


--
-- Name: proveedores proveedores_rfc_unique; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.proveedores
    ADD CONSTRAINT proveedores_rfc_unique UNIQUE (rfc);


--
-- Name: rechazar_compras rechazar_compras_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.rechazar_compras
    ADD CONSTRAINT rechazar_compras_pkey PRIMARY KEY (id);


--
-- Name: reportar_urgs reportar_urgs_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.reportar_urgs
    ADD CONSTRAINT reportar_urgs_pkey PRIMARY KEY (id);


--
-- Name: requisiciones requisiciones_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.requisiciones
    ADD CONSTRAINT requisiciones_pkey PRIMARY KEY (id);


--
-- Name: rols rols_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.rols
    ADD CONSTRAINT rols_pkey PRIMARY KEY (id);


--
-- Name: solicitud_compras solicitud_compras_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.solicitud_compras
    ADD CONSTRAINT solicitud_compras_pkey PRIMARY KEY (id);


--
-- Name: submenus submenus_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.submenus
    ADD CONSTRAINT submenus_pkey PRIMARY KEY (id);


--
-- Name: urgs urgs_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.urgs
    ADD CONSTRAINT urgs_pkey PRIMARY KEY (id);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: users users_rfc_unique; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_rfc_unique UNIQUE (rfc);


--
-- Name: validacion_administrativas validacion_administrativas_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.validacion_administrativas
    ADD CONSTRAINT validacion_administrativas_pkey PRIMARY KEY (id);


--
-- Name: validacion_economicas validacion_economicas_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.validacion_economicas
    ADD CONSTRAINT validacion_economicas_pkey PRIMARY KEY (id);


--
-- Name: validaciones_tecnicas validaciones_tecnicas_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.validaciones_tecnicas
    ADD CONSTRAINT validaciones_tecnicas_pkey PRIMARY KEY (id);


--
-- Name: validador_tecnicos validador_tecnicos_pkey; Type: CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.validador_tecnicos
    ADD CONSTRAINT validador_tecnicos_pkey PRIMARY KEY (id);


--
-- Name: password_resets_email_index; Type: INDEX; Schema: public; Owner: david
--

CREATE INDEX password_resets_email_index ON public.password_resets USING btree (email);


--
-- Name: personal_access_tokens_tokenable_type_tokenable_id_index; Type: INDEX; Schema: public; Owner: david
--

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);


--
-- Name: adjudicacion_directas adjudicacion_directas_expediente_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.adjudicacion_directas
    ADD CONSTRAINT adjudicacion_directas_expediente_id_foreign FOREIGN KEY (expediente_id) REFERENCES public.expedientes_contratos_marcos(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: anexos_adjudicacions anexos_adjudicacions_adjudicacion_directa_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.anexos_adjudicacions
    ADD CONSTRAINT anexos_adjudicacions_adjudicacion_directa_id_foreign FOREIGN KEY (adjudicacion_directa_id) REFERENCES public.adjudicacion_directas(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: anexos_publicas anexos_publicas_licitacion_publica_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.anexos_publicas
    ADD CONSTRAINT anexos_publicas_licitacion_publica_id_foreign FOREIGN KEY (licitacion_publica_id) REFERENCES public.licitacion_publicas(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: anexos_restringidas anexos_restringidas_invitacion_restringida_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.anexos_restringidas
    ADD CONSTRAINT anexos_restringidas_invitacion_restringida_id_foreign FOREIGN KEY (invitacion_restringida_id) REFERENCES public.invitacion_restringidas(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: bien_servicios bien_servicios_requisicion_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.bien_servicios
    ADD CONSTRAINT bien_servicios_requisicion_id_foreign FOREIGN KEY (requisicion_id) REFERENCES public.requisiciones(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: cancelar_compras cancelar_compras_orden_compra_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.cancelar_compras
    ADD CONSTRAINT cancelar_compras_orden_compra_id_foreign FOREIGN KEY (orden_compra_id) REFERENCES public.orden_compras(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: cancelar_compras cancelar_compras_proveedor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.cancelar_compras
    ADD CONSTRAINT cancelar_compras_proveedor_id_foreign FOREIGN KEY (proveedor_id) REFERENCES public.proveedores(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: cancelar_compras cancelar_compras_urg_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.cancelar_compras
    ADD CONSTRAINT cancelar_compras_urg_id_foreign FOREIGN KEY (urg_id) REFERENCES public.urgs(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: cancelar_compras cancelar_compras_usuario_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.cancelar_compras
    ADD CONSTRAINT cancelar_compras_usuario_id_foreign FOREIGN KEY (usuario_id) REFERENCES public.users(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: carritos_compras carritos_compras_proveedor_ficha_producto_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.carritos_compras
    ADD CONSTRAINT carritos_compras_proveedor_ficha_producto_id_foreign FOREIGN KEY (proveedor_ficha_producto_id) REFERENCES public.proveedores_fichas_productos(id) ON DELETE SET NULL;


--
-- Name: carritos_compras carritos_compras_requisicion_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.carritos_compras
    ADD CONSTRAINT carritos_compras_requisicion_id_foreign FOREIGN KEY (requisicion_id) REFERENCES public.requisiciones(id) ON DELETE SET NULL;


--
-- Name: cat_productos cat_productos_contrato_marco_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.cat_productos
    ADD CONSTRAINT cat_productos_contrato_marco_id_foreign FOREIGN KEY (contrato_marco_id) REFERENCES public.contratos_marcos(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: cat_productos cat_productos_validacion_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.cat_productos
    ADD CONSTRAINT cat_productos_validacion_id_foreign FOREIGN KEY (validacion_id) REFERENCES public.validaciones_tecnicas(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: contratos_marcos contratos_marcos_urg_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.contratos_marcos
    ADD CONSTRAINT contratos_marcos_urg_id_foreign FOREIGN KEY (urg_id) REFERENCES public.urgs(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: contratos_marcos_urgs contratos_marcos_urgs_contrato_marco_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.contratos_marcos_urgs
    ADD CONSTRAINT contratos_marcos_urgs_contrato_marco_id_foreign FOREIGN KEY (contrato_marco_id) REFERENCES public.contratos_marcos(id) ON DELETE SET NULL;


--
-- Name: contratos_marcos_urgs contratos_marcos_urgs_urg_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.contratos_marcos_urgs
    ADD CONSTRAINT contratos_marcos_urgs_urg_id_foreign FOREIGN KEY (urg_id) REFERENCES public.urgs(id) ON DELETE SET NULL;


--
-- Name: contratos_marcos contratos_marcos_user_id_responsable_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.contratos_marcos
    ADD CONSTRAINT contratos_marcos_user_id_responsable_foreign FOREIGN KEY (user_id_responsable) REFERENCES public.users(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: contratos contratos_orden_compra_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.contratos
    ADD CONSTRAINT contratos_orden_compra_id_foreign FOREIGN KEY (orden_compra_id) REFERENCES public.orden_compras(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: contratos contratos_proveedor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.contratos
    ADD CONSTRAINT contratos_proveedor_id_foreign FOREIGN KEY (proveedor_id) REFERENCES public.proveedores(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: contratos contratos_urg_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.contratos
    ADD CONSTRAINT contratos_urg_id_foreign FOREIGN KEY (urg_id) REFERENCES public.urgs(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: expedientes_contratos_marcos expedientes_contratos_marcos_contrato_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.expedientes_contratos_marcos
    ADD CONSTRAINT expedientes_contratos_marcos_contrato_id_foreign FOREIGN KEY (contrato_id) REFERENCES public.contratos_marcos(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: grupo_revisors grupo_revisors_contrato_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.grupo_revisors
    ADD CONSTRAINT grupo_revisors_contrato_id_foreign FOREIGN KEY (contrato_id) REFERENCES public.contratos_marcos(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: habilitar_productos habilitar_productos_cat_producto_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.habilitar_productos
    ADD CONSTRAINT habilitar_productos_cat_producto_id_foreign FOREIGN KEY (cat_producto_id) REFERENCES public.cat_productos(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: habilitar_productos habilitar_productos_grupo_revisor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.habilitar_productos
    ADD CONSTRAINT habilitar_productos_grupo_revisor_id_foreign FOREIGN KEY (grupo_revisor_id) REFERENCES public.grupo_revisors(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: habilitar_proveedores habilitar_proveedores_contrato_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.habilitar_proveedores
    ADD CONSTRAINT habilitar_proveedores_contrato_id_foreign FOREIGN KEY (contrato_id) REFERENCES public.contratos_marcos(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: habilitar_proveedores habilitar_proveedores_expediente_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.habilitar_proveedores
    ADD CONSTRAINT habilitar_proveedores_expediente_id_foreign FOREIGN KEY (expediente_id) REFERENCES public.expedientes_contratos_marcos(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: habilitar_proveedores habilitar_proveedores_proveedor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.habilitar_proveedores
    ADD CONSTRAINT habilitar_proveedores_proveedor_id_foreign FOREIGN KEY (proveedor_id) REFERENCES public.proveedores(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: incidencia_urgs incidencia_urgs_orden_compra_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.incidencia_urgs
    ADD CONSTRAINT incidencia_urgs_orden_compra_id_foreign FOREIGN KEY (orden_compra_id) REFERENCES public.orden_compras(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: incidencia_urgs incidencia_urgs_proveedor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.incidencia_urgs
    ADD CONSTRAINT incidencia_urgs_proveedor_id_foreign FOREIGN KEY (proveedor_id) REFERENCES public.proveedores(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: incidencia_urgs incidencia_urgs_urg_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.incidencia_urgs
    ADD CONSTRAINT incidencia_urgs_urg_id_foreign FOREIGN KEY (urg_id) REFERENCES public.urgs(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: invitacion_restringidas invitacion_restringidas_expediente_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.invitacion_restringidas
    ADD CONSTRAINT invitacion_restringidas_expediente_id_foreign FOREIGN KEY (expediente_id) REFERENCES public.expedientes_contratos_marcos(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: licitacion_publicas licitacion_publicas_expediente_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.licitacion_publicas
    ADD CONSTRAINT licitacion_publicas_expediente_id_foreign FOREIGN KEY (expediente_id) REFERENCES public.expedientes_contratos_marcos(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: orden_compra_biens orden_compra_biens_orden_compra_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_biens
    ADD CONSTRAINT orden_compra_biens_orden_compra_id_foreign FOREIGN KEY (orden_compra_id) REFERENCES public.orden_compras(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: orden_compra_biens orden_compra_biens_proveedor_ficha_producto_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_biens
    ADD CONSTRAINT orden_compra_biens_proveedor_ficha_producto_id_foreign FOREIGN KEY (proveedor_ficha_producto_id) REFERENCES public.proveedores_fichas_productos(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: orden_compra_biens orden_compra_biens_proveedor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_biens
    ADD CONSTRAINT orden_compra_biens_proveedor_id_foreign FOREIGN KEY (proveedor_id) REFERENCES public.proveedores(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: orden_compra_biens orden_compra_biens_requisicion_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_biens
    ADD CONSTRAINT orden_compra_biens_requisicion_id_foreign FOREIGN KEY (requisicion_id) REFERENCES public.requisiciones(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: orden_compra_biens orden_compra_biens_urg_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_biens
    ADD CONSTRAINT orden_compra_biens_urg_id_foreign FOREIGN KEY (urg_id) REFERENCES public.urgs(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: orden_compra_envios orden_compra_envios_orden_compra_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_envios
    ADD CONSTRAINT orden_compra_envios_orden_compra_id_foreign FOREIGN KEY (orden_compra_id) REFERENCES public.orden_compras(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: orden_compra_envios orden_compra_envios_proveedor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_envios
    ADD CONSTRAINT orden_compra_envios_proveedor_id_foreign FOREIGN KEY (proveedor_id) REFERENCES public.proveedores(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: orden_compra_envios orden_compra_envios_urg_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_envios
    ADD CONSTRAINT orden_compra_envios_urg_id_foreign FOREIGN KEY (urg_id) REFERENCES public.urgs(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: orden_compra_estatuses orden_compra_estatuses_orden_compra_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_estatuses
    ADD CONSTRAINT orden_compra_estatuses_orden_compra_id_foreign FOREIGN KEY (orden_compra_id) REFERENCES public.orden_compras(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: orden_compra_estatuses orden_compra_estatuses_proveedor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_estatuses
    ADD CONSTRAINT orden_compra_estatuses_proveedor_id_foreign FOREIGN KEY (proveedor_id) REFERENCES public.proveedores(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: orden_compra_estatuses orden_compra_estatuses_urg_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_estatuses
    ADD CONSTRAINT orden_compra_estatuses_urg_id_foreign FOREIGN KEY (urg_id) REFERENCES public.urgs(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: orden_compra_firmas orden_compra_firmas_contrato_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_firmas
    ADD CONSTRAINT orden_compra_firmas_contrato_id_foreign FOREIGN KEY (contrato_id) REFERENCES public.contratos(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: orden_compra_prorrogas orden_compra_prorrogas_orden_compra_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_prorrogas
    ADD CONSTRAINT orden_compra_prorrogas_orden_compra_id_foreign FOREIGN KEY (orden_compra_id) REFERENCES public.orden_compras(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: orden_compra_prorrogas orden_compra_prorrogas_proveedor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_prorrogas
    ADD CONSTRAINT orden_compra_prorrogas_proveedor_id_foreign FOREIGN KEY (proveedor_id) REFERENCES public.proveedores(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: orden_compra_prorrogas orden_compra_prorrogas_urg_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_prorrogas
    ADD CONSTRAINT orden_compra_prorrogas_urg_id_foreign FOREIGN KEY (urg_id) REFERENCES public.urgs(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: orden_compra_proveedors orden_compra_proveedors_orden_compra_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_proveedors
    ADD CONSTRAINT orden_compra_proveedors_orden_compra_id_foreign FOREIGN KEY (orden_compra_id) REFERENCES public.orden_compras(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: orden_compra_proveedors orden_compra_proveedors_proveedor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_proveedors
    ADD CONSTRAINT orden_compra_proveedors_proveedor_id_foreign FOREIGN KEY (proveedor_id) REFERENCES public.proveedores(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: orden_compra_proveedors orden_compra_proveedors_urg_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compra_proveedors
    ADD CONSTRAINT orden_compra_proveedors_urg_id_foreign FOREIGN KEY (urg_id) REFERENCES public.urgs(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: orden_compras orden_compras_requisicion_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compras
    ADD CONSTRAINT orden_compras_requisicion_id_foreign FOREIGN KEY (requisicion_id) REFERENCES public.requisiciones(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: orden_compras orden_compras_urg_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compras
    ADD CONSTRAINT orden_compras_urg_id_foreign FOREIGN KEY (urg_id) REFERENCES public.urgs(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: orden_compras orden_compras_usuario_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.orden_compras
    ADD CONSTRAINT orden_compras_usuario_id_foreign FOREIGN KEY (usuario_id) REFERENCES public.users(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: productos_favoritos_urg productos_favoritos_urg_proveedor_ficha_producto_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.productos_favoritos_urg
    ADD CONSTRAINT productos_favoritos_urg_proveedor_ficha_producto_id_foreign FOREIGN KEY (proveedor_ficha_producto_id) REFERENCES public.proveedores_fichas_productos(id) ON DELETE SET NULL;


--
-- Name: productos_favoritos_urg productos_favoritos_urg_urg_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.productos_favoritos_urg
    ADD CONSTRAINT productos_favoritos_urg_urg_id_foreign FOREIGN KEY (urg_id) REFERENCES public.urgs(id) ON DELETE SET NULL;


--
-- Name: productos_preguntas_respuestas productos_preguntas_respuestas_proveedor_ficha_producto_id_fore; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.productos_preguntas_respuestas
    ADD CONSTRAINT productos_preguntas_respuestas_proveedor_ficha_producto_id_fore FOREIGN KEY (proveedor_ficha_producto_id) REFERENCES public.proveedores_fichas_productos(id) ON DELETE SET NULL;


--
-- Name: productos_preguntas_respuestas productos_preguntas_respuestas_urg_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.productos_preguntas_respuestas
    ADD CONSTRAINT productos_preguntas_respuestas_urg_id_foreign FOREIGN KEY (urg_id) REFERENCES public.urgs(id) ON DELETE SET NULL;


--
-- Name: proveedores_fichas_productos proveedores_fichas_productos_producto_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.proveedores_fichas_productos
    ADD CONSTRAINT proveedores_fichas_productos_producto_id_foreign FOREIGN KEY (producto_id) REFERENCES public.cat_productos(id) ON DELETE SET NULL;


--
-- Name: proveedores_fichas_productos proveedores_fichas_productos_proveedor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.proveedores_fichas_productos
    ADD CONSTRAINT proveedores_fichas_productos_proveedor_id_foreign FOREIGN KEY (proveedor_id) REFERENCES public.proveedores(id) ON DELETE SET NULL;


--
-- Name: rechazar_compras rechazar_compras_orden_compra_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.rechazar_compras
    ADD CONSTRAINT rechazar_compras_orden_compra_id_foreign FOREIGN KEY (orden_compra_id) REFERENCES public.orden_compras(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: rechazar_compras rechazar_compras_proveedor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.rechazar_compras
    ADD CONSTRAINT rechazar_compras_proveedor_id_foreign FOREIGN KEY (proveedor_id) REFERENCES public.proveedores(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: reportar_urgs reportar_urgs_orden_compra_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.reportar_urgs
    ADD CONSTRAINT reportar_urgs_orden_compra_id_foreign FOREIGN KEY (orden_compra_id) REFERENCES public.orden_compras(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: reportar_urgs reportar_urgs_proveedor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.reportar_urgs
    ADD CONSTRAINT reportar_urgs_proveedor_id_foreign FOREIGN KEY (proveedor_id) REFERENCES public.proveedores(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: reportar_urgs reportar_urgs_urg_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.reportar_urgs
    ADD CONSTRAINT reportar_urgs_urg_id_foreign FOREIGN KEY (urg_id) REFERENCES public.urgs(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: requisiciones requisiciones_urg_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.requisiciones
    ADD CONSTRAINT requisiciones_urg_id_foreign FOREIGN KEY (urg_id) REFERENCES public.urgs(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: solicitud_compras solicitud_compras_orden_compra_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.solicitud_compras
    ADD CONSTRAINT solicitud_compras_orden_compra_id_foreign FOREIGN KEY (orden_compra_id) REFERENCES public.orden_compras(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: solicitud_compras solicitud_compras_requisicion_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.solicitud_compras
    ADD CONSTRAINT solicitud_compras_requisicion_id_foreign FOREIGN KEY (requisicion_id) REFERENCES public.requisiciones(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: solicitud_compras solicitud_compras_urg_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.solicitud_compras
    ADD CONSTRAINT solicitud_compras_urg_id_foreign FOREIGN KEY (urg_id) REFERENCES public.urgs(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: solicitud_compras solicitud_compras_usuario_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.solicitud_compras
    ADD CONSTRAINT solicitud_compras_usuario_id_foreign FOREIGN KEY (usuario_id) REFERENCES public.users(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: submenus submenus_contrato_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.submenus
    ADD CONSTRAINT submenus_contrato_id_foreign FOREIGN KEY (contrato_id) REFERENCES public.contratos_marcos(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: users users_rol_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_rol_id_foreign FOREIGN KEY (rol_id) REFERENCES public.rols(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: users users_urg_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_urg_id_foreign FOREIGN KEY (urg_id) REFERENCES public.urgs(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: validacion_administrativas validacion_administrativas_producto_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.validacion_administrativas
    ADD CONSTRAINT validacion_administrativas_producto_id_foreign FOREIGN KEY (producto_id) REFERENCES public.proveedores_fichas_productos(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: validacion_economicas validacion_economicas_producto_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.validacion_economicas
    ADD CONSTRAINT validacion_economicas_producto_id_foreign FOREIGN KEY (producto_id) REFERENCES public.proveedores_fichas_productos(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: validaciones_tecnicas validaciones_tecnicas_urg_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.validaciones_tecnicas
    ADD CONSTRAINT validaciones_tecnicas_urg_id_foreign FOREIGN KEY (urg_id) REFERENCES public.urgs(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: validador_tecnicos validador_tecnicos_producto_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: david
--

ALTER TABLE ONLY public.validador_tecnicos
    ADD CONSTRAINT validador_tecnicos_producto_id_foreign FOREIGN KEY (producto_id) REFERENCES public.proveedores_fichas_productos(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- PostgreSQL database dump complete
--

