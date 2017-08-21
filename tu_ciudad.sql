-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-07-2017 a las 23:39:20
-- Versión del servidor: 10.1.24-MariaDB
-- Versión de PHP: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdd_miciudad`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(10) NOT NULL,
  `nombre` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `imagen` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_ingreso` datetime DEFAULT NULL,
  `estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `imagen`, `fecha_ingreso`, `estado`) VALUES
(1, 'Cat', '59669a1b700e3.jpg', '2017-07-12 12:37:17', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

CREATE TABLE `contacto` (
  `id` int(10) NOT NULL,
  `primer_nombre` char(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `segundo_nombre` char(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `apellido_paterno` char(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `apellido_materno` char(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `correo` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cargo` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `observacion` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `imagen` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_ingreso` datetime DEFAULT NULL,
  `estado` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `contacto`
--

INSERT INTO `contacto` (`id`, `primer_nombre`, `segundo_nombre`, `apellido_paterno`, `apellido_materno`, `correo`, `telefono`, `cargo`, `observacion`, `imagen`, `fecha_ingreso`, `estado`) VALUES
(6, 'Guillermo', 'Qwerty', 'Astudillo', 'Salazar', 'test@test.cl', '12312312312', 'Ghjghj', '', '5927469781010.jpg', '2017-03-29 11:17:13', 1),
(10, 'Maickol', 'Maickol 2', 'Mellado', '', 'test@test.cl', '123123123123', 'Sadasdas', '', '5930240d09bd6.jpg', '2017-03-30 16:46:10', 1),
(12, 'Nombre', '', 'Apellido', '', 'test@test.cl', '12312312312', 'Qweqweq', '', '5916331ec3a43.jpg', '2017-05-12 19:11:42', 1),
(13, 'Qweqwe', '', 'Werwewer', '', 'werwer@qweqwe.cl', '12312312312', 'Qweqweq', '', '5916333fa077c.jpg', '2017-05-12 19:12:15', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contac_empre`
--

CREATE TABLE `contac_empre` (
  `id` int(10) NOT NULL,
  `fk_contacto` int(10) DEFAULT NULL,
  `fk_empresa` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `contac_empre`
--

INSERT INTO `contac_empre` (`id`, `fk_contacto`, `fk_empresa`) VALUES
(21, 12, 12),
(34, 13, 2),
(39, 6, 2),
(40, 13, 14),
(43, 10, 14),
(46, 6, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `def_comuna`
--

CREATE TABLE `def_comuna` (
  `com_id_pk` int(10) UNSIGNED ZEROFILL NOT NULL,
  `com_provincia_fk` int(10) UNSIGNED ZEROFILL DEFAULT NULL,
  `com_nombre` char(25) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `def_comuna`
--

INSERT INTO `def_comuna` (`com_id_pk`, `com_provincia_fk`, `com_nombre`) VALUES
(0000000001, 0000000001, 'ARICA'),
(0000000002, 0000000001, 'CAMARONES'),
(0000000003, 0000000002, 'PUTRE'),
(0000000004, 0000000002, 'GENERAL LAGOS'),
(0000000005, 0000000003, 'IQUIQUE'),
(0000000006, 0000000003, 'ALTO HOSPICIO'),
(0000000007, 0000000004, 'POZO ALMONTE'),
(0000000008, 0000000004, 'CAMIÑA'),
(0000000009, 0000000004, 'COLCHANE'),
(0000000010, 0000000004, 'HUARA'),
(0000000011, 0000000004, 'PICA'),
(0000000012, 0000000005, 'ANTOFAGASTA'),
(0000000013, 0000000005, 'MEJILLONES'),
(0000000014, 0000000005, 'SIERRA GORDA'),
(0000000015, 0000000005, 'TALTAL'),
(0000000016, 0000000006, 'CALAMA'),
(0000000017, 0000000006, 'OLLAGÜE'),
(0000000018, 0000000006, 'SAN PEDRO DE ATACAMA'),
(0000000019, 0000000007, 'TOCOPILLA'),
(0000000020, 0000000007, 'MARÍA ELENA'),
(0000000021, 0000000008, 'COPIAPÓ'),
(0000000022, 0000000008, 'CALDERA'),
(0000000023, 0000000008, 'TIERRA AMARILLA'),
(0000000024, 0000000009, 'CHAÑARAL'),
(0000000025, 0000000009, 'DIEGO DE ALMAGRO'),
(0000000026, 0000000010, 'VALLENAR'),
(0000000027, 0000000010, 'ALTO DEL CARMEN'),
(0000000028, 0000000010, 'FREIRINA'),
(0000000029, 0000000010, 'HUASCO'),
(0000000030, 0000000011, 'LA SERENA'),
(0000000031, 0000000011, 'COQUIMBO'),
(0000000032, 0000000011, 'ANDACOLLO'),
(0000000033, 0000000011, 'LA HIGUERA'),
(0000000034, 0000000011, 'PAIGUANO'),
(0000000035, 0000000011, 'VICUÑA'),
(0000000036, 0000000012, 'ILLAPEL'),
(0000000037, 0000000012, 'CANELA'),
(0000000038, 0000000012, 'LOS VILOS'),
(0000000039, 0000000012, 'SALAMANCA'),
(0000000040, 0000000013, 'OVALLE'),
(0000000041, 0000000013, 'COMBARBALÁ'),
(0000000042, 0000000013, 'MONTE PATRIA'),
(0000000043, 0000000013, 'PUNITAQUI'),
(0000000044, 0000000013, 'RÍO HURTADO'),
(0000000045, 0000000014, 'VALPARAÍSO'),
(0000000046, 0000000014, 'CASABLANCA'),
(0000000047, 0000000014, 'CONCÓN'),
(0000000048, 0000000014, 'JUAN FERNÁNDEZ'),
(0000000049, 0000000014, 'PUCHUNCAVÍ'),
(0000000050, 0000000014, 'QUINTERO'),
(0000000051, 0000000014, 'VIÑA DEL MAR'),
(0000000052, 0000000015, 'ISLA DE PASCUA'),
(0000000053, 0000000016, 'LOS ANDES'),
(0000000054, 0000000016, 'CALLE LARGA'),
(0000000055, 0000000016, 'RINCONADA'),
(0000000056, 0000000016, 'SAN ESTEBAN'),
(0000000057, 0000000017, 'LA LIGUA'),
(0000000058, 0000000017, 'CABILDO'),
(0000000059, 0000000017, 'PAPUDO'),
(0000000060, 0000000017, 'PETORCA'),
(0000000061, 0000000017, 'ZAPALLAR'),
(0000000062, 0000000018, 'QUILLOTA'),
(0000000063, 0000000018, 'CALERA'),
(0000000064, 0000000018, 'HIJUELAS'),
(0000000065, 0000000018, 'LA CRUZ'),
(0000000066, 0000000018, 'NOGALES'),
(0000000067, 0000000019, 'SAN ANTONIO'),
(0000000068, 0000000019, 'ALGARROBO'),
(0000000069, 0000000019, 'CARTAGENA'),
(0000000070, 0000000019, 'EL QUISCO'),
(0000000071, 0000000019, 'EL TABO'),
(0000000072, 0000000019, 'SANTO DOMINGO'),
(0000000073, 0000000020, 'SAN FELIPE'),
(0000000074, 0000000020, 'CATEMU'),
(0000000075, 0000000020, 'LLAILLAY'),
(0000000076, 0000000020, 'PANQUEHUE'),
(0000000077, 0000000020, 'PUTAENDO'),
(0000000078, 0000000020, 'SANTA MARÍA'),
(0000000079, 0000000021, 'LIMACHE'),
(0000000080, 0000000021, 'QUILPUÉ'),
(0000000081, 0000000021, 'VILLA ALEMANA'),
(0000000082, 0000000021, 'OLMUÉ'),
(0000000083, 0000000022, 'RANCAGUA'),
(0000000084, 0000000022, 'CODEGUA'),
(0000000085, 0000000022, 'COINCO'),
(0000000086, 0000000022, 'COLTAUCO'),
(0000000087, 0000000022, 'DOÑIHUE'),
(0000000088, 0000000022, 'GRANEROS'),
(0000000089, 0000000022, 'LAS CABRAS'),
(0000000090, 0000000022, 'MACHALÍ'),
(0000000091, 0000000022, 'MALLOA'),
(0000000092, 0000000022, 'MOSTAZAL'),
(0000000093, 0000000022, 'OLIVAR'),
(0000000094, 0000000022, 'PEUMO'),
(0000000095, 0000000022, 'PICHIDEGUA'),
(0000000096, 0000000022, 'QUINTA DE TILCOCO'),
(0000000097, 0000000022, 'RENGO'),
(0000000098, 0000000022, 'REQUÍNOA'),
(0000000099, 0000000022, 'SAN VICENTE'),
(0000000100, 0000000023, 'PICHILEMU'),
(0000000101, 0000000023, 'LA ESTRELLA'),
(0000000102, 0000000023, 'LITUECHE'),
(0000000103, 0000000023, 'MARCHIHUE'),
(0000000104, 0000000023, 'NAVIDAD'),
(0000000105, 0000000023, 'PAREDONES'),
(0000000106, 0000000024, 'SAN FERNANDO'),
(0000000107, 0000000024, 'CHÉPICA'),
(0000000108, 0000000024, 'CHIMBARONGO'),
(0000000109, 0000000024, 'LOLOL'),
(0000000110, 0000000024, 'NANCAGUA'),
(0000000111, 0000000024, 'PALMILLA'),
(0000000112, 0000000024, 'PERALILLO'),
(0000000113, 0000000024, 'PLACILLA'),
(0000000114, 0000000024, 'PUMANQUE'),
(0000000115, 0000000024, 'SANTA CRUZ'),
(0000000116, 0000000025, 'TALCA'),
(0000000117, 0000000025, 'CONSTITUCIÓN'),
(0000000118, 0000000025, 'CUREPTO'),
(0000000119, 0000000025, 'EMPEDRADO'),
(0000000120, 0000000025, 'MAULE'),
(0000000121, 0000000025, 'PELARCO'),
(0000000122, 0000000025, 'PENCAHUE'),
(0000000123, 0000000025, 'RÍO CLARO'),
(0000000124, 0000000025, 'SAN CLEMENTE'),
(0000000125, 0000000025, 'SAN RAFAEL'),
(0000000126, 0000000026, 'CAUQUENES'),
(0000000127, 0000000026, 'CHANCO'),
(0000000128, 0000000026, 'PELLUHUE'),
(0000000129, 0000000027, 'CURICÓ'),
(0000000130, 0000000027, 'HUALAÑÉ'),
(0000000131, 0000000027, 'LICANTÉN'),
(0000000132, 0000000027, 'MOLINA'),
(0000000133, 0000000027, 'RAUCO'),
(0000000134, 0000000027, 'ROMERAL'),
(0000000135, 0000000027, 'SAGRADA FAMILIA'),
(0000000136, 0000000027, 'TENO'),
(0000000137, 0000000027, 'VICHUQUÉN'),
(0000000138, 0000000028, 'LINARES'),
(0000000139, 0000000028, 'COLBÚN'),
(0000000140, 0000000028, 'LONGAVÍ'),
(0000000141, 0000000028, 'PARRAL'),
(0000000142, 0000000028, 'RETIRO'),
(0000000143, 0000000028, 'SAN JAVIER'),
(0000000144, 0000000028, 'VILLA ALEGRE'),
(0000000145, 0000000028, 'YERBAS BUENAS'),
(0000000146, 0000000029, 'CONCEPCIÓN'),
(0000000147, 0000000029, 'CORONEL'),
(0000000148, 0000000029, 'CHIGUAYANTE'),
(0000000149, 0000000029, 'FLORIDA'),
(0000000150, 0000000029, 'HUALQUI'),
(0000000151, 0000000029, 'LOTA'),
(0000000152, 0000000029, 'PENCO'),
(0000000153, 0000000029, 'SAN PEDRO DE LA PAZ'),
(0000000154, 0000000029, 'SANTA JUANA'),
(0000000155, 0000000029, 'TALCAHUANO'),
(0000000156, 0000000029, 'TOMÉ'),
(0000000157, 0000000029, 'HUALPÉN'),
(0000000158, 0000000030, 'LEBU'),
(0000000159, 0000000030, 'ARAUCO'),
(0000000160, 0000000030, 'CAÑETE'),
(0000000161, 0000000030, 'CONTULMO'),
(0000000162, 0000000030, 'CURANILAHUE'),
(0000000163, 0000000030, 'LOS ALAMOS'),
(0000000164, 0000000030, 'TIRÚA'),
(0000000165, 0000000031, 'LOS ANGELES'),
(0000000166, 0000000031, 'ANTUCO'),
(0000000167, 0000000031, 'CABRERO'),
(0000000168, 0000000031, 'LAJA'),
(0000000169, 0000000031, 'MULCHÉN'),
(0000000170, 0000000031, 'NACIMIENTO'),
(0000000171, 0000000031, 'NEGRETE'),
(0000000172, 0000000031, 'QUILACO'),
(0000000173, 0000000031, 'QUILLECO'),
(0000000174, 0000000031, 'SAN ROSENDO'),
(0000000175, 0000000031, 'SANTA BÁRBARA'),
(0000000176, 0000000031, 'TUCAPEL'),
(0000000177, 0000000031, 'YUMBEL'),
(0000000178, 0000000031, 'ALTO BIOBÍO'),
(0000000179, 0000000032, 'CHILLÁN'),
(0000000180, 0000000032, 'BULNES'),
(0000000181, 0000000032, 'COBQUECURA'),
(0000000182, 0000000032, 'COELEMU'),
(0000000183, 0000000032, 'COIHUECO'),
(0000000184, 0000000032, 'CHILLÁN VIEJO'),
(0000000185, 0000000032, 'EL CARMEN'),
(0000000186, 0000000032, 'NINHUE'),
(0000000187, 0000000032, 'ÑIQUÉN'),
(0000000188, 0000000032, 'PEMUCO'),
(0000000189, 0000000032, 'PINTO'),
(0000000190, 0000000032, 'PORTEZUELO'),
(0000000191, 0000000032, 'QUILLÓN'),
(0000000192, 0000000032, 'QUIRIHUE'),
(0000000193, 0000000032, 'RÁNQUIL'),
(0000000194, 0000000032, 'SAN CARLOS'),
(0000000195, 0000000032, 'SAN FABIÁN'),
(0000000196, 0000000032, 'SAN IGNACIO'),
(0000000197, 0000000032, 'SAN NICOLÁS'),
(0000000198, 0000000032, 'TREGUACO'),
(0000000199, 0000000032, 'YUNGAY'),
(0000000200, 0000000033, 'TEMUCO'),
(0000000201, 0000000033, 'CARAHUE'),
(0000000202, 0000000033, 'CUNCO'),
(0000000203, 0000000033, 'CURARREHUE'),
(0000000204, 0000000033, 'FREIRE'),
(0000000205, 0000000033, 'GALVARINO'),
(0000000206, 0000000033, 'GORBEA'),
(0000000207, 0000000033, 'LAUTARO'),
(0000000208, 0000000033, 'LONCOCHE'),
(0000000209, 0000000033, 'MELIPEUCO'),
(0000000210, 0000000033, 'NUEVA IMPERIAL'),
(0000000211, 0000000033, 'PADRE LAS CASAS'),
(0000000212, 0000000033, 'PERQUENCO'),
(0000000213, 0000000033, 'PITRUFQUÉN'),
(0000000214, 0000000033, 'PUCÓN'),
(0000000215, 0000000033, 'SAAVEDRA'),
(0000000216, 0000000033, 'TEODORO SCHMIDT'),
(0000000217, 0000000033, 'TOLTÉN'),
(0000000218, 0000000033, 'VILCÚN'),
(0000000219, 0000000033, 'VILLARRICA'),
(0000000220, 0000000033, 'CHOLCHOL'),
(0000000221, 0000000034, 'ANGOL'),
(0000000222, 0000000034, 'COLLIPULLI'),
(0000000223, 0000000034, 'CURACAUTÍN'),
(0000000224, 0000000034, 'ERCILLA'),
(0000000225, 0000000034, 'LONQUIMAY'),
(0000000226, 0000000034, 'LOS SAUCES'),
(0000000227, 0000000034, 'LUMACO'),
(0000000228, 0000000034, 'PURÉN'),
(0000000229, 0000000034, 'RENAICO'),
(0000000230, 0000000034, 'TRAIGUÉN'),
(0000000231, 0000000034, 'VICTORIA'),
(0000000232, 0000000035, 'VALDIVIA'),
(0000000233, 0000000035, 'CORRAL'),
(0000000234, 0000000035, 'LANCO'),
(0000000235, 0000000035, 'LOS LAGOS'),
(0000000236, 0000000035, 'MÁFIL'),
(0000000237, 0000000035, 'MARIQUINA'),
(0000000238, 0000000035, 'PAILLACO'),
(0000000239, 0000000035, 'PANGUIPULLI'),
(0000000240, 0000000036, 'LA UNIÓN'),
(0000000241, 0000000036, 'FUTRONO'),
(0000000242, 0000000036, 'LAGO RANCO'),
(0000000243, 0000000036, 'RÍO BUENO'),
(0000000244, 0000000037, 'PUERTO MONTT'),
(0000000245, 0000000037, 'CALBUCO'),
(0000000246, 0000000037, 'COCHAMÓ'),
(0000000247, 0000000037, 'FRESIA'),
(0000000248, 0000000037, 'FRUTILLAR'),
(0000000249, 0000000037, 'LOS MUERMOS'),
(0000000250, 0000000037, 'LLANQUIHUE'),
(0000000251, 0000000037, 'MAULLÍN'),
(0000000252, 0000000037, 'PUERTO VARAS'),
(0000000253, 0000000038, 'CASTRO'),
(0000000254, 0000000038, 'ANCUD'),
(0000000255, 0000000038, 'CHONCHI'),
(0000000256, 0000000038, 'CURACO DE VÉLEZ'),
(0000000257, 0000000038, 'DALCAHUE'),
(0000000258, 0000000038, 'PUQUELDÓN'),
(0000000259, 0000000038, 'QUEILÉN'),
(0000000260, 0000000038, 'QUELLÓN'),
(0000000261, 0000000038, 'QUEMCHI'),
(0000000262, 0000000038, 'QUINCHAO'),
(0000000263, 0000000039, 'OSORNO'),
(0000000264, 0000000039, 'PUERTO OCTAY'),
(0000000265, 0000000039, 'PURRANQUE'),
(0000000266, 0000000039, 'PUYEHUE'),
(0000000267, 0000000039, 'RÍO NEGRO'),
(0000000268, 0000000039, 'SAN JUAN DE LA COSTA'),
(0000000269, 0000000039, 'SAN PABLO'),
(0000000270, 0000000040, 'CHAITÉN'),
(0000000271, 0000000040, 'FUTALEUFÚ'),
(0000000272, 0000000040, 'HUALAIHUÉ'),
(0000000273, 0000000040, 'PALENA'),
(0000000274, 0000000041, 'COIHAIQUE'),
(0000000275, 0000000041, 'LAGO VERDE'),
(0000000276, 0000000042, 'AISÉN'),
(0000000277, 0000000042, 'CISNES'),
(0000000278, 0000000042, 'GUAITECAS'),
(0000000279, 0000000043, 'COCHRANE'),
(0000000280, 0000000043, 'O\'HIGGINS'),
(0000000281, 0000000043, 'TORTEL'),
(0000000282, 0000000044, 'CHILE CHICO'),
(0000000283, 0000000044, 'RÍO IBÁÑEZ'),
(0000000284, 0000000045, 'PUNTA ARENAS'),
(0000000285, 0000000045, 'LAGUNA BLANCA'),
(0000000286, 0000000045, 'RÍO VERDE'),
(0000000287, 0000000045, 'SAN GREGORIO'),
(0000000288, 0000000046, 'CABO DE HORNOS'),
(0000000289, 0000000046, 'ANTÁRTICA'),
(0000000290, 0000000047, 'PORVENIR'),
(0000000291, 0000000047, 'PRIMAVERA'),
(0000000292, 0000000047, 'TIMAUKEL'),
(0000000293, 0000000048, 'NATALES'),
(0000000294, 0000000048, 'TORRES DEL PAINE'),
(0000000295, 0000000049, 'SANTIAGO'),
(0000000296, 0000000049, 'CERRILLOS'),
(0000000297, 0000000049, 'CERRO NAVIA'),
(0000000298, 0000000049, 'CONCHALÍ'),
(0000000299, 0000000049, 'EL BOSQUE'),
(0000000300, 0000000049, 'ESTACIÓN CENTRAL'),
(0000000301, 0000000049, 'HUECHURABA'),
(0000000302, 0000000049, 'INDEPENDENCIA'),
(0000000303, 0000000049, 'LA CISTERNA'),
(0000000304, 0000000049, 'LA FLORIDA'),
(0000000305, 0000000049, 'LA GRANJA'),
(0000000306, 0000000049, 'LA PINTANA'),
(0000000307, 0000000049, 'LA REINA'),
(0000000308, 0000000049, 'LAS CONDES'),
(0000000309, 0000000049, 'LO BARNECHEA'),
(0000000310, 0000000049, 'LO ESPEJO'),
(0000000311, 0000000049, 'LO PRADO'),
(0000000312, 0000000049, 'MACUL'),
(0000000313, 0000000049, 'MAIPÚ'),
(0000000314, 0000000049, 'ÑUÑOA'),
(0000000315, 0000000049, 'PEDRO AGUIRRE CERDA'),
(0000000316, 0000000049, 'PEÑALOLÉN'),
(0000000317, 0000000049, 'PROVIDENCIA'),
(0000000318, 0000000049, 'PUDAHUEL'),
(0000000319, 0000000049, 'QUILICURA'),
(0000000320, 0000000049, 'QUINTA NORMAL'),
(0000000321, 0000000049, 'RECOLETA'),
(0000000322, 0000000049, 'RENCA'),
(0000000323, 0000000049, 'SAN JOAQUÍN'),
(0000000324, 0000000049, 'SAN MIGUEL'),
(0000000325, 0000000049, 'SAN RAMÓN'),
(0000000326, 0000000049, 'VITACURA'),
(0000000327, 0000000050, 'PUENTE ALTO'),
(0000000328, 0000000050, 'PIRQUE'),
(0000000329, 0000000050, 'SAN JOSÉ DE MAIPO'),
(0000000330, 0000000051, 'COLINA'),
(0000000331, 0000000051, 'LAMPA'),
(0000000332, 0000000051, 'TILTIL'),
(0000000333, 0000000052, 'SAN BERNARDO'),
(0000000334, 0000000052, 'BUIN'),
(0000000335, 0000000052, 'CALERA DE TANGO'),
(0000000336, 0000000052, 'PAINE'),
(0000000337, 0000000053, 'MELIPILLA'),
(0000000338, 0000000053, 'ALHUÉ'),
(0000000339, 0000000053, 'CURACAVÍ'),
(0000000340, 0000000053, 'MARÍA PINTO'),
(0000000341, 0000000053, 'SAN PEDRO'),
(0000000342, 0000000054, 'TALAGANTE'),
(0000000343, 0000000054, 'EL MONTE'),
(0000000344, 0000000054, 'ISLA DE MAIPO'),
(0000000345, 0000000054, 'PADRE HURTADO'),
(0000000346, 0000000054, 'PEÑAFLOR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `def_provincia`
--

CREATE TABLE `def_provincia` (
  `pro_id_pk` int(10) UNSIGNED ZEROFILL NOT NULL,
  `pro_region_fk` int(10) UNSIGNED ZEROFILL DEFAULT NULL,
  `pro_nombre` char(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `pro_comunas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `def_provincia`
--

INSERT INTO `def_provincia` (`pro_id_pk`, `pro_region_fk`, `pro_nombre`, `pro_comunas`) VALUES
(0000000001, 0000000001, 'ARICA', 2),
(0000000002, 0000000001, 'PARINACOTA', 2),
(0000000003, 0000000002, 'IQUIQUE', 2),
(0000000004, 0000000002, 'TAMARUGAL', 5),
(0000000005, 0000000003, 'ANTOFAGASTA', 4),
(0000000006, 0000000003, 'EL LOA', 3),
(0000000007, 0000000003, 'TOCOPILLA', 2),
(0000000008, 0000000004, 'COPIAPÓ', 3),
(0000000009, 0000000004, 'CHAÑARAL', 2),
(0000000010, 0000000004, 'HUASCO', 4),
(0000000011, 0000000005, 'ELQUI', 6),
(0000000012, 0000000005, 'CHOAPA', 4),
(0000000013, 0000000005, 'LIMARÍ', 5),
(0000000014, 0000000006, 'VALPARAÍSO', 7),
(0000000015, 0000000006, 'ISLA DE PASCUA', 1),
(0000000016, 0000000006, 'LOS ANDES', 4),
(0000000017, 0000000006, 'PETORCA', 5),
(0000000018, 0000000006, 'QUILLOTA', 5),
(0000000019, 0000000006, 'SAN ANTONIO', 6),
(0000000020, 0000000006, 'SAN FELIPE DE ACONCAGUA', 6),
(0000000021, 0000000006, 'MARGA MARGA', 4),
(0000000022, 0000000007, 'CACHAPOAL', 17),
(0000000023, 0000000007, 'CARDENAL CARO', 6),
(0000000024, 0000000007, 'COLCHAGUA', 10),
(0000000025, 0000000008, 'TALCA', 10),
(0000000026, 0000000008, 'CAUQUENES', 3),
(0000000027, 0000000008, 'CURICÓ', 9),
(0000000028, 0000000008, 'LINARES', 8),
(0000000029, 0000000009, 'CONCEPCIÓN', 12),
(0000000030, 0000000009, 'ARAUCO', 7),
(0000000031, 0000000009, 'BIOBÍO', 14),
(0000000032, 0000000009, 'ÑUBLE', 21),
(0000000033, 0000000010, 'CAUTÍN', 21),
(0000000034, 0000000010, 'MALLECO', 11),
(0000000035, 0000000011, 'VALDIVIA', 8),
(0000000036, 0000000011, 'RANCO', 4),
(0000000037, 0000000012, 'LLANQUIHUE', 9),
(0000000038, 0000000012, 'CHILOÉ', 10),
(0000000039, 0000000012, 'OSORNO', 7),
(0000000040, 0000000012, 'PALENA', 4),
(0000000041, 0000000013, 'COIHAIQUE', 2),
(0000000042, 0000000013, 'AISÉN', 3),
(0000000043, 0000000013, 'CAPITÁN PRAT', 3),
(0000000044, 0000000013, 'GENERAL CARRERA', 2),
(0000000045, 0000000014, 'MAGALLANES', 4),
(0000000046, 0000000014, 'ANTÁRTICA CHILENA', 2),
(0000000047, 0000000014, 'TIERRA DEL FUEGO', 3),
(0000000048, 0000000014, 'ULTIMA ESPERANZA', 2),
(0000000049, 0000000015, 'SANTIAGO', 32),
(0000000050, 0000000015, 'CORDILLERA', 3),
(0000000051, 0000000015, 'CHACABUCO', 3),
(0000000052, 0000000015, 'MAIPO', 4),
(0000000053, 0000000015, 'MELIPILLA', 5),
(0000000054, 0000000015, 'TALAGANTE', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `def_region`
--

CREATE TABLE `def_region` (
  `reg_id_pk` int(10) UNSIGNED ZEROFILL NOT NULL,
  `reg_nombre` char(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `reg_romano` char(4) COLLATE utf8_spanish_ci DEFAULT NULL,
  `reg_provincias` int(11) DEFAULT NULL,
  `reg_comunas` int(11) DEFAULT NULL,
  `reg_orden` int(11) DEFAULT NULL COMMENT 'orden real de regiones'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `def_region`
--

INSERT INTO `def_region` (`reg_id_pk`, `reg_nombre`, `reg_romano`, `reg_provincias`, `reg_comunas`, `reg_orden`) VALUES
(0000000001, 'ARICA Y PARINACOTA', 'XV', 2, 4, NULL),
(0000000002, 'TARAPACÁ', 'I', 2, 7, NULL),
(0000000003, 'ANTOFAGASTA', 'II', 3, 9, NULL),
(0000000004, 'ATACAMA', 'III', 3, 9, NULL),
(0000000005, 'COQUIMBO', 'IV', 3, 15, NULL),
(0000000006, 'VALPARAÍSO', 'V', 8, 38, NULL),
(0000000007, 'DEL LIBERTADOR GRAL. BERNARDO O\'HIGGINS', 'VI', 3, 33, NULL),
(0000000008, 'DEL MAULE', 'VII', 4, 30, NULL),
(0000000009, 'DEL BIOBÍO', 'VIII', 4, 54, NULL),
(0000000010, 'DE LA ARAUCANÍA', 'IX', 2, 32, NULL),
(0000000011, 'DE LOS RÍOS', 'XIV', 2, 12, NULL),
(0000000012, 'DE LOS LAGOS', 'X', 4, 30, NULL),
(0000000013, 'AISÉN DEL GRAL. CARLOS IBAÑEZ DEL CAMPO', 'XI', 4, 10, NULL),
(0000000014, 'MAGALLANES Y DE LA ANTÁRTICA CHILENA', 'XII', 4, 11, NULL),
(0000000015, 'METROPOLITANA DE SANTIAGO', 'RM', 6, 52, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id` int(10) NOT NULL,
  `nombre` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `razonsocial` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rut` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comuna` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `provincia` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `region` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `dir_villa_pbla` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dir_calle` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dir_numero` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dir_numero_departamento` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dir_numero_piso` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefono` int(15) DEFAULT NULL,
  `celular` int(15) DEFAULT NULL,
  `correo` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `web` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `observacion` text COLLATE utf8_unicode_ci,
  `coordenadas` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `imagen` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_ingreso` datetime DEFAULT NULL,
  `estado` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id`, `nombre`, `razonsocial`, `rut`, `comuna`, `provincia`, `region`, `dir_villa_pbla`, `dir_calle`, `dir_numero`, `dir_numero_departamento`, `dir_numero_piso`, `telefono`, `celular`, `correo`, `web`, `observacion`, `coordenadas`, `imagen`, `fecha_ingreso`, `estado`) VALUES
(2, 'Hola', 'Razon', '18.099.961-2', '', '', '', NULL, NULL, NULL, NULL, NULL, 2147483647, NULL, 'test@test.cl', 'test.test', 'Test teset tset test test', '-78877797898, -234346456546', '592593f4e5282.jpg', '2017-03-29 12:04:27', 1),
(12, 'Test', 'Test', '11.111.111-1', '', '', '', NULL, NULL, NULL, NULL, NULL, 2147483647, NULL, 'test@test.cl', 'qweqweqwe.cl', 'Qweqwe', '123123123123, 123123123123', '58e173f438e78.jpg', '2017-04-02 18:58:12', 1),
(13, 'Tuciudad', 'Eduardo ortega', '14.350.983-4', 'comuna', '', '', NULL, NULL, NULL, NULL, NULL, 123456789, NULL, 'ejemplo@ejemplo.cl', 'www.tuciudad.cl', 'Dmdfkdfkdf}dsfsdfsdfsdfsdfdf\r\nsdf  123123123\r\nsdf\r\nsd\r\nfsd', '-365848548, -3584454', '592c3185ae6b1.jpg', '2017-05-17 19:07:19', 1),
(14, 'Fantasia', 'Fantastico, fantasioso', '11.111.111-1', 'Los Angeles', 'Bio-Bio', 'VIII Bio-Bio', 'Villa la Villa', '', '1234', '', '', 123456789, 2147483647, 'test@teset.cl', 'ejemplo.cl', 'Es una nueva empresa de fantasía y pruebas', '', '592efd1b669d7.jpg', '2017-05-31 13:27:55', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etapas`
--

CREATE TABLE `etapas` (
  `id` int(10) NOT NULL,
  `nombre` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `observacion` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `etapas`
--

INSERT INTO `etapas` (`id`, `nombre`, `observacion`) VALUES
(1, 'Sin facturar', NULL),
(2, 'Completado', NULL),
(3, 'Facturado sin pagar', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etapas_produccion`
--

CREATE TABLE `etapas_produccion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) DEFAULT NULL,
  `siglas` varchar(10) DEFAULT NULL,
  `observaciones` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `e_p_producto`
--

CREATE TABLE `e_p_producto` (
  `id` int(11) NOT NULL,
  `etapas_produccion_id` int(11) NOT NULL,
  `pedido_detalle_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(10) NOT NULL,
  `fk_empresa` int(10) DEFAULT NULL,
  `fk_vendedor` int(10) DEFAULT NULL,
  `codigo_pedido` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_ingreso` datetime DEFAULT NULL,
  `valor_bruto` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descuentos` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `valor_neto` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `observacion` text COLLATE utf8_unicode_ci,
  `fecha_modificacion` datetime DEFAULT NULL,
  `fk_etapa` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `fk_empresa`, `fk_vendedor`, `codigo_pedido`, `fecha_ingreso`, `valor_bruto`, `descuentos`, `valor_neto`, `total`, `observacion`, `fecha_modificacion`, `fk_etapa`) VALUES
(1, 12, 1, 'ped-10-17', '2017-05-29 11:20:34', NULL, NULL, NULL, NULL, 'asdasasdasd', NULL, NULL),
(3, 14, 1, NULL, '2017-07-19 13:13:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_detalle`
--

CREATE TABLE `pedido_detalle` (
  `id` int(10) NOT NULL,
  `fk_pedido` int(10) DEFAULT NULL,
  `fk_producto` int(10) DEFAULT NULL,
  `valor_producto` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `valor_modificado` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cantidad` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `observacion` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pedido_detalle`
--

INSERT INTO `pedido_detalle` (`id`, `fk_pedido`, `fk_producto`, `valor_producto`, `valor_modificado`, `cantidad`, `total`, `observacion`) VALUES
(1, 1, 1, '300', '500', NULL, NULL, NULL),
(2, 3, 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(10) NOT NULL,
  `nombre` char(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion` char(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codigo_prod` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_ingreso` datetime DEFAULT NULL,
  `valor_unitario` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `imagen` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `observacion` text COLLATE utf8_unicode_ci,
  `estado` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `descripcion`, `codigo_prod`, `fecha_ingreso`, `valor_unitario`, `imagen`, `observacion`, `estado`) VALUES
(1, 'Producto 1', 'Producto 1', 'pord_1', '2017-05-29 00:00:00', '3000', NULL, '', 1),
(2, 'Producto 2', 'Producto 2', 'prod_2', '2017-05-28 00:00:00', '990', NULL, '', 1),
(3, 'Producto 3', 'Producto 3', 'prod_3', '2017-05-17 00:00:00', '4590', NULL, '', 1),
(4, 'Producto 4', 'Es muy poderoso, cuidado!', 'pord_004_epro', '2017-06-01 16:36:44', '5.000', '59307adcbc3d8.jpg', 'No utilizar en ambientes cerrados, ni pulverizar', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_categoria`
--

CREATE TABLE `producto_categoria` (
  `id` int(10) NOT NULL,
  `fk_producto` int(10) DEFAULT NULL,
  `fk_categoria` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `producto_categoria`
--

INSERT INTO `producto_categoria` (`id`, `fk_producto`, `fk_categoria`) VALUES
(1, 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`) VALUES
(1, 'admin', 'admin', 'guillermo@tuciudad.cl', 'guillermo@tuciudad.cl', 1, NULL, '$2y$13$6HN4g5gts33NZGJ.FpRN4.kyC/sMf5EisMaBauQL77WyrvUOfoqlu', '2017-07-19 12:24:24', NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}'),
(2, 'hercas', 'hercas', 'alexx@gmail.com', 'alexx@gmail.com', 1, NULL, '$2y$13$JViiRm3fdXr6RqwCCNXIMe7K3TlNzXnhmlwOGUYI09Ugj96DI6bmS', '2017-07-19 11:24:24', NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedor`
--

CREATE TABLE `vendedor` (
  `id` int(10) NOT NULL,
  `primer_nombre` char(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `segundo_nombre` char(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `apellido_paterno` char(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `apellido_materno` char(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dni` char(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sexo` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `comuna` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `provincia` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `region` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dir_villa_pbla` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dir_calle` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dir_numero_casa` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dir_numero_departamento` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dir_numero_piso` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefono` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `celular` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `correo` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `skype` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `observacion` text COLLATE utf8_unicode_ci,
  `imagen` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_ingreso` datetime DEFAULT NULL,
  `estado` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `vendedor`
--

INSERT INTO `vendedor` (`id`, `primer_nombre`, `segundo_nombre`, `apellido_paterno`, `apellido_materno`, `username`, `dni`, `sexo`, `fecha_nacimiento`, `comuna`, `provincia`, `region`, `dir_villa_pbla`, `dir_calle`, `dir_numero_casa`, `dir_numero_departamento`, `dir_numero_piso`, `telefono`, `celular`, `correo`, `skype`, `observacion`, `imagen`, `fecha_ingreso`, `estado`) VALUES
(1, 'Vendedor', 'Vendido', 'Venta asdasdasd', 'Ventosa', 'admin', '11111111-10', '', '1989-10-28', 'Los andes', '', '', '', 'Test', '1234', '123', '', '123456789', '', 'test@test.cl', 'test.test', 'Testtesttesttesttesttesttesttest', NULL, '2017-05-19 15:30:00', 1),
(2, 'Vendedor 2', 'Vendido', 'Venta', 'Ventosa', NULL, '11111111-1', 'm', '1989-10-28', NULL, NULL, NULL, NULL, 'test', '1234', NULL, NULL, '123456789', '987654321', 'test@test.cl', 'test.test', 'testtesttesttesttesttesttesttest', NULL, '2017-05-19 15:30:00', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contac_empre`
--
ALTER TABLE `contac_empre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_contacto` (`fk_contacto`),
  ADD KEY `fk_empresa` (`fk_empresa`);

--
-- Indices de la tabla `def_comuna`
--
ALTER TABLE `def_comuna`
  ADD PRIMARY KEY (`com_id_pk`),
  ADD KEY `com_provincia_fk` (`com_provincia_fk`);

--
-- Indices de la tabla `def_provincia`
--
ALTER TABLE `def_provincia`
  ADD PRIMARY KEY (`pro_id_pk`),
  ADD KEY `pro_region_fk` (`pro_region_fk`);

--
-- Indices de la tabla `def_region`
--
ALTER TABLE `def_region`
  ADD PRIMARY KEY (`reg_id_pk`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `etapas`
--
ALTER TABLE `etapas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `etapas_produccion`
--
ALTER TABLE `etapas_produccion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `e_p_producto`
--
ALTER TABLE `e_p_producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_etapas_produccion_producto_etapas_produccion1_idx` (`etapas_produccion_id`),
  ADD KEY `fk_e_p_producto_pedido_detalle1_idx` (`pedido_detalle_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_empresa` (`fk_empresa`),
  ADD KEY `fk_vendedor` (`fk_vendedor`),
  ADD KEY `fk_etapa` (`fk_etapa`);

--
-- Indices de la tabla `pedido_detalle`
--
ALTER TABLE `pedido_detalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pedido` (`fk_pedido`),
  ADD KEY `fk_producto` (`fk_producto`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `producto_categoria`
--
ALTER TABLE `producto_categoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_producto` (`fk_producto`),
  ADD KEY `fk_categoria` (`fk_categoria`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_2265B05D92FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_2265B05DA0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_2265B05DC05FB297` (`confirmation_token`);

--
-- Indices de la tabla `vendedor`
--
ALTER TABLE `vendedor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `contacto`
--
ALTER TABLE `contacto`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `contac_empre`
--
ALTER TABLE `contac_empre`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT de la tabla `def_comuna`
--
ALTER TABLE `def_comuna`
  MODIFY `com_id_pk` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=347;
--
-- AUTO_INCREMENT de la tabla `def_provincia`
--
ALTER TABLE `def_provincia`
  MODIFY `pro_id_pk` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `etapas`
--
ALTER TABLE `etapas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `etapas_produccion`
--
ALTER TABLE `etapas_produccion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `e_p_producto`
--
ALTER TABLE `e_p_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `pedido_detalle`
--
ALTER TABLE `pedido_detalle`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `producto_categoria`
--
ALTER TABLE `producto_categoria`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `vendedor`
--
ALTER TABLE `vendedor`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `contac_empre`
--
ALTER TABLE `contac_empre`
  ADD CONSTRAINT `contac_empre_ibfk_1` FOREIGN KEY (`fk_contacto`) REFERENCES `contacto` (`id`),
  ADD CONSTRAINT `contac_empre_ibfk_2` FOREIGN KEY (`fk_empresa`) REFERENCES `empresa` (`id`);

--
-- Filtros para la tabla `def_comuna`
--
ALTER TABLE `def_comuna`
  ADD CONSTRAINT `def_comuna_ibfk_1` FOREIGN KEY (`com_provincia_fk`) REFERENCES `def_provincia` (`pro_id_pk`);

--
-- Filtros para la tabla `def_provincia`
--
ALTER TABLE `def_provincia`
  ADD CONSTRAINT `def_provincia_ibfk_1` FOREIGN KEY (`pro_region_fk`) REFERENCES `def_region` (`reg_id_pk`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `e_p_producto`
--
ALTER TABLE `e_p_producto`
  ADD CONSTRAINT `fk_e_p_producto_pedido_detalle1` FOREIGN KEY (`pedido_detalle_id`) REFERENCES `pedido_detalle` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_etapas_produccion_producto_etapas_produccion1` FOREIGN KEY (`etapas_produccion_id`) REFERENCES `etapas_produccion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`fk_vendedor`) REFERENCES `vendedor` (`id`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`fk_empresa`) REFERENCES `empresa` (`id`),
  ADD CONSTRAINT `pedidos_ibfk_3` FOREIGN KEY (`fk_etapa`) REFERENCES `etapas` (`id`);

--
-- Filtros para la tabla `pedido_detalle`
--
ALTER TABLE `pedido_detalle`
  ADD CONSTRAINT `pedido_detalle_ibfk_1` FOREIGN KEY (`fk_pedido`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `pedido_detalle_ibfk_2` FOREIGN KEY (`fk_producto`) REFERENCES `producto` (`id`);

--
-- Filtros para la tabla `producto_categoria`
--
ALTER TABLE `producto_categoria`
  ADD CONSTRAINT `producto_categoria_ibfk_1` FOREIGN KEY (`fk_producto`) REFERENCES `producto` (`id`),
  ADD CONSTRAINT `producto_categoria_ibfk_2` FOREIGN KEY (`fk_categoria`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
