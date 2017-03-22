--
-- PostgreSQL database dump
--

-- Started on 2012-08-09 14:43:48 VET

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- TOC entry 11 (class 2615 OID 18617666)
-- Name: menu_rol; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA menu_rol;


ALTER SCHEMA menu_rol OWNER TO postgres;

SET search_path = menu_rol, pg_catalog;

--
-- TOC entry 242 (class 1255 OID 18617801)
-- Dependencies: 11 651
-- Name: menu_0_delete(integer); Type: FUNCTION; Schema: menu_rol; Owner: postgres
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


ALTER FUNCTION menu_rol.menu_0_delete(i_id integer) OWNER TO postgres;

--
-- TOC entry 240 (class 1255 OID 18617800)
-- Dependencies: 11 651
-- Name: menu_0_registrar(character varying, character varying, character varying, integer, integer); Type: FUNCTION; Schema: menu_rol; Owner: postgres
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


ALTER FUNCTION menu_rol.menu_0_registrar(i_id character varying, i_opcion character varying, i_ruta character varying, i_orden integer, i_id_status integer) OWNER TO postgres;

--
-- TOC entry 238 (class 1255 OID 18617818)
-- Dependencies: 11 651
-- Name: menu_1_delete(integer); Type: FUNCTION; Schema: menu_rol; Owner: postgres
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


ALTER FUNCTION menu_rol.menu_1_delete(i_id integer) OWNER TO postgres;

--
-- TOC entry 243 (class 1255 OID 18617813)
-- Dependencies: 651 11
-- Name: menu_1_registrar(integer, character varying, character varying, character varying, integer, integer); Type: FUNCTION; Schema: menu_rol; Owner: postgres
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


ALTER FUNCTION menu_rol.menu_1_registrar(id_n0 integer, i_id character varying, i_opcion character varying, i_ruta character varying, i_orden integer, i_id_status integer) OWNER TO postgres;

--
-- TOC entry 236 (class 1255 OID 18617835)
-- Dependencies: 651 11
-- Name: menu_2_delete(integer); Type: FUNCTION; Schema: menu_rol; Owner: postgres
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


ALTER FUNCTION menu_rol.menu_2_delete(i_id integer) OWNER TO postgres;

--
-- TOC entry 239 (class 1255 OID 18617831)
-- Dependencies: 11 651
-- Name: menu_2_registrar(integer, character varying, character varying, character varying, integer, integer); Type: FUNCTION; Schema: menu_rol; Owner: postgres
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


ALTER FUNCTION menu_rol.menu_2_registrar(id_n1 integer, i_id character varying, i_opcion character varying, i_ruta character varying, i_orden integer, i_id_status integer) OWNER TO postgres;

--
-- TOC entry 237 (class 1255 OID 18618091)
-- Dependencies: 11 651
-- Name: menu_3_delete(integer); Type: FUNCTION; Schema: menu_rol; Owner: postgres
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


ALTER FUNCTION menu_rol.menu_3_delete(i_id integer) OWNER TO postgres;

--
-- TOC entry 241 (class 1255 OID 18618090)
-- Dependencies: 651 11
-- Name: menu_3_registrar(integer, character varying, character varying, character varying, integer, integer); Type: FUNCTION; Schema: menu_rol; Owner: postgres
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


ALTER FUNCTION menu_rol.menu_3_registrar(id_n2 integer, i_id character varying, i_opcion character varying, i_ruta character varying, i_orden integer, i_id_status integer) OWNER TO postgres;

--
-- TOC entry 203 (class 1259 OID 18617793)
-- Dependencies: 11
-- Name: seq_menu_0; Type: SEQUENCE; Schema: menu_rol; Owner: postgres
--

CREATE SEQUENCE seq_menu_0
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE menu_rol.seq_menu_0 OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 193 (class 1259 OID 18617667)
-- Dependencies: 1983 1984 11
-- Name: menu_0; Type: TABLE; Schema: menu_rol; Owner: postgres; Tablespace: 
--

CREATE TABLE menu_0 (
    id integer DEFAULT nextval('seq_menu_0'::regclass) NOT NULL,
    titulo character varying(50),
    ruta character varying(150),
    orden integer,
    id_status integer DEFAULT 1
);


ALTER TABLE menu_rol.menu_0 OWNER TO postgres;

--
-- TOC entry 204 (class 1259 OID 18617814)
-- Dependencies: 11
-- Name: seq_menu_1; Type: SEQUENCE; Schema: menu_rol; Owner: postgres
--

CREATE SEQUENCE seq_menu_1
    START WITH 11
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE menu_rol.seq_menu_1 OWNER TO postgres;

--
-- TOC entry 194 (class 1259 OID 18617670)
-- Dependencies: 1985 11
-- Name: menu_1; Type: TABLE; Schema: menu_rol; Owner: postgres; Tablespace: 
--

CREATE TABLE menu_1 (
    id integer DEFAULT nextval('seq_menu_1'::regclass) NOT NULL,
    id_menu_0 integer,
    titulo character varying(50),
    ruta character varying(150),
    orden integer,
    id_status integer
);


ALTER TABLE menu_rol.menu_1 OWNER TO postgres;

--
-- TOC entry 205 (class 1259 OID 18617832)
-- Dependencies: 11
-- Name: seq_menu_2; Type: SEQUENCE; Schema: menu_rol; Owner: postgres
--

CREATE SEQUENCE seq_menu_2
    START WITH 20
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE menu_rol.seq_menu_2 OWNER TO postgres;

--
-- TOC entry 195 (class 1259 OID 18617673)
-- Dependencies: 1986 11
-- Name: menu_2; Type: TABLE; Schema: menu_rol; Owner: postgres; Tablespace: 
--

CREATE TABLE menu_2 (
    id integer DEFAULT nextval('seq_menu_2'::regclass) NOT NULL,
    id_menu_1 integer,
    titulo character varying(50),
    ruta character varying(150),
    orden integer,
    id_status integer
);


ALTER TABLE menu_rol.menu_2 OWNER TO postgres;

--
-- TOC entry 206 (class 1259 OID 18618092)
-- Dependencies: 11
-- Name: seq_menu_3; Type: SEQUENCE; Schema: menu_rol; Owner: postgres
--

CREATE SEQUENCE seq_menu_3
    START WITH 49
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE menu_rol.seq_menu_3 OWNER TO postgres;

--
-- TOC entry 196 (class 1259 OID 18617676)
-- Dependencies: 1987 11
-- Name: menu_3; Type: TABLE; Schema: menu_rol; Owner: postgres; Tablespace: 
--

CREATE TABLE menu_3 (
    id integer DEFAULT nextval('seq_menu_3'::regclass) NOT NULL,
    id_menu_2 integer,
    titulo character varying(50),
    ruta character varying(150),
    orden integer,
    id_status integer
);


ALTER TABLE menu_rol.menu_3 OWNER TO postgres;

--
-- TOC entry 197 (class 1259 OID 18617679)
-- Dependencies: 11
-- Name: rol_0; Type: TABLE; Schema: menu_rol; Owner: postgres; Tablespace: 
--

CREATE TABLE rol_0 (
    id integer NOT NULL,
    id_rol integer,
    id_menu_0 integer
);


ALTER TABLE menu_rol.rol_0 OWNER TO postgres;

--
-- TOC entry 198 (class 1259 OID 18617682)
-- Dependencies: 11
-- Name: rol_1; Type: TABLE; Schema: menu_rol; Owner: postgres; Tablespace: 
--

CREATE TABLE rol_1 (
    id integer NOT NULL,
    id_rol integer,
    id_menu_1 integer
);


ALTER TABLE menu_rol.rol_1 OWNER TO postgres;

--
-- TOC entry 199 (class 1259 OID 18617685)
-- Dependencies: 11
-- Name: rol_2; Type: TABLE; Schema: menu_rol; Owner: postgres; Tablespace: 
--

CREATE TABLE rol_2 (
    id integer NOT NULL,
    id_rol integer,
    id_menu_2 integer
);


ALTER TABLE menu_rol.rol_2 OWNER TO postgres;

--
-- TOC entry 200 (class 1259 OID 18617688)
-- Dependencies: 11
-- Name: rol_3; Type: TABLE; Schema: menu_rol; Owner: postgres; Tablespace: 
--

CREATE TABLE rol_3 (
    id integer NOT NULL,
    id_rol integer,
    id_menu_3 integer
);


ALTER TABLE menu_rol.rol_3 OWNER TO postgres;

--
-- TOC entry 201 (class 1259 OID 18617691)
-- Dependencies: 11
-- Name: roles; Type: TABLE; Schema: menu_rol; Owner: postgres; Tablespace: 
--

CREATE TABLE roles (
    id integer NOT NULL,
    descripcion character varying(100)
);


ALTER TABLE menu_rol.roles OWNER TO postgres;

--
-- TOC entry 202 (class 1259 OID 18617784)
-- Dependencies: 11
-- Name: status; Type: TABLE; Schema: menu_rol; Owner: postgres; Tablespace: 
--

CREATE TABLE status (
    id integer NOT NULL,
    descripcion character varying(15)
);


ALTER TABLE menu_rol.status OWNER TO postgres;

--
-- TOC entry 1989 (class 2606 OID 18617790)
-- Dependencies: 193 193
-- Name: menu_0_orden_key; Type: CONSTRAINT; Schema: menu_rol; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY menu_0
    ADD CONSTRAINT menu_0_orden_key UNIQUE (orden);


--
-- TOC entry 1991 (class 2606 OID 18617792)
-- Dependencies: 193 193
-- Name: menu_0_titulo_key; Type: CONSTRAINT; Schema: menu_rol; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY menu_0
    ADD CONSTRAINT menu_0_titulo_key UNIQUE (titulo);


--
-- TOC entry 1993 (class 2606 OID 18617695)
-- Dependencies: 193 193
-- Name: menu_abuelo_pkey; Type: CONSTRAINT; Schema: menu_rol; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY menu_0
    ADD CONSTRAINT menu_abuelo_pkey PRIMARY KEY (id);


--
-- TOC entry 1997 (class 2606 OID 18617697)
-- Dependencies: 195 195
-- Name: menu_hijo_pkey; Type: CONSTRAINT; Schema: menu_rol; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY menu_2
    ADD CONSTRAINT menu_hijo_pkey PRIMARY KEY (id);


--
-- TOC entry 1999 (class 2606 OID 18617699)
-- Dependencies: 196 196
-- Name: menu_nieto_pkey; Type: CONSTRAINT; Schema: menu_rol; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY menu_3
    ADD CONSTRAINT menu_nieto_pkey PRIMARY KEY (id);


--
-- TOC entry 1995 (class 2606 OID 18617701)
-- Dependencies: 194 194
-- Name: menu_padre_pkey; Type: CONSTRAINT; Schema: menu_rol; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY menu_1
    ADD CONSTRAINT menu_padre_pkey PRIMARY KEY (id);


--
-- TOC entry 2001 (class 2606 OID 18617703)
-- Dependencies: 197 197
-- Name: rol_abuelo_pkey; Type: CONSTRAINT; Schema: menu_rol; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY rol_0
    ADD CONSTRAINT rol_abuelo_pkey PRIMARY KEY (id);


--
-- TOC entry 2005 (class 2606 OID 18617705)
-- Dependencies: 199 199
-- Name: rol_hijo_pkey; Type: CONSTRAINT; Schema: menu_rol; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY rol_2
    ADD CONSTRAINT rol_hijo_pkey PRIMARY KEY (id);


--
-- TOC entry 2007 (class 2606 OID 18617707)
-- Dependencies: 200 200
-- Name: rol_nieto_pkey; Type: CONSTRAINT; Schema: menu_rol; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY rol_3
    ADD CONSTRAINT rol_nieto_pkey PRIMARY KEY (id);


--
-- TOC entry 2003 (class 2606 OID 18617709)
-- Dependencies: 198 198
-- Name: rol_padre_pkey; Type: CONSTRAINT; Schema: menu_rol; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY rol_1
    ADD CONSTRAINT rol_padre_pkey PRIMARY KEY (id);


--
-- TOC entry 2009 (class 2606 OID 18617711)
-- Dependencies: 201 201
-- Name: rol_pkey; Type: CONSTRAINT; Schema: menu_rol; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY roles
    ADD CONSTRAINT rol_pkey PRIMARY KEY (id);


--
-- TOC entry 2011 (class 2606 OID 18617788)
-- Dependencies: 202 202
-- Name: status_pkey; Type: CONSTRAINT; Schema: menu_rol; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY status
    ADD CONSTRAINT status_pkey PRIMARY KEY (id);


--
-- TOC entry 2012 (class 2606 OID 18617819)
-- Dependencies: 195 2010 202
-- Name: menu_2_id_status_fkey; Type: FK CONSTRAINT; Schema: menu_rol; Owner: postgres
--

ALTER TABLE ONLY menu_2
    ADD CONSTRAINT menu_2_id_status_fkey FOREIGN KEY (id_status) REFERENCES status(id);


--
-- TOC entry 2013 (class 2606 OID 18617824)
-- Dependencies: 2010 196 202
-- Name: menu_3_id_status_fkey; Type: FK CONSTRAINT; Schema: menu_rol; Owner: postgres
--

ALTER TABLE ONLY menu_3
    ADD CONSTRAINT menu_3_id_status_fkey FOREIGN KEY (id_status) REFERENCES status(id);


--
-- TOC entry 2014 (class 2606 OID 18617712)
-- Dependencies: 197 193 1992
-- Name: rol_abuelo_id_menu_abuelo_fkey; Type: FK CONSTRAINT; Schema: menu_rol; Owner: postgres
--

ALTER TABLE ONLY rol_0
    ADD CONSTRAINT rol_abuelo_id_menu_abuelo_fkey FOREIGN KEY (id_menu_0) REFERENCES menu_0(id);


--
-- TOC entry 2015 (class 2606 OID 18617717)
-- Dependencies: 201 2008 197
-- Name: rol_abuelo_id_rol_fkey; Type: FK CONSTRAINT; Schema: menu_rol; Owner: postgres
--

ALTER TABLE ONLY rol_0
    ADD CONSTRAINT rol_abuelo_id_rol_fkey FOREIGN KEY (id_rol) REFERENCES roles(id);


--
-- TOC entry 2017 (class 2606 OID 18617727)
-- Dependencies: 2008 201 199
-- Name: rol_hijo_id_rol_fkey; Type: FK CONSTRAINT; Schema: menu_rol; Owner: postgres
--

ALTER TABLE ONLY rol_2
    ADD CONSTRAINT rol_hijo_id_rol_fkey FOREIGN KEY (id_rol) REFERENCES roles(id);


--
-- TOC entry 2018 (class 2606 OID 18617737)
-- Dependencies: 200 2008 201
-- Name: rol_nieto_id_rol_fkey; Type: FK CONSTRAINT; Schema: menu_rol; Owner: postgres
--

ALTER TABLE ONLY rol_3
    ADD CONSTRAINT rol_nieto_id_rol_fkey FOREIGN KEY (id_rol) REFERENCES roles(id);


--
-- TOC entry 2016 (class 2606 OID 18617747)
-- Dependencies: 198 201 2008
-- Name: rol_padre_id_rol_fkey; Type: FK CONSTRAINT; Schema: menu_rol; Owner: postgres
--

ALTER TABLE ONLY rol_1
    ADD CONSTRAINT rol_padre_id_rol_fkey FOREIGN KEY (id_rol) REFERENCES roles(id);


-- Completed on 2012-08-09 14:43:49 VET

--
-- PostgreSQL database dump complete
--
