--
-- PostgreSQL database dump
--

-- Dumped from database version 10.4
-- Dumped by pg_dump version 10.4

-- Started on 2018-08-01 14:49:19

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
    display integer NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE parts.brand OWNER TO postgres;

--
-- TOC entry 3005 (class 0 OID 28178)
-- Dependencies: 243
-- Data for Name: brand; Type: TABLE DATA; Schema: parts; Owner: postgres
--

INSERT INTO parts.brand (id, display, name) VALUES (2, 1, 'Acura');
INSERT INTO parts.brand (id, display, name) VALUES (11, 1, 'Alfa Romeo');
INSERT INTO parts.brand (id, display, name) VALUES (13, 1, 'Alpina');
INSERT INTO parts.brand (id, display, name) VALUES (26, 1, 'Asia Motors');
INSERT INTO parts.brand (id, display, name) VALUES (28, 1, 'Aston Martin');
INSERT INTO parts.brand (id, display, name) VALUES (31, 1, 'Audi');
INSERT INTO parts.brand (id, display, name) VALUES (58, 1, 'Bentley');
INSERT INTO parts.brand (id, display, name) VALUES (67, 1, 'BMW');
INSERT INTO parts.brand (id, display, name) VALUES (79, 1, 'Brilliance');
INSERT INTO parts.brand (id, display, name) VALUES (85, 1, 'Bugatti');
INSERT INTO parts.brand (id, display, name) VALUES (86, 1, 'Buick');
INSERT INTO parts.brand (id, display, name) VALUES (88, 1, 'BYD');
INSERT INTO parts.brand (id, display, name) VALUES (90, 1, 'Cadillac');
INSERT INTO parts.brand (id, display, name) VALUES (103, 1, 'Changan (Chana)');
INSERT INTO parts.brand (id, display, name) VALUES (108, 1, 'Chery');
INSERT INTO parts.brand (id, display, name) VALUES (109, 1, 'Chevrolet');
INSERT INTO parts.brand (id, display, name) VALUES (112, 1, 'Chrysler');
INSERT INTO parts.brand (id, display, name) VALUES (115, 1, 'Citroen');
INSERT INTO parts.brand (id, display, name) VALUES (123, 1, 'Dacia');
INSERT INTO parts.brand (id, display, name) VALUES (127, 1, 'Daewoo');
INSERT INTO parts.brand (id, display, name) VALUES (130, 1, 'Daihatsu');
INSERT INTO parts.brand (id, display, name) VALUES (132, 1, 'Daimler');
INSERT INTO parts.brand (id, display, name) VALUES (135, 1, 'Datsun');
INSERT INTO parts.brand (id, display, name) VALUES (137, 1, 'DeLorean');
INSERT INTO parts.brand (id, display, name) VALUES (142, 1, 'Derways');
INSERT INTO parts.brand (id, display, name) VALUES (146, 1, 'Dodge');
INSERT INTO parts.brand (id, display, name) VALUES (147, 1, 'Dongfeng');
INSERT INTO parts.brand (id, display, name) VALUES (159, 1, 'Eagle');
INSERT INTO parts.brand (id, display, name) VALUES (178, 1, 'FAW');
INSERT INTO parts.brand (id, display, name) VALUES (185, 1, 'Ferrari');
INSERT INTO parts.brand (id, display, name) VALUES (628, 1, 'Ravon');
INSERT INTO parts.brand (id, display, name) VALUES (187, 1, 'Fiat');
INSERT INTO parts.brand (id, display, name) VALUES (190, 1, 'Fisker');
INSERT INTO parts.brand (id, display, name) VALUES (195, 1, 'Ford');
INSERT INTO parts.brand (id, display, name) VALUES (214, 1, 'Geely');
INSERT INTO parts.brand (id, display, name) VALUES (215, 1, 'Geo');
INSERT INTO parts.brand (id, display, name) VALUES (222, 1, 'GMC');
INSERT INTO parts.brand (id, display, name) VALUES (226, 1, 'Great Wall');
INSERT INTO parts.brand (id, display, name) VALUES (230, 1, 'Hafei');
INSERT INTO parts.brand (id, display, name) VALUES (231, 1, 'Haima');
INSERT INTO parts.brand (id, display, name) VALUES (238, 1, 'Haval');
INSERT INTO parts.brand (id, display, name) VALUES (239, 1, 'Hawtai');
INSERT INTO parts.brand (id, display, name) VALUES (248, 1, 'Hino');
INSERT INTO parts.brand (id, display, name) VALUES (252, 0, 'HOLDER');
INSERT INTO parts.brand (id, display, name) VALUES (253, 1, 'Honda');
INSERT INTO parts.brand (id, display, name) VALUES (263, 1, 'Hummer');
INSERT INTO parts.brand (id, display, name) VALUES (267, 1, 'Hyundai');
INSERT INTO parts.brand (id, display, name) VALUES (275, 1, 'Infiniti');
INSERT INTO parts.brand (id, display, name) VALUES (281, 1, 'Iran Khodro');
INSERT INTO parts.brand (id, display, name) VALUES (288, 1, 'Isuzu');
INSERT INTO parts.brand (id, display, name) VALUES (290, 1, 'Iveco');
INSERT INTO parts.brand (id, display, name) VALUES (291, 1, 'JAC');
INSERT INTO parts.brand (id, display, name) VALUES (292, 1, 'Jaguar');
INSERT INTO parts.brand (id, display, name) VALUES (295, 1, 'Jeep');
INSERT INTO parts.brand (id, display, name) VALUES (316, 1, 'Kia');
INSERT INTO parts.brand (id, display, name) VALUES (321, 1, 'Koenigsegg');
INSERT INTO parts.brand (id, display, name) VALUES (333, 1, 'Lamborghini');
INSERT INTO parts.brand (id, display, name) VALUES (334, 1, 'Lancia');
INSERT INTO parts.brand (id, display, name) VALUES (335, 1, 'Land Rover');
INSERT INTO parts.brand (id, display, name) VALUES (341, 1, 'Lexus');
INSERT INTO parts.brand (id, display, name) VALUES (348, 1, 'Lifan');
INSERT INTO parts.brand (id, display, name) VALUES (350, 1, 'Lincoln');
INSERT INTO parts.brand (id, display, name) VALUES (355, 1, 'Lotus');
INSERT INTO parts.brand (id, display, name) VALUES (358, 1, 'Luxgen');
INSERT INTO parts.brand (id, display, name) VALUES (501, 1, 'Scion');
INSERT INTO parts.brand (id, display, name) VALUES (370, 1, 'Maserati');
INSERT INTO parts.brand (id, display, name) VALUES (375, 1, 'Maybach');
INSERT INTO parts.brand (id, display, name) VALUES (378, 1, 'Mazda');
INSERT INTO parts.brand (id, display, name) VALUES (384, 1, 'McLaren');
INSERT INTO parts.brand (id, display, name) VALUES (387, 1, 'Mercedes-Benz');
INSERT INTO parts.brand (id, display, name) VALUES (390, 1, 'Mercury');
INSERT INTO parts.brand (id, display, name) VALUES (400, 1, 'Mini');
INSERT INTO parts.brand (id, display, name) VALUES (401, 1, 'Mitsubishi');
INSERT INTO parts.brand (id, display, name) VALUES (406, 1, 'Mitsuoka');
INSERT INTO parts.brand (id, display, name) VALUES (423, 1, 'Nissan');
INSERT INTO parts.brand (id, display, name) VALUES (428, 1, 'Oldsmobile');
INSERT INTO parts.brand (id, display, name) VALUES (431, 1, 'Opel');
INSERT INTO parts.brand (id, display, name) VALUES (437, 1, 'Pagani');
INSERT INTO parts.brand (id, display, name) VALUES (444, 1, 'Peugeot');
INSERT INTO parts.brand (id, display, name) VALUES (452, 1, 'Plymouth');
INSERT INTO parts.brand (id, display, name) VALUES (454, 1, 'Pontiac');
INSERT INTO parts.brand (id, display, name) VALUES (455, 1, 'Porsche');
INSERT INTO parts.brand (id, display, name) VALUES (457, 1, 'Proton');
INSERT INTO parts.brand (id, display, name) VALUES (471, 1, 'Renault');
INSERT INTO parts.brand (id, display, name) VALUES (472, 1, 'Renault Samsung');
INSERT INTO parts.brand (id, display, name) VALUES (480, 1, 'Rolls-Royce');
INSERT INTO parts.brand (id, display, name) VALUES (481, 1, 'Rover');
INSERT INTO parts.brand (id, display, name) VALUES (483, 1, 'Saab');
INSERT INTO parts.brand (id, display, name) VALUES (495, 1, 'Saturn');
INSERT INTO parts.brand (id, display, name) VALUES (502, 1, 'Seat');
INSERT INTO parts.brand (id, display, name) VALUES (516, 1, 'Skoda');
INSERT INTO parts.brand (id, display, name) VALUES (518, 1, 'Smart');
INSERT INTO parts.brand (id, display, name) VALUES (526, 1, 'SsangYong');
INSERT INTO parts.brand (id, display, name) VALUES (533, 1, 'Subaru');
INSERT INTO parts.brand (id, display, name) VALUES (536, 1, 'Suzuki');
INSERT INTO parts.brand (id, display, name) VALUES (550, 1, 'Tesla');
INSERT INTO parts.brand (id, display, name) VALUES (557, 1, 'Toyota');
INSERT INTO parts.brand (id, display, name) VALUES (566, 1, 'TVR');
INSERT INTO parts.brand (id, display, name) VALUES (586, 1, 'Volvo');
INSERT INTO parts.brand (id, display, name) VALUES (597, 1, 'Wiesmann');
INSERT INTO parts.brand (id, display, name) VALUES (603, 1, 'Xin Kai');
INSERT INTO parts.brand (id, display, name) VALUES (627, 1, 'Zotye');
INSERT INTO parts.brand (id, display, name) VALUES (629, 1, 'Tianye');
INSERT INTO parts.brand (id, display, name) VALUES (630, 1, 'Volkswagen');
INSERT INTO parts.brand (id, display, name) VALUES (631, 1, 'Vortex');
INSERT INTO parts.brand (id, display, name) VALUES (632, 1, 'ZX');
INSERT INTO parts.brand (id, display, name) VALUES (633, 1, 'ГАЗ');
INSERT INTO parts.brand (id, display, name) VALUES (634, 1, 'ЗАЗ');
INSERT INTO parts.brand (id, display, name) VALUES (635, 1, 'ИЖ');
INSERT INTO parts.brand (id, display, name) VALUES (636, 1, 'Лада');
INSERT INTO parts.brand (id, display, name) VALUES (637, 1, 'ЛуАЗ');
INSERT INTO parts.brand (id, display, name) VALUES (638, 1, 'Москвич');
INSERT INTO parts.brand (id, display, name) VALUES (639, 1, 'ТагАЗ');
INSERT INTO parts.brand (id, display, name) VALUES (640, 1, 'УАЗ');
INSERT INTO parts.brand (id, display, name) VALUES (641, 1, 'ПРОЧИЕ АВТО');
INSERT INTO parts.brand (id, display, name) VALUES (642, 1, 'Ваз');
INSERT INTO parts.brand (id, display, name) VALUES (643, 1, 'Волга');
INSERT INTO parts.brand (id, display, name) VALUES (644, 1, 'Газель');
INSERT INTO parts.brand (id, display, name) VALUES (645, 1, 'Зил');
INSERT INTO parts.brand (id, display, name) VALUES (646, 1, 'Икарус');
INSERT INTO parts.brand (id, display, name) VALUES (647, 1, 'Кавз');
INSERT INTO parts.brand (id, display, name) VALUES (648, 1, 'КамаЗ');
INSERT INTO parts.brand (id, display, name) VALUES (649, 1, 'Краз');
INSERT INTO parts.brand (id, display, name) VALUES (650, 1, 'Лаз');
INSERT INTO parts.brand (id, display, name) VALUES (651, 1, 'Лиаз');
INSERT INTO parts.brand (id, display, name) VALUES (652, 1, 'Маз');
INSERT INTO parts.brand (id, display, name) VALUES (653, 1, 'Нива');
INSERT INTO parts.brand (id, display, name) VALUES (654, 1, 'Паз');
INSERT INTO parts.brand (id, display, name) VALUES (655, 1, 'Урал');
INSERT INTO parts.brand (id, display, name) VALUES (656, 1, 'Howo');


--
-- TOC entry 2883 (class 2606 OID 28182)
-- Name: brand brand_pkey; Type: CONSTRAINT; Schema: parts; Owner: postgres
--

ALTER TABLE ONLY parts.brand
    ADD CONSTRAINT brand_pkey PRIMARY KEY (id);


-- Completed on 2018-08-01 14:49:19

--
-- PostgreSQL database dump complete
--

