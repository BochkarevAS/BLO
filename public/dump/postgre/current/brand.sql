--
-- PostgreSQL database dump
--

-- Dumped from database version 10.4
-- Dumped by pg_dump version 10.4

-- Started on 2018-08-02 14:56:42

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 243 (class 1259 OID 28178)
-- Name: brand; Type: TABLE; Schema: parts; Owner: postgres
--

CREATE TABLE parts.brand (
    id integer NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE parts.brand OWNER TO postgres;

--
-- TOC entry 3009 (class 0 OID 28178)
-- Dependencies: 243
-- Data for Name: brand; Type: TABLE DATA; Schema: parts; Owner: postgres
--

INSERT INTO parts.brand (id, name) VALUES (2, 'Acura');
INSERT INTO parts.brand (id, name) VALUES (11, 'Alfa Romeo');
INSERT INTO parts.brand (id, name) VALUES (13, 'Alpina');
INSERT INTO parts.brand (id, name) VALUES (26, 'Asia Motors');
INSERT INTO parts.brand (id, name) VALUES (28, 'Aston Martin');
INSERT INTO parts.brand (id, name) VALUES (31, 'Audi');
INSERT INTO parts.brand (id, name) VALUES (58, 'Bentley');
INSERT INTO parts.brand (id, name) VALUES (67, 'BMW');
INSERT INTO parts.brand (id, name) VALUES (79, 'Brilliance');
INSERT INTO parts.brand (id, name) VALUES (85, 'Bugatti');
INSERT INTO parts.brand (id, name) VALUES (86, 'Buick');
INSERT INTO parts.brand (id, name) VALUES (88, 'BYD');
INSERT INTO parts.brand (id, name) VALUES (90, 'Cadillac');
INSERT INTO parts.brand (id, name) VALUES (103, 'Changan (Chana)');
INSERT INTO parts.brand (id, name) VALUES (108, 'Chery');
INSERT INTO parts.brand (id, name) VALUES (109, 'Chevrolet');
INSERT INTO parts.brand (id, name) VALUES (112, 'Chrysler');
INSERT INTO parts.brand (id, name) VALUES (115, 'Citroen');
INSERT INTO parts.brand (id, name) VALUES (123, 'Dacia');
INSERT INTO parts.brand (id, name) VALUES (127, 'Daewoo');
INSERT INTO parts.brand (id, name) VALUES (130, 'Daihatsu');
INSERT INTO parts.brand (id, name) VALUES (132, 'Daimler');
INSERT INTO parts.brand (id, name) VALUES (135, 'Datsun');
INSERT INTO parts.brand (id, name) VALUES (137, 'DeLorean');
INSERT INTO parts.brand (id, name) VALUES (142, 'Derways');
INSERT INTO parts.brand (id, name) VALUES (146, 'Dodge');
INSERT INTO parts.brand (id, name) VALUES (147, 'Dongfeng');
INSERT INTO parts.brand (id, name) VALUES (159, 'Eagle');
INSERT INTO parts.brand (id, name) VALUES (178, 'FAW');
INSERT INTO parts.brand (id, name) VALUES (185, 'Ferrari');
INSERT INTO parts.brand (id, name) VALUES (628, 'Ravon');
INSERT INTO parts.brand (id, name) VALUES (187, 'Fiat');
INSERT INTO parts.brand (id, name) VALUES (190, 'Fisker');
INSERT INTO parts.brand (id, name) VALUES (195, 'Ford');
INSERT INTO parts.brand (id, name) VALUES (214, 'Geely');
INSERT INTO parts.brand (id, name) VALUES (215, 'Geo');
INSERT INTO parts.brand (id, name) VALUES (222, 'GMC');
INSERT INTO parts.brand (id, name) VALUES (226, 'Great Wall');
INSERT INTO parts.brand (id, name) VALUES (230, 'Hafei');
INSERT INTO parts.brand (id, name) VALUES (231, 'Haima');
INSERT INTO parts.brand (id, name) VALUES (238, 'Haval');
INSERT INTO parts.brand (id, name) VALUES (239, 'Hawtai');
INSERT INTO parts.brand (id, name) VALUES (248, 'Hino');
INSERT INTO parts.brand (id, name) VALUES (253, 'Honda');
INSERT INTO parts.brand (id, name) VALUES (263, 'Hummer');
INSERT INTO parts.brand (id, name) VALUES (267, 'Hyundai');
INSERT INTO parts.brand (id, name) VALUES (275, 'Infiniti');
INSERT INTO parts.brand (id, name) VALUES (281, 'Iran Khodro');
INSERT INTO parts.brand (id, name) VALUES (288, 'Isuzu');
INSERT INTO parts.brand (id, name) VALUES (290, 'Iveco');
INSERT INTO parts.brand (id, name) VALUES (291, 'JAC');
INSERT INTO parts.brand (id, name) VALUES (292, 'Jaguar');
INSERT INTO parts.brand (id, name) VALUES (295, 'Jeep');
INSERT INTO parts.brand (id, name) VALUES (316, 'Kia');
INSERT INTO parts.brand (id, name) VALUES (321, 'Koenigsegg');
INSERT INTO parts.brand (id, name) VALUES (333, 'Lamborghini');
INSERT INTO parts.brand (id, name) VALUES (334, 'Lancia');
INSERT INTO parts.brand (id, name) VALUES (335, 'Land Rover');
INSERT INTO parts.brand (id, name) VALUES (341, 'Lexus');
INSERT INTO parts.brand (id, name) VALUES (348, 'Lifan');
INSERT INTO parts.brand (id, name) VALUES (350, 'Lincoln');
INSERT INTO parts.brand (id, name) VALUES (355, 'Lotus');
INSERT INTO parts.brand (id, name) VALUES (358, 'Luxgen');
INSERT INTO parts.brand (id, name) VALUES (501, 'Scion');
INSERT INTO parts.brand (id, name) VALUES (370, 'Maserati');
INSERT INTO parts.brand (id, name) VALUES (375, 'Maybach');
INSERT INTO parts.brand (id, name) VALUES (378, 'Mazda');
INSERT INTO parts.brand (id, name) VALUES (384, 'McLaren');
INSERT INTO parts.brand (id, name) VALUES (387, 'Mercedes-Benz');
INSERT INTO parts.brand (id, name) VALUES (390, 'Mercury');
INSERT INTO parts.brand (id, name) VALUES (400, 'Mini');
INSERT INTO parts.brand (id, name) VALUES (401, 'Mitsubishi');
INSERT INTO parts.brand (id, name) VALUES (406, 'Mitsuoka');
INSERT INTO parts.brand (id, name) VALUES (423, 'Nissan');
INSERT INTO parts.brand (id, name) VALUES (428, 'Oldsmobile');
INSERT INTO parts.brand (id, name) VALUES (431, 'Opel');
INSERT INTO parts.brand (id, name) VALUES (437, 'Pagani');
INSERT INTO parts.brand (id, name) VALUES (444, 'Peugeot');
INSERT INTO parts.brand (id, name) VALUES (452, 'Plymouth');
INSERT INTO parts.brand (id, name) VALUES (454, 'Pontiac');
INSERT INTO parts.brand (id, name) VALUES (455, 'Porsche');
INSERT INTO parts.brand (id, name) VALUES (457, 'Proton');
INSERT INTO parts.brand (id, name) VALUES (471, 'Renault');
INSERT INTO parts.brand (id, name) VALUES (472, 'Renault Samsung');
INSERT INTO parts.brand (id, name) VALUES (480, 'Rolls-Royce');
INSERT INTO parts.brand (id, name) VALUES (481, 'Rover');
INSERT INTO parts.brand (id, name) VALUES (483, 'Saab');
INSERT INTO parts.brand (id, name) VALUES (495, 'Saturn');
INSERT INTO parts.brand (id, name) VALUES (502, 'Seat');
INSERT INTO parts.brand (id, name) VALUES (516, 'Skoda');
INSERT INTO parts.brand (id, name) VALUES (518, 'Smart');
INSERT INTO parts.brand (id, name) VALUES (526, 'SsangYong');
INSERT INTO parts.brand (id, name) VALUES (533, 'Subaru');
INSERT INTO parts.brand (id, name) VALUES (536, 'Suzuki');
INSERT INTO parts.brand (id, name) VALUES (550, 'Tesla');
INSERT INTO parts.brand (id, name) VALUES (557, 'Toyota');
INSERT INTO parts.brand (id, name) VALUES (566, 'TVR');
INSERT INTO parts.brand (id, name) VALUES (586, 'Volvo');
INSERT INTO parts.brand (id, name) VALUES (597, 'Wiesmann');
INSERT INTO parts.brand (id, name) VALUES (603, 'Xin Kai');
INSERT INTO parts.brand (id, name) VALUES (627, 'Zotye');
INSERT INTO parts.brand (id, name) VALUES (629, 'Tianye');
INSERT INTO parts.brand (id, name) VALUES (630, 'Volkswagen');
INSERT INTO parts.brand (id, name) VALUES (631, 'Vortex');
INSERT INTO parts.brand (id, name) VALUES (632, 'ZX');
INSERT INTO parts.brand (id, name) VALUES (633, 'ГАЗ');
INSERT INTO parts.brand (id, name) VALUES (634, 'ЗАЗ');
INSERT INTO parts.brand (id, name) VALUES (635, 'ИЖ');
INSERT INTO parts.brand (id, name) VALUES (636, 'Лада');
INSERT INTO parts.brand (id, name) VALUES (637, 'ЛуАЗ');
INSERT INTO parts.brand (id, name) VALUES (638, 'Москвич');
INSERT INTO parts.brand (id, name) VALUES (639, 'ТагАЗ');
INSERT INTO parts.brand (id, name) VALUES (640, 'УАЗ');
INSERT INTO parts.brand (id, name) VALUES (641, 'ПРОЧИЕ АВТО');
INSERT INTO parts.brand (id, name) VALUES (642, 'Ваз');
INSERT INTO parts.brand (id, name) VALUES (643, 'Волга');
INSERT INTO parts.brand (id, name) VALUES (644, 'Газель');
INSERT INTO parts.brand (id, name) VALUES (645, 'Зил');
INSERT INTO parts.brand (id, name) VALUES (646, 'Икарус');
INSERT INTO parts.brand (id, name) VALUES (647, 'Кавз');
INSERT INTO parts.brand (id, name) VALUES (648, 'КамаЗ');
INSERT INTO parts.brand (id, name) VALUES (649, 'Краз');
INSERT INTO parts.brand (id, name) VALUES (650, 'Лаз');
INSERT INTO parts.brand (id, name) VALUES (651, 'Лиаз');
INSERT INTO parts.brand (id, name) VALUES (652, 'Маз');
INSERT INTO parts.brand (id, name) VALUES (653, 'Нива');
INSERT INTO parts.brand (id, name) VALUES (654, 'Паз');
INSERT INTO parts.brand (id, name) VALUES (655, 'Урал');
INSERT INTO parts.brand (id, name) VALUES (656, 'Howo');


--
-- TOC entry 2887 (class 2606 OID 28182)
-- Name: brand brand_pkey; Type: CONSTRAINT; Schema: parts; Owner: postgres
--

ALTER TABLE ONLY parts.brand
    ADD CONSTRAINT brand_pkey PRIMARY KEY (id);


-- Completed on 2018-08-02 14:56:43

--
-- PostgreSQL database dump complete
--

