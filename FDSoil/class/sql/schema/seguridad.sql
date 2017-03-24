--
-- PostgreSQL database dump
--

-- Started on 2012-09-27 13:06:03 VET

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- TOC entry 15 (class 2615 OID 23812819)
-- Name: seguridad; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA seguridad;


ALTER SCHEMA seguridad OWNER TO postgres;

SET search_path = seguridad, pg_catalog;

--
-- TOC entry 354 (class 1255 OID 23812820)
-- Dependencies: 15 945
-- Name: menu_0_delete(integer); Type: FUNCTION; Schema: seguridad; Owner: postgres
--

CREATE FUNCTION menu_0_delete(i_id integer) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE   
	o_return integer;
	v_existe boolean;
BEGIN
	o_return:=0;

	SELECT CASE WHEN count(id_menu_0)=0 THEN false ELSE true END INTO v_existe FROM menu_rol.menu_1 WHERE id_menu_0=i_id;
	IF v_existe='f' THEN
		DELETE FROM menu_rol.menu_0 WHERE id=i_id;
		o_return:=2;
	ELSE
		o_return:=97;
	END IF;
	
	
	RETURN o_return;  
END;
$$;


ALTER FUNCTION seguridad.menu_0_delete(i_id integer) OWNER TO postgres;

--
-- TOC entry 355 (class 1255 OID 23812821)
-- Dependencies: 945 15
-- Name: menu_0_registrar(character varying, character varying, character varying, integer, integer); Type: FUNCTION; Schema: seguridad; Owner: postgres
--

CREATE FUNCTION menu_0_registrar(i_id character varying, i_opcion character varying, i_ruta character varying, i_orden integer, i_id_status integer) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE   
	o_return integer;
	v_existe boolean;
BEGIN
	o_return:=0;
	IF  i_id='' THEN 
		SELECT CASE WHEN count(titulo)=0 THEN false ELSE true END INTO v_existe FROM menu_rol.menu_0 WHERE titulo=i_opcion;
		IF v_existe='f' THEN	
			INSERT INTO menu_rol.menu_0(titulo, ruta, orden, id_status) 
			VALUES (i_opcion, i_ruta, i_orden, i_id_status);
			o_return:=3; 
		ELSE
			o_return:=98;
		END IF;
	ELSE
		SELECT CASE WHEN count(id)=0 THEN false ELSE true END INTO v_existe 
		FROM menu_rol.menu_0 WHERE id=CAST(i_id AS integer);
		IF v_existe='t' THEN
			UPDATE menu_rol.menu_0 
			SET titulo=i_opcion, ruta=i_ruta, orden=i_orden, id_status=i_id_status 
			WHERE id = CAST(i_id AS integer);
			o_return:=1;	
		ELSE
			o_return:=96;
		END IF;		
	END IF;
	RETURN o_return;  
END;
$$;


ALTER FUNCTION seguridad.menu_0_registrar(i_id character varying, i_opcion character varying, i_ruta character varying, i_orden integer, i_id_status integer) OWNER TO postgres;

--
-- TOC entry 356 (class 1255 OID 23812822)
-- Dependencies: 945 15
-- Name: menu_1_delete(integer); Type: FUNCTION; Schema: seguridad; Owner: postgres
--

CREATE FUNCTION menu_1_delete(i_id integer) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE   
	o_return integer;
	v_existe boolean;
BEGIN
	o_return:=0;

	SELECT CASE WHEN count(id_menu_1)=0 THEN false ELSE true END INTO v_existe FROM menu_rol.menu_2 WHERE id_menu_1=i_id;
	IF v_existe='f' THEN
		DELETE FROM menu_rol.menu_1 WHERE id=i_id;
		o_return:=2;
	ELSE
		o_return:=97;
	END IF;
	
	
	RETURN o_return;  
END;
$$;


ALTER FUNCTION seguridad.menu_1_delete(i_id integer) OWNER TO postgres;

--
-- TOC entry 357 (class 1255 OID 23812823)
-- Dependencies: 945 15
-- Name: menu_1_registrar(integer, character varying, character varying, character varying, integer, integer); Type: FUNCTION; Schema: seguridad; Owner: postgres
--

CREATE FUNCTION menu_1_registrar(id_n0 integer, i_id character varying, i_opcion character varying, i_ruta character varying, i_orden integer, i_id_status integer) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE   
	o_return integer;
	v_existe boolean;
BEGIN
	o_return:=0;
	IF  i_id='' THEN 
		SELECT CASE WHEN count(titulo)=0 THEN false ELSE true END INTO v_existe FROM menu_rol.menu_1 WHERE titulo=i_opcion;
		IF v_existe='f' THEN	
			INSERT INTO menu_rol.menu_1(id_menu_0, titulo, ruta, orden, id_status) 
			VALUES (id_n0, i_opcion, i_ruta, i_orden, i_id_status);
			o_return:=3; 
		ELSE
			o_return:=98;
		END IF;
	ELSE
		SELECT CASE WHEN count(id)=0 THEN false ELSE true END INTO v_existe 
		FROM menu_rol.menu_1 WHERE id=CAST(i_id AS integer);
		IF v_existe='t' THEN
			UPDATE menu_rol.menu_1 
			SET id_menu_0=id_n0, titulo=i_opcion, ruta=i_ruta, orden=i_orden, id_status=i_id_status 
			WHERE id = CAST(i_id AS integer);
			o_return:=1;	
		ELSE
			o_return:=96;
		END IF;		
	END IF;
	RETURN o_return;  
END;
$$;


ALTER FUNCTION seguridad.menu_1_registrar(id_n0 integer, i_id character varying, i_opcion character varying, i_ruta character varying, i_orden integer, i_id_status integer) OWNER TO postgres;

--
-- TOC entry 358 (class 1255 OID 23812824)
-- Dependencies: 945 15
-- Name: menu_2_delete(integer); Type: FUNCTION; Schema: seguridad; Owner: postgres
--

CREATE FUNCTION menu_2_delete(i_id integer) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE   
	o_return integer;
	v_existe boolean;
BEGIN
	o_return:=0;

	SELECT CASE WHEN count(id_menu_2)=0 THEN false ELSE true END INTO v_existe FROM menu_rol.menu_3 WHERE id_menu_2=i_id;
	IF v_existe='f' THEN
		DELETE FROM menu_rol.menu_2 WHERE id=i_id;
		o_return:=2;
	ELSE
		o_return:=97;
	END IF;
	
	
	RETURN o_return;  
END;
$$;


ALTER FUNCTION seguridad.menu_2_delete(i_id integer) OWNER TO postgres;

--
-- TOC entry 359 (class 1255 OID 23812825)
-- Dependencies: 945 15
-- Name: menu_2_registrar(integer, character varying, character varying, character varying, integer, integer); Type: FUNCTION; Schema: seguridad; Owner: postgres
--

CREATE FUNCTION menu_2_registrar(id_n1 integer, i_id character varying, i_opcion character varying, i_ruta character varying, i_orden integer, i_id_status integer) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE   
	o_return integer;
	v_existe boolean;
BEGIN
	o_return:=0;
	IF  i_id='' THEN 
		SELECT CASE WHEN count(titulo)=0 THEN false ELSE true END INTO v_existe FROM menu_rol.menu_2 WHERE titulo=i_opcion;
		IF v_existe='f' THEN	
			INSERT INTO menu_rol.menu_2(id_menu_1, titulo, ruta, orden, id_status) 
			VALUES (id_n1, i_opcion, i_ruta, i_orden, i_id_status);
			o_return:=3; 
		ELSE
			o_return:=98;
		END IF;
	ELSE
		SELECT CASE WHEN count(id)=0 THEN false ELSE true END INTO v_existe 
		FROM menu_rol.menu_2 WHERE id=CAST(i_id AS integer);
		IF v_existe='t' THEN
			UPDATE menu_rol.menu_2 
			SET id_menu_1=id_n1, titulo=i_opcion, ruta=i_ruta, orden=i_orden, id_status=i_id_status 
			WHERE id = CAST(i_id AS integer);
			o_return:=1;	
		ELSE
			o_return:=96;
		END IF;		
	END IF;
	RETURN o_return;  
END;
$$;


ALTER FUNCTION seguridad.menu_2_registrar(id_n1 integer, i_id character varying, i_opcion character varying, i_ruta character varying, i_orden integer, i_id_status integer) OWNER TO postgres;

--
-- TOC entry 360 (class 1255 OID 23812826)
-- Dependencies: 15 945
-- Name: menu_3_delete(integer); Type: FUNCTION; Schema: seguridad; Owner: postgres
--

CREATE FUNCTION menu_3_delete(i_id integer) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE   
	o_return integer;
	v_existe boolean;
BEGIN
	o_return:=0;

	--SELECT CASE WHEN count(id_menu_2)=0 THEN false ELSE true END INTO v_existe FROM menu_rol.menu_3 WHERE id_menu_2=i_id;
	--IF v_existe='f' THEN
		DELETE FROM menu_rol.menu_3 WHERE id=i_id;
		o_return:=2;
	--ELSE
	--	o_return:=97;
	--END IF;
	
	
	RETURN o_return;  
END;
$$;


ALTER FUNCTION seguridad.menu_3_delete(i_id integer) OWNER TO postgres;

--
-- TOC entry 361 (class 1255 OID 23812827)
-- Dependencies: 15 945
-- Name: menu_3_registrar(integer, character varying, character varying, character varying, integer, integer); Type: FUNCTION; Schema: seguridad; Owner: postgres
--

CREATE FUNCTION menu_3_registrar(id_n2 integer, i_id character varying, i_opcion character varying, i_ruta character varying, i_orden integer, i_id_status integer) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE   
	o_return integer;
	v_existe boolean;
BEGIN
	o_return:=0;
	IF  i_id='' THEN 
		SELECT CASE WHEN count(titulo)=0 THEN false ELSE true END INTO v_existe FROM menu_rol.menu_3 WHERE titulo=i_opcion;
		IF v_existe='f' THEN	
			INSERT INTO menu_rol.menu_3(id_menu_2, titulo, ruta, orden, id_status) 
			VALUES (id_n2, i_opcion, i_ruta, i_orden, i_id_status);
			o_return:=3; 
		ELSE
			o_return:=98;
		END IF;
	ELSE
		SELECT CASE WHEN count(id)=0 THEN false ELSE true END INTO v_existe 
		FROM menu_rol.menu_3 WHERE id=CAST(i_id AS integer);
		IF v_existe='t' THEN
			UPDATE menu_rol.menu_3 
			SET id_menu_2=id_n2, titulo=i_opcion, ruta=i_ruta, orden=i_orden, id_status=i_id_status 
			WHERE id = CAST(i_id AS integer);
			o_return:=1;	
		ELSE
			o_return:=96;
		END IF;		
	END IF;
	RETURN o_return;  
END;
$$;


ALTER FUNCTION seguridad.menu_3_registrar(id_n2 integer, i_id character varying, i_opcion character varying, i_ruta character varying, i_orden integer, i_id_status integer) OWNER TO postgres;

--
-- TOC entry 288 (class 1259 OID 23812828)
-- Dependencies: 15
-- Name: seq_menu_0; Type: SEQUENCE; Schema: seguridad; Owner: postgres
--

CREATE SEQUENCE seq_menu_0
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE seguridad.seq_menu_0 OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 289 (class 1259 OID 23812830)
-- Dependencies: 2277 2278 15
-- Name: menu_0; Type: TABLE; Schema: seguridad; Owner: postgres; Tablespace: 
--

CREATE TABLE menu_0 (
    id integer DEFAULT nextval('seq_menu_0'::regclass) NOT NULL,
    titulo character varying(50),
    ruta character varying(150),
    orden integer,
    id_status integer DEFAULT 1
);


ALTER TABLE seguridad.menu_0 OWNER TO postgres;

--
-- TOC entry 290 (class 1259 OID 23812835)
-- Dependencies: 15
-- Name: seq_menu_1; Type: SEQUENCE; Schema: seguridad; Owner: postgres
--

CREATE SEQUENCE seq_menu_1
    START WITH 11
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE seguridad.seq_menu_1 OWNER TO postgres;

--
-- TOC entry 291 (class 1259 OID 23812837)
-- Dependencies: 2279 15
-- Name: menu_1; Type: TABLE; Schema: seguridad; Owner: postgres; Tablespace: 
--

CREATE TABLE menu_1 (
    id integer DEFAULT nextval('seq_menu_1'::regclass) NOT NULL,
    id_menu_0 integer,
    titulo character varying(50),
    ruta character varying(150),
    orden integer,
    id_status integer
);


ALTER TABLE seguridad.menu_1 OWNER TO postgres;

--
-- TOC entry 292 (class 1259 OID 23812841)
-- Dependencies: 15
-- Name: seq_menu_2; Type: SEQUENCE; Schema: seguridad; Owner: postgres
--

CREATE SEQUENCE seq_menu_2
    START WITH 20
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE seguridad.seq_menu_2 OWNER TO postgres;

--
-- TOC entry 293 (class 1259 OID 23812843)
-- Dependencies: 2280 15
-- Name: menu_2; Type: TABLE; Schema: seguridad; Owner: postgres; Tablespace: 
--

CREATE TABLE menu_2 (
    id integer DEFAULT nextval('seq_menu_2'::regclass) NOT NULL,
    id_menu_1 integer,
    titulo character varying(50),
    ruta character varying(150),
    orden integer,
    id_status integer
);


ALTER TABLE seguridad.menu_2 OWNER TO postgres;

--
-- TOC entry 294 (class 1259 OID 23812847)
-- Dependencies: 15
-- Name: seq_menu_3; Type: SEQUENCE; Schema: seguridad; Owner: postgres
--

CREATE SEQUENCE seq_menu_3
    START WITH 49
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE seguridad.seq_menu_3 OWNER TO postgres;

--
-- TOC entry 295 (class 1259 OID 23812849)
-- Dependencies: 2281 15
-- Name: menu_3; Type: TABLE; Schema: seguridad; Owner: postgres; Tablespace: 
--

CREATE TABLE menu_3 (
    id integer DEFAULT nextval('seq_menu_3'::regclass) NOT NULL,
    id_menu_2 integer,
    titulo character varying(50),
    ruta character varying(150),
    orden integer,
    id_status integer
);


ALTER TABLE seguridad.menu_3 OWNER TO postgres;

--
-- TOC entry 296 (class 1259 OID 23812853)
-- Dependencies: 15
-- Name: rol_0; Type: TABLE; Schema: seguridad; Owner: postgres; Tablespace: 
--

CREATE TABLE rol_0 (
    id integer NOT NULL,
    id_rol integer,
    id_menu_0 integer
);


ALTER TABLE seguridad.rol_0 OWNER TO postgres;

--
-- TOC entry 297 (class 1259 OID 23812856)
-- Dependencies: 15
-- Name: rol_1; Type: TABLE; Schema: seguridad; Owner: postgres; Tablespace: 
--

CREATE TABLE rol_1 (
    id integer NOT NULL,
    id_rol integer,
    id_menu_1 integer
);


ALTER TABLE seguridad.rol_1 OWNER TO postgres;

--
-- TOC entry 298 (class 1259 OID 23812859)
-- Dependencies: 15
-- Name: rol_2; Type: TABLE; Schema: seguridad; Owner: postgres; Tablespace: 
--

CREATE TABLE rol_2 (
    id integer NOT NULL,
    id_rol integer,
    id_menu_2 integer
);


ALTER TABLE seguridad.rol_2 OWNER TO postgres;

--
-- TOC entry 299 (class 1259 OID 23812862)
-- Dependencies: 15
-- Name: rol_3; Type: TABLE; Schema: seguridad; Owner: postgres; Tablespace: 
--

CREATE TABLE rol_3 (
    id integer NOT NULL,
    id_rol integer,
    id_menu_3 integer
);


ALTER TABLE seguridad.rol_3 OWNER TO postgres;

--
-- TOC entry 300 (class 1259 OID 23812865)
-- Dependencies: 15
-- Name: roles; Type: TABLE; Schema: seguridad; Owner: postgres; Tablespace: 
--

CREATE TABLE roles (
    id integer NOT NULL,
    descripcion character varying(100)
);


ALTER TABLE seguridad.roles OWNER TO postgres;

--
-- TOC entry 302 (class 1259 OID 23813017)
-- Dependencies: 15
-- Name: seq_usuario; Type: SEQUENCE; Schema: seguridad; Owner: postgres
--

CREATE SEQUENCE seq_usuario
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE seguridad.seq_usuario OWNER TO postgres;

--
-- TOC entry 301 (class 1259 OID 23812868)
-- Dependencies: 15
-- Name: status; Type: TABLE; Schema: seguridad; Owner: postgres; Tablespace: 
--

CREATE TABLE status (
    id integer NOT NULL,
    descripcion character varying(15)
);


ALTER TABLE seguridad.status OWNER TO postgres;

--
-- TOC entry 303 (class 1259 OID 23813022)
-- Dependencies: 2282 15
-- Name: usuario; Type: TABLE; Schema: seguridad; Owner: postgres; Tablespace: 
--

CREATE TABLE usuario (
    id integer DEFAULT nextval('seq_usuario'::regclass) NOT NULL,
    usuario character varying(20) NOT NULL,
    correo character varying(100) NOT NULL,
    cedula character varying(15) NOT NULL,
    clave character varying(100),
    nombre character varying(100) NOT NULL,
    apellido character varying(100) NOT NULL,
    celular character varying(20),
    telefono1 character varying(20),
    telefono2 character varying(20),
    id_rol integer NOT NULL,
    id_status integer NOT NULL,
    pregunta_seguridad character varying,
    respuesta_seguridad character varying,
    fecha_registro date
);


ALTER TABLE seguridad.usuario OWNER TO postgres;

--
-- TOC entry 2308 (class 2606 OID 23813030)
-- Dependencies: 303 303
-- Name: cedula_u; Type: CONSTRAINT; Schema: seguridad; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT cedula_u UNIQUE (cedula);


--
-- TOC entry 2310 (class 2606 OID 23813032)
-- Dependencies: 303 303
-- Name: correo_u; Type: CONSTRAINT; Schema: seguridad; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT correo_u UNIQUE (correo);


--
-- TOC entry 2312 (class 2606 OID 23813034)
-- Dependencies: 303 303
-- Name: id_usuario; Type: CONSTRAINT; Schema: seguridad; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT id_usuario PRIMARY KEY (id);


--
-- TOC entry 2284 (class 2606 OID 23812872)
-- Dependencies: 289 289
-- Name: menu_0_orden_key; Type: CONSTRAINT; Schema: seguridad; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY menu_0
    ADD CONSTRAINT menu_0_orden_key UNIQUE (orden);


--
-- TOC entry 2286 (class 2606 OID 23812874)
-- Dependencies: 289 289
-- Name: menu_0_titulo_key; Type: CONSTRAINT; Schema: seguridad; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY menu_0
    ADD CONSTRAINT menu_0_titulo_key UNIQUE (titulo);


--
-- TOC entry 2288 (class 2606 OID 23812876)
-- Dependencies: 289 289
-- Name: menu_abuelo_pkey; Type: CONSTRAINT; Schema: seguridad; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY menu_0
    ADD CONSTRAINT menu_abuelo_pkey PRIMARY KEY (id);


--
-- TOC entry 2292 (class 2606 OID 23812878)
-- Dependencies: 293 293
-- Name: menu_hijo_pkey; Type: CONSTRAINT; Schema: seguridad; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY menu_2
    ADD CONSTRAINT menu_hijo_pkey PRIMARY KEY (id);


--
-- TOC entry 2294 (class 2606 OID 23812880)
-- Dependencies: 295 295
-- Name: menu_nieto_pkey; Type: CONSTRAINT; Schema: seguridad; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY menu_3
    ADD CONSTRAINT menu_nieto_pkey PRIMARY KEY (id);


--
-- TOC entry 2290 (class 2606 OID 23812882)
-- Dependencies: 291 291
-- Name: menu_padre_pkey; Type: CONSTRAINT; Schema: seguridad; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY menu_1
    ADD CONSTRAINT menu_padre_pkey PRIMARY KEY (id);


--
-- TOC entry 2296 (class 2606 OID 23812884)
-- Dependencies: 296 296
-- Name: rol_abuelo_pkey; Type: CONSTRAINT; Schema: seguridad; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY rol_0
    ADD CONSTRAINT rol_abuelo_pkey PRIMARY KEY (id);


--
-- TOC entry 2300 (class 2606 OID 23812886)
-- Dependencies: 298 298
-- Name: rol_hijo_pkey; Type: CONSTRAINT; Schema: seguridad; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY rol_2
    ADD CONSTRAINT rol_hijo_pkey PRIMARY KEY (id);


--
-- TOC entry 2302 (class 2606 OID 23812888)
-- Dependencies: 299 299
-- Name: rol_nieto_pkey; Type: CONSTRAINT; Schema: seguridad; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY rol_3
    ADD CONSTRAINT rol_nieto_pkey PRIMARY KEY (id);


--
-- TOC entry 2298 (class 2606 OID 23812890)
-- Dependencies: 297 297
-- Name: rol_padre_pkey; Type: CONSTRAINT; Schema: seguridad; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY rol_1
    ADD CONSTRAINT rol_padre_pkey PRIMARY KEY (id);


--
-- TOC entry 2304 (class 2606 OID 23812892)
-- Dependencies: 300 300
-- Name: rol_pkey; Type: CONSTRAINT; Schema: seguridad; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY roles
    ADD CONSTRAINT rol_pkey PRIMARY KEY (id);


--
-- TOC entry 2306 (class 2606 OID 23812894)
-- Dependencies: 301 301
-- Name: status_pkey; Type: CONSTRAINT; Schema: seguridad; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY status
    ADD CONSTRAINT status_pkey PRIMARY KEY (id);


--
-- TOC entry 2314 (class 2606 OID 23813036)
-- Dependencies: 303 303
-- Name: usuario_u; Type: CONSTRAINT; Schema: seguridad; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT usuario_u UNIQUE (usuario);


--
-- TOC entry 2321 (class 2606 OID 23813037)
-- Dependencies: 303 300 2303
-- Name: id_rol_fk; Type: FK CONSTRAINT; Schema: seguridad; Owner: postgres
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT id_rol_fk FOREIGN KEY (id_rol) REFERENCES roles(id) ON UPDATE CASCADE;


--
-- TOC entry 2322 (class 2606 OID 23813042)
-- Dependencies: 301 303 2305
-- Name: id_status_fk; Type: FK CONSTRAINT; Schema: seguridad; Owner: postgres
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT id_status_fk FOREIGN KEY (id_status) REFERENCES status(id) ON UPDATE CASCADE;


--
-- TOC entry 2315 (class 2606 OID 23812895)
-- Dependencies: 2305 293 301
-- Name: menu_2_id_status_fkey; Type: FK CONSTRAINT; Schema: seguridad; Owner: postgres
--

ALTER TABLE ONLY menu_2
    ADD CONSTRAINT menu_2_id_status_fkey FOREIGN KEY (id_status) REFERENCES status(id);


--
-- TOC entry 2316 (class 2606 OID 23812900)
-- Dependencies: 295 301 2305
-- Name: menu_3_id_status_fkey; Type: FK CONSTRAINT; Schema: seguridad; Owner: postgres
--

ALTER TABLE ONLY menu_3
    ADD CONSTRAINT menu_3_id_status_fkey FOREIGN KEY (id_status) REFERENCES status(id);


--
-- TOC entry 2317 (class 2606 OID 23812905)
-- Dependencies: 2303 300 296
-- Name: rol_abuelo_id_rol_fkey; Type: FK CONSTRAINT; Schema: seguridad; Owner: postgres
--

ALTER TABLE ONLY rol_0
    ADD CONSTRAINT rol_abuelo_id_rol_fkey FOREIGN KEY (id_rol) REFERENCES roles(id);


--
-- TOC entry 2319 (class 2606 OID 23812910)
-- Dependencies: 2303 300 298
-- Name: rol_hijo_id_rol_fkey; Type: FK CONSTRAINT; Schema: seguridad; Owner: postgres
--

ALTER TABLE ONLY rol_2
    ADD CONSTRAINT rol_hijo_id_rol_fkey FOREIGN KEY (id_rol) REFERENCES roles(id);


--
-- TOC entry 2320 (class 2606 OID 23812915)
-- Dependencies: 300 2303 299
-- Name: rol_nieto_id_rol_fkey; Type: FK CONSTRAINT; Schema: seguridad; Owner: postgres
--

ALTER TABLE ONLY rol_3
    ADD CONSTRAINT rol_nieto_id_rol_fkey FOREIGN KEY (id_rol) REFERENCES roles(id);


--
-- TOC entry 2318 (class 2606 OID 23812920)
-- Dependencies: 297 2303 300
-- Name: rol_padre_id_rol_fkey; Type: FK CONSTRAINT; Schema: seguridad; Owner: postgres
--

ALTER TABLE ONLY rol_1
    ADD CONSTRAINT rol_padre_id_rol_fkey FOREIGN KEY (id_rol) REFERENCES roles(id);


-- Completed on 2012-09-27 13:06:04 VET

--
-- PostgreSQL database dump complete
--

