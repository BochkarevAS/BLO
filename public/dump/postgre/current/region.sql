--
-- PostgreSQL database dump
--

-- Dumped from database version 10.4
-- Dumped by pg_dump version 10.4

-- Started on 2018-08-02 15:15:50

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
-- TOC entry 210 (class 1259 OID 29329)
-- Name: region; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.region (
    id integer,
    name text
);


ALTER TABLE public.region OWNER TO postgres;

--
-- TOC entry 2883 (class 0 OID 29329)
-- Dependencies: 210
-- Data for Name: region; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.region (id, name) VALUES (1, 'Приморский край');
INSERT INTO public.region (id, name) VALUES (2, 'Камчатский край');
INSERT INTO public.region (id, name) VALUES (3, 'Хабаровский край');
INSERT INTO public.region (id, name) VALUES (4, 'Челябинская область');
INSERT INTO public.region (id, name) VALUES (5, 'Амурская область');
INSERT INTO public.region (id, name) VALUES (6, 'Тюменская область');
INSERT INTO public.region (id, name) VALUES (7, 'Свердловская область');
INSERT INTO public.region (id, name) VALUES (8, 'Сахалинская область');
INSERT INTO public.region (id, name) VALUES (9, 'Еврейская автономная область');
INSERT INTO public.region (id, name) VALUES (10, 'Башкортостан');
INSERT INTO public.region (id, name) VALUES (11, 'Нижегородская область');
INSERT INTO public.region (id, name) VALUES (12, 'Оренбургская область');
INSERT INTO public.region (id, name) VALUES (13, 'Пермский край');
INSERT INTO public.region (id, name) VALUES (14, 'Самарская область');
INSERT INTO public.region (id, name) VALUES (15, 'Саратовская область');
INSERT INTO public.region (id, name) VALUES (16, 'Татарстан');
INSERT INTO public.region (id, name) VALUES (17, 'Забайкальский край');
INSERT INTO public.region (id, name) VALUES (18, 'Бурятия');
INSERT INTO public.region (id, name) VALUES (19, 'Алтайский край');
INSERT INTO public.region (id, name) VALUES (20, 'Иркутская область');
INSERT INTO public.region (id, name) VALUES (21, 'Республика Хакасия');
INSERT INTO public.region (id, name) VALUES (22, 'Кемеровская область');
INSERT INTO public.region (id, name) VALUES (23, 'Красноярский край');
INSERT INTO public.region (id, name) VALUES (24, 'Новосибирская область');
INSERT INTO public.region (id, name) VALUES (25, 'Омская область');
INSERT INTO public.region (id, name) VALUES (26, 'Томская область');
INSERT INTO public.region (id, name) VALUES (27, 'Курганская область');
INSERT INTO public.region (id, name) VALUES (28, 'Ханты-Мансийский АО - Югра АО');
INSERT INTO public.region (id, name) VALUES (116, 'Карелия');
INSERT INTO public.region (id, name) VALUES (115, 'Карачаево-Черкесская республика');
INSERT INTO public.region (id, name) VALUES (114, 'Калининградская область');
INSERT INTO public.region (id, name) VALUES (113, 'Кабардино-Балкарская республика');
INSERT INTO public.region (id, name) VALUES (112, 'Ингушетия');
INSERT INTO public.region (id, name) VALUES (111, 'Ивановская область');
INSERT INTO public.region (id, name) VALUES (110, 'Владимирская область');
INSERT INTO public.region (id, name) VALUES (109, 'Брянская область');
INSERT INTO public.region (id, name) VALUES (108, 'Белгородская область');
INSERT INTO public.region (id, name) VALUES (107, 'Астраханская область');
INSERT INTO public.region (id, name) VALUES (106, 'Архангельская область');
INSERT INTO public.region (id, name) VALUES (105, 'Ярославская область');
INSERT INTO public.region (id, name) VALUES (104, 'Ямало-Ненецкий АО');
INSERT INTO public.region (id, name) VALUES (103, 'Чукотский АО');
INSERT INTO public.region (id, name) VALUES (102, 'Чувашская республика');
INSERT INTO public.region (id, name) VALUES (101, 'Чеченская республика');
INSERT INTO public.region (id, name) VALUES (100, 'Ненецкий АО');
INSERT INTO public.region (id, name) VALUES (99, 'Мурманская область');
INSERT INTO public.region (id, name) VALUES (98, 'Московская область');
INSERT INTO public.region (id, name) VALUES (97, 'Мордовия');
INSERT INTO public.region (id, name) VALUES (96, 'Марий Эл');
INSERT INTO public.region (id, name) VALUES (95, 'Магаданская область');
INSERT INTO public.region (id, name) VALUES (94, 'Липецкая область');
INSERT INTO public.region (id, name) VALUES (93, 'Ленинградская область');
INSERT INTO public.region (id, name) VALUES (92, 'Курская область');
INSERT INTO public.region (id, name) VALUES (91, 'Калужская область');
INSERT INTO public.region (id, name) VALUES (90, 'Калмыкия');
INSERT INTO public.region (id, name) VALUES (89, 'Дагестан');
INSERT INTO public.region (id, name) VALUES (88, 'Воронежская область');
INSERT INTO public.region (id, name) VALUES (87, 'Вологодская область');
INSERT INTO public.region (id, name) VALUES (86, 'Волгоградская область');
INSERT INTO public.region (id, name) VALUES (85, 'Алтай');
INSERT INTO public.region (id, name) VALUES (84, 'Адыгея');
INSERT INTO public.region (id, name) VALUES (117, 'Кировская область');
INSERT INTO public.region (id, name) VALUES (118, 'Костромская область');
INSERT INTO public.region (id, name) VALUES (119, 'Краснодарский край');
INSERT INTO public.region (id, name) VALUES (120, 'Новгородская область');
INSERT INTO public.region (id, name) VALUES (121, 'Орловская область');
INSERT INTO public.region (id, name) VALUES (122, 'Пензенская область');
INSERT INTO public.region (id, name) VALUES (123, 'Псковская область');
INSERT INTO public.region (id, name) VALUES (124, 'Республика Коми');
INSERT INTO public.region (id, name) VALUES (125, 'Республика Крым');
INSERT INTO public.region (id, name) VALUES (126, 'Республика Саха, Якутия');
INSERT INTO public.region (id, name) VALUES (127, 'Ростовская область');
INSERT INTO public.region (id, name) VALUES (128, 'Рязанская область');
INSERT INTO public.region (id, name) VALUES (129, 'Северная Осетия - Алания');
INSERT INTO public.region (id, name) VALUES (130, 'Смоленская область');
INSERT INTO public.region (id, name) VALUES (131, 'Ставропольский край');
INSERT INTO public.region (id, name) VALUES (132, 'Тамбовская область');
INSERT INTO public.region (id, name) VALUES (133, 'Тверская область');
INSERT INTO public.region (id, name) VALUES (134, 'Тульская область');
INSERT INTO public.region (id, name) VALUES (135, 'Тыва');
INSERT INTO public.region (id, name) VALUES (136, 'Удмуртская республика');
INSERT INTO public.region (id, name) VALUES (137, 'Ульяновская область');


-- Completed on 2018-08-02 15:15:51

--
-- PostgreSQL database dump complete
--

