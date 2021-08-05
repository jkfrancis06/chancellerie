--
-- PostgreSQL database dump
--

-- Dumped from database version 13.3
-- Dumped by pg_dump version 13.3

-- Started on 2021-08-05 19:14:25 EAT

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

--
-- TOC entry 3577 (class 0 OID 16469)
-- Dependencies: 222
-- Data for Name: corps; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.corps (id, intitule, description) FROM stdin;
2	GN	Gendarmerie Nationale
3	ETAT-MAJOR	Etat Major
4	FCD	Force Comoriennes de defence
5	GCC	Gardes Cotes Comoriennes
6	GSHP	GSHP
7	SSM	Service Sante Militaire
8	ENFAG	ENFAG
\.


--
-- TOC entry 3578 (class 0 OID 16477)
-- Dependencies: 223
-- Data for Name: grade_categorie; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.grade_categorie (id, intitule) FROM stdin;
1	Officiers Generaux
2	Officiers superieurs
3	Officiers subalternes
4	Sous-officiers superieurs
5	Sous-officiers sulbaternes
6	Militaires de rang
7	Officier mariniers superieurs
8	Officiers mariniers subalternes
\.


--
-- TOC entry 3575 (class 0 OID 16452)
-- Dependencies: 220
-- Data for Name: grade; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.grade (id, grade_categorie_id, intitule, description) FROM stdin;
1	1	AL	Amiral
2	1	VAE	Vice-Amiral d'escadre
3	1	VA	Vice-amiral
4	1	CA	Contre-amiral
5	1	GDA	General d'armee
6	1	GCA	General de corps d'armee
7	1	GDI	General de division
8	1	GBR	General de brigade
9	2	CV	Capitaine de vaisseau
10	2	CF	Capitaine de fregate
11	2	CC	Captaine de corvette
12	2	COL	Colonel
13	2	LCL	Lieutenant-colonel
14	2	CDT	Commadant
15	2	CBA	Chef de baitaillon
16	2	CEN	Chef d'escadrons
17	2	CES	Chef d'escadron
18	3	CNE	Capitaine
19	3	LTN	Lieutenant
20	3	SLT	Sous-lieutenant
21	3	ASP	Aspirant
22	3	EO	Eleves officiers
23	4	MAJ	Major
24	4	ADC	Adjudant-chef
25	4	ADJ	Adjudant
26	5	SCH	Sergent-chef
27	5	MCH	Marechal des logis-chef
28	5	SGT	Sergent
29	5	MDL	Marechal des logis
30	6	CCH	Caporal-chef
31	6	BCH	Brigadier-chef
32	6	CPL	Caporal
33	6	BRI	Brigadier
34	6	1CL	Soldat de premiere classe
35	6	SDT	Soldat
\.


--
-- TOC entry 3572 (class 0 OID 16431)
-- Dependencies: 217
-- Data for Name: logement; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.logement (id, adresse) FROM stdin;
\.


--
-- TOC entry 3580 (class 0 OID 16490)
-- Dependencies: 225
-- Data for Name: origine_recrutement; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.origine_recrutement (id, intitule, description) FROM stdin;
1	SS-OFF DIRECT	SS-OFF DIRECT
2	OF SEMI-DIRECT	OF SEMI-DIRECT
3	SS-OFF RANG	SS-OFF RANG
4	SOUS-OFF	SOUS-OFF
5	OFF	OFF
6	OF SORTANT D'ECOLE	OF SORTANT D'ECOLE
7	SS-OFF SEMI-DIRECT	SS-OFF SEMI-DIRECT
8	OF RANG	OF RANG
9	MDR	MDR
\.


--
-- TOC entry 3576 (class 0 OID 16461)
-- Dependencies: 221
-- Data for Name: specialite; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.specialite (id, intitule, description) FROM stdin;
1	SECURITE RAPPROCHEE	SECURITE RAPPROCHEE
2	CBN	CBN
3	MOBILE	MOBILE
4	DEPARTEMENTALE	DEPARTEMENTALE
5	INFANTERIE	INFANTERIE
6	MATERIEL	MATERIEL
7	TRAIN	TRAIN
8	GENIE	GENIE
9	ADMINISTRATION	ADMINISTRATION
10	TRANSMISSION	TRANSMISSION
11	ARTILLERIE	ARTILLERIE
12	JUDICIAIRE	JUDICIAIRE
\.


--
-- TOC entry 3588 (class 0 OID 16560)
-- Dependencies: 233
-- Data for Name: militaire; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.militaire (id, grade_id, specialite_id, origine_recrutement_id, logement_id, matricule, nom, prenoms, date_naissance, sexe, taille, couleur_yeux, situation_matri, adresse, date_incorp, profession_ant, has_children) FROM stdin;
2	2	1	1	\N	2248959	TOTO	TOTO	2021-07-29	h	1.5	Noir	Celibataire	Coulee Moroni	2021-07-29	Test	f
35	2	1	1	\N	123935390	Cicily	Matuszewski	1975-05-16	h	1.99	Maroon	Marie	5 International Circle	1982-05-16	Automation Specialist III	f
36	32	2	7	\N	123257312	Humberto	O'Cannan	1974-11-21	f	2.47	Purple	Marie	74332 Calypso Junction	1978-11-20	Administrative Assistant IV	f
37	26	6	5	\N	123259877	Betti	Leason	1992-01-08	h	2.43	Pink	Celibataire	26627 Pine View Court	1999-01-08	Occupational Therapist	t
\.


--
-- TOC entry 3584 (class 0 OID 16516)
-- Dependencies: 229
-- Data for Name: unite; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.unite (id, corps_id, intitule, description) FROM stdin;
1	2	COMMANDEMENT	COMMANDEMENT
2	3	COMMANDEMENT	COMMANDEMENT
3	4	COMMANDEMENT	COMMANDEMENT
4	4	1ere CIE	1ere CIE
5	4	2eme CIE	2eme CIE
6	4	3eme CIE	3eme CIE
7	4	4eme CIE	4eme CIE
8	4	5eme CIE	5eme CIE
9	4	6eme CIE	6eme CIE
10	4	INT HAHAYA	INT HAHAYA
11	4	CCS	CCS
12	2	GRPGEND NGAZIDJA	GRPGEND NGAZIDJA
13	2	CIGEND NGAZIDJA	CIGEND NGAZIDJA
14	2	EIG MORONI	EIG MORONI
15	2	EIG MDE	EIG MDE
16	2	PIGN NGAZIDJA	PIGN NGAZIDJA
17	2	PIGN ANJOUAN	PIGN ANJOUAN
18	2	GRPGEND MOHELI	GRPGEND MOHELI
19	2	EIG BONOVO	EIG BONOVO
20	5	COMMANDEMENT	COMMANDEMENT
21	5	GCC FLOTILLE	GCC FLOTILLE
22	5	GCC BASE NAVALE	GCC BASE NAVALE
23	5	GCC FUSILLERS MARINS	GCC FUSILLERS MARINS
24	5	UNITE SPECIALISE	UNITE SPECIALISE
25	6	COMMANDEMENT	COMMANDEMENT
26	6	1ere CIE	1ere CIE
27	7	COMMANDEMENT	COMMANDEMENT
28	7	SSM CH MORONI	SSM CH MORONI
29	7	SSM CH ANJOUAN	SSM CH ANJOUAN
30	7	SSM CH MOHELI	SSM CH MOHELI
31	8	COMMANDEMENT	COMMANDEMENT
32	8	DIRECTION	DIRECTION
33	3	CABINET	CABINET
34	3	1er BUREAU	1er BUREAU
35	3	2eme BUREAU	2eme BUREAU
36	3	3eme BUREAU	3eme BUREAU
37	3	4eme BUREAU	4eme BUREAU
38	3	5eme BUREAU	5eme BUREAU
39	3	6eme BUREAU	6eme BUREAU
40	3	CMD ANJOUAN	CMD ANJOUAN
41	3	CMD MOHELI	CMD MOHELI
\.


--
-- TOC entry 3603 (class 0 OID 16673)
-- Dependencies: 248
-- Data for Name: affectation; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.affectation (id, militaire_id, unite_id, date_debut, date_fin, fonction) FROM stdin;
1	36	1	1979-08-01	1984-12-15	Compensation Analyst
2	36	2	1985-02-06	2004-07-15	Help Desk Operator
7	36	1	2021-08-02	2021-08-02	Compensation Analyst
10	36	2	2021-06-10	2021-07-30	Environmental Specialist
11	35	1	2021-04-28	2021-08-01	Compensation Analyst
\.


--
-- TOC entry 3574 (class 0 OID 16444)
-- Dependencies: 219
-- Data for Name: diplome; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.diplome (id, intitule, type) FROM stdin;
1	BEPC	Civil
2	BAC	Civil
3	BAC+1	Civil
4	BAC+2	Civil
5	BAC+3	Civil
6	BAC+5	Civil
7	BAC+7	Civil
\.


--
-- TOC entry 3606 (class 0 OID 32944)
-- Dependencies: 251
-- Data for Name: exercice; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.exercice (id, intitule, lieu, commentaire) FROM stdin;
1	SERPENTEX	Comores	SERPENTEX
2	NOBLE JUMP II	Bulgarie et Roumanie	NOBLE JUMP II
3	SUMMER SHIELD	Lettonie	SUMMER SHIELD
4	FLAMING THUNDER	Lituanie	FLAMING THUNDER
5	BALTOPS	Pologne et mer Baltique	BALTOPS
6	SABER STRIKE	Estonie, Lettonie, Lituanie et Pologne	SABER STRIKE
7	IRON WOLF	Lituanie	IRON WOLF
8	DYNAMIC MONGOOSE	Islande	DYNAMIC MONGOOSE
\.


--
-- TOC entry 3607 (class 0 OID 32953)
-- Dependencies: 252
-- Data for Name: exercice_militaire; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.exercice_militaire (exercice_id, militaire_id) FROM stdin;
1	36
\.


--
-- TOC entry 3579 (class 0 OID 16482)
-- Dependencies: 224
-- Data for Name: famille; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.famille (id, nom, prenom, type_filiation, commentaire, militaire_id) FROM stdin;
1	Minda	Kalkofen	2	\N	36
2	Kandace	Smewings	0	\N	36
6	Danice	Kalkofen	1	\N	36
7	Melony	Late	4	\N	36
8	Prent	Winridge	4	\N	36
\.


--
-- TOC entry 3599 (class 0 OID 16641)
-- Dependencies: 244
-- Data for Name: famille_militaire; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.famille_militaire (famille_id, militaire_id) FROM stdin;
\.


--
-- TOC entry 3573 (class 0 OID 16436)
-- Dependencies: 218
-- Data for Name: mission; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.mission (id, type, lieu, commentaire, logo_id, intitule) FROM stdin;
3	Exterieure	Tchad	Opération lancée pendant le conflit tchado-libyen pour soutenir le président Hissène Habré. Elle devient ensuite une mission de protection des ressortissants français et de coopération avec l'armée tchadienne. Elle est remplacée en 2014 par l'opération Barkhane	39	Épervier
4	Exterieure	Afghanistan	Participation de la Marine nationale à la phase initiale de Enduring Freedom. Participation de l'Armée de l'air française dès la phase initiale en deux détachements : Héraclès Sud positionné aux Émirats arabes unis sur la base aérienne Al Dhafra avec deux Mirage IVP et deux ravitailleurs C-135FR, chargés du recueil photographique stratégique au profit du commandement américain ; et Héraclès Nord positionné au Tadjikistan, sur la base de Douchanbé.	40	Héraclès
5	Exterieure	Afghanistan	Participation des forces françaises à la formation de l'Armée nationale afghane sur demande du gouvernement afghan.	41	Épidote
6	Exterieure	Côte d'Ivoire	Intervention pour mettre fin à la crise politico-militaire en Côte d'Ivoire. Surveillance de la ligne de front	42	Licorne
7	Exterieure	République centrafricaine	Opération française en République centrafricaine de 2002 à 2013	43	Boali
\.


--
-- TOC entry 3601 (class 0 OID 16658)
-- Dependencies: 246
-- Data for Name: militaire_mission; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.militaire_mission (id, militaire_id, mission_id, date_debut, date_fin, commentaire) FROM stdin;
1	36	3	1981-07-07	1981-12-26	Tchad
2	36	6	1991-08-30	1996-12-20	Cote d'ivoire
3	36	4	2001-07-10	2001-12-01	\N
\.


--
-- TOC entry 3586 (class 0 OID 16533)
-- Dependencies: 231
-- Data for Name: fichier; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.fichier (id, corps_id, nom, type, militaire_id, created_at, militaire_mission_id) FROM stdin;
1	2	telechargement-61017438b0cda.jpg	image	\N	2021-07-28 15:14:00	\N
2	3	610178fc33772.jpg	image	\N	2021-07-28 15:34:20	\N
3	\N	6102d0d7cb267.ico	image	2	2021-07-29 16:01:27	\N
36	\N	6103ac2303437.jpg	image	35	2021-07-30 07:37:07	\N
37	\N	6103ba487ed9e.jpg	image	36	2021-07-30 08:37:28	\N
39	\N	61052606c606b.png	image	\N	2021-07-31 10:29:26	\N
40	\N	610526dd4bb6e.png	image	\N	2021-07-31 10:33:01	\N
41	\N	610527012123c.png	image	\N	2021-07-31 10:33:37	\N
42	\N	61052724e8a3c.png	image	\N	2021-07-31 10:34:12	\N
43	\N	6105279de6b7a.png	image	\N	2021-07-31 10:36:13	\N
44	\N	610bf32400df2.jpg	image	37	2021-08-05 14:18:12	\N
45	4	610c016a5f72e.jpg	image	\N	2021-08-05 15:19:06	\N
46	5	610c018936f03.jpg	image	\N	2021-08-05 15:19:37	\N
47	6	610c01a17a8ca.jpg	image	\N	2021-08-05 15:20:01	\N
48	7	610c01b49735b.jpg	image	\N	2021-08-05 15:20:20	\N
49	8	610c01bfd5e74.jpg	image	\N	2021-08-05 15:20:31	\N
\.


--
-- TOC entry 3602 (class 0 OID 16668)
-- Dependencies: 247
-- Data for Name: fonction; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.fonction (id, intitule) FROM stdin;
\.


--
-- TOC entry 3585 (class 0 OID 16525)
-- Dependencies: 230
-- Data for Name: formation; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.formation (id, intitule, description, type) FROM stdin;
1	PERFECTIONNEMENT	PERFECTIONNEMENT	Militaire
2	ECOLE DES GUERRES	ECOLE DES GUERRES	Militaire
3	ECOLE MILITAIRE	ECOLE MILITAIRE	Militaire
4	COURS ETAT MAJOR	COURS ETAT MAJOR	Militaire
5	COURS DES CAPITAINES	COURS DES CAPITAINES	Militaire
6	APPLICATION	APPLICATION	Militaire
7	ACADEMIE MILITAIRE	ACADEMIE MILITAIRE	Militaire
\.


--
-- TOC entry 3582 (class 0 OID 16503)
-- Dependencies: 227
-- Data for Name: medaille; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.medaille (id, designation) FROM stdin;
1	LÉGION D’HONNEUR
2	CROIX DE LA LIBÉRATION
3	MÉDAILLE MILITAIRE
4	ORDRE NATIONAL du MÉRITE
5	CROIX de GUERRE 1914-1918
6	CROIX de GUERRE 1939-1945
7	CROIX de GUERRE des THÉÂTRES d’OPÉRATIONS EXTÉRIEURES
8	CROIX de la VALEUR MILITAIRE
9	MÉDAILLE de la GENDARMERIE NATIONALE
10	MÉDAILLE de la RÉSISTANCE
11	PALMES ACADÉMIQUES
12	MÉRITE AGRICOLE
13	MÉRITE MARITIME
14	ARTS ET LETTRES
15	MÉDAILLE des ÉVADÉS
16	CROIX du COMBATTANT VOLONTAIRE 1914-1918
17	CROIX du COMBATTANT VOLONTAIRE
18	CROIX du COMBATTANT VOLONTAIRE de la RÉSISTANCE
19	CROIX du COMBATTANT
20	MÉDAILLE de l’AÉRONAUTIQUE
21	MÉDAILLE d’OR de la  DÉFENSE NATIONALE pour CITATION sans Croix
22	MÉDAILLE de la DÉFENSE NATIONALE
\.


--
-- TOC entry 3600 (class 0 OID 16648)
-- Dependencies: 245
-- Data for Name: militaire_diplome; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.militaire_diplome (id, militaire_id, diplome_id, date_obtention, commentaire) FROM stdin;
\.


--
-- TOC entry 3609 (class 0 OID 32972)
-- Dependencies: 254
-- Data for Name: militaire_exercice; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.militaire_exercice (id, militaire_id, exercice_id, date, commentaire) FROM stdin;
1	36	3	1980-07-03	Exercice
2	36	8	2021-08-02	Ex
\.


--
-- TOC entry 3604 (class 0 OID 16690)
-- Dependencies: 249
-- Data for Name: militaire_fonction; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.militaire_fonction (id, militaire_id, fonction_id, date_debut, date_fin) FROM stdin;
\.


--
-- TOC entry 3610 (class 0 OID 32990)
-- Dependencies: 255
-- Data for Name: militaire_formation; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.militaire_formation (id, militaire_id, formation_id, date_debut, date_fin, lieu, statut) FROM stdin;
21	36	1	2021-08-06	2021-08-07	Comores	0
\.


--
-- TOC entry 3598 (class 0 OID 16631)
-- Dependencies: 243
-- Data for Name: militaire_medaille; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.militaire_medaille (id, militaire_id, medaille_id, date, commentaire) FROM stdin;
1	36	20	1989-08-11	Medaille
2	36	1	1994-01-07	Legion
\.


--
-- TOC entry 3597 (class 0 OID 16621)
-- Dependencies: 242
-- Data for Name: militaire_statut; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.militaire_statut (id, militaire_id, commentaire, date_debut, date_fin, statut) FROM stdin;
4	35	En service	1982-05-16	2021-08-03	3
5	35	Radie	2021-09-07	\N	1
6	36	En service	1978-11-11	\N	3
7	37	En service	1999-01-08	2021-08-05	3
\.


--
-- TOC entry 3581 (class 0 OID 16498)
-- Dependencies: 226
-- Data for Name: statut; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.statut (id, intitule) FROM stdin;
\.


--
-- TOC entry 3583 (class 0 OID 16511)
-- Dependencies: 228
-- Data for Name: telephone; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.telephone (id, numero, militaire_id) FROM stdin;
1	3797779	2
34	8961652689	35
35	7227208617	36
36	6727911841	37
\.


--
-- TOC entry 3556 (class 0 OID 16390)
-- Dependencies: 201
-- Data for Name: utilisateur; Type: TABLE DATA; Schema: public; Owner: admin
--

COPY public.utilisateur (id, email, roles, password, last_login, last_login_hu_re, is_active, is_deleted, name, created_at) FROM stdin;
1	admin@admin.km	["ROLE_CHAN","ROLE_ADMIN"]	$2y$13$dSo720KqjePKWrUemzLOEexRCEFu/QwTUt.O1KQZIWBKjPPMDnr9K	\N	\N	t	f	Admin DB	2021-07-27 15:16:04
\.


--
-- TOC entry 3616 (class 0 OID 0)
-- Dependencies: 239
-- Name: affectation_id_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.affectation_id_seq', 11, true);


--
-- TOC entry 3617 (class 0 OID 0)
-- Dependencies: 207
-- Name: corps_id_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.corps_id_seq', 8, true);


--
-- TOC entry 3618 (class 0 OID 0)
-- Dependencies: 204
-- Name: diplome_id_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.diplome_id_seq', 7, true);


--
-- TOC entry 3619 (class 0 OID 0)
-- Dependencies: 250
-- Name: exercice_id_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.exercice_id_seq', 8, true);


--
-- TOC entry 3620 (class 0 OID 0)
-- Dependencies: 209
-- Name: famille_id_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.famille_id_seq', 8, true);


--
-- TOC entry 3621 (class 0 OID 0)
-- Dependencies: 216
-- Name: fichier_id_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.fichier_id_seq', 49, true);


--
-- TOC entry 3622 (class 0 OID 0)
-- Dependencies: 238
-- Name: fonction_id_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.fonction_id_seq', 1, false);


--
-- TOC entry 3623 (class 0 OID 0)
-- Dependencies: 215
-- Name: formation_id_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.formation_id_seq', 7, true);


--
-- TOC entry 3624 (class 0 OID 0)
-- Dependencies: 208
-- Name: grade_categorie_id_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.grade_categorie_id_seq', 8, true);


--
-- TOC entry 3625 (class 0 OID 0)
-- Dependencies: 205
-- Name: grade_id_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.grade_id_seq', 35, true);


--
-- TOC entry 3626 (class 0 OID 0)
-- Dependencies: 202
-- Name: logement_id_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.logement_id_seq', 1, false);


--
-- TOC entry 3627 (class 0 OID 0)
-- Dependencies: 212
-- Name: medaille_id_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.medaille_id_seq', 22, true);


--
-- TOC entry 3628 (class 0 OID 0)
-- Dependencies: 236
-- Name: militaire_diplome_id_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.militaire_diplome_id_seq', 1, false);


--
-- TOC entry 3629 (class 0 OID 0)
-- Dependencies: 253
-- Name: militaire_exercice_id_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.militaire_exercice_id_seq', 7, true);


--
-- TOC entry 3630 (class 0 OID 0)
-- Dependencies: 241
-- Name: militaire_fonction_id_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.militaire_fonction_id_seq', 1, false);


--
-- TOC entry 3631 (class 0 OID 0)
-- Dependencies: 240
-- Name: militaire_formation_id_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.militaire_formation_id_seq', 21, true);


--
-- TOC entry 3632 (class 0 OID 0)
-- Dependencies: 232
-- Name: militaire_id_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.militaire_id_seq', 37, true);


--
-- TOC entry 3633 (class 0 OID 0)
-- Dependencies: 235
-- Name: militaire_medaille_id_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.militaire_medaille_id_seq', 2, true);


--
-- TOC entry 3634 (class 0 OID 0)
-- Dependencies: 237
-- Name: militaire_mission_id_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.militaire_mission_id_seq', 3, true);


--
-- TOC entry 3635 (class 0 OID 0)
-- Dependencies: 234
-- Name: militaire_statut_id_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.militaire_statut_id_seq', 7, true);


--
-- TOC entry 3636 (class 0 OID 0)
-- Dependencies: 203
-- Name: mission_id_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.mission_id_seq', 7, true);


--
-- TOC entry 3637 (class 0 OID 0)
-- Dependencies: 210
-- Name: origine_recrutement_id_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.origine_recrutement_id_seq', 9, true);


--
-- TOC entry 3638 (class 0 OID 0)
-- Dependencies: 206
-- Name: specialite_id_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.specialite_id_seq', 12, true);


--
-- TOC entry 3639 (class 0 OID 0)
-- Dependencies: 211
-- Name: statut_id_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.statut_id_seq', 1, false);


--
-- TOC entry 3640 (class 0 OID 0)
-- Dependencies: 213
-- Name: telephone_id_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.telephone_id_seq', 36, true);


--
-- TOC entry 3641 (class 0 OID 0)
-- Dependencies: 214
-- Name: unite_id_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.unite_id_seq', 41, true);


--
-- TOC entry 3642 (class 0 OID 0)
-- Dependencies: 200
-- Name: utilisateur_id_seq; Type: SEQUENCE SET; Schema: public; Owner: admin
--

SELECT pg_catalog.setval('public.utilisateur_id_seq', 1, true);


-- Completed on 2021-08-05 19:14:26 EAT

--
-- PostgreSQL database dump complete
--

