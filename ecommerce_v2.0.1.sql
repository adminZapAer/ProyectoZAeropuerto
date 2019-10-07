-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-10-2019 a las 21:01:44
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ecommerce`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `ruta` text COLLATE utf8_spanish_ci NOT NULL,
  `img` text COLLATE utf8_spanish_ci NOT NULL,
  `titulo1` text COLLATE utf8_spanish_ci NOT NULL,
  `titulo2` text COLLATE utf8_spanish_ci NOT NULL,
  `titulo3` text COLLATE utf8_spanish_ci NOT NULL,
  `estilo` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `banner`
--

INSERT INTO `banner` (`id`, `ruta`, `img`, `titulo1`, `titulo2`, `titulo3`, `estilo`, `fecha`) VALUES
(1, 'sin-categoria', 'vistas/img/banner/refacciones.jpg', '{\r\n	\"texto\": \"GRANDES PROMOCIONES\",\r\n	\"color\": \"#fff\"\r\n}', '{\r\n	\"texto\": \"40% Descuento\",\r\n	\"color\": \"#fff\"\r\n}', '{\r\n	\"texto\": \"Termina el 31 de Octubre\",\r\n	\"color\": \"#fff\"\r\n}', 'textoDer', '2019-08-14 14:27:57'),
(2, 'articulos-gratis', 'vistas/img/banner/refacciones.jpg', '{\r\n	\"texto\": \"ARTÍCULOS GRATIS\",\r\n	\"color\": \"#fff\"\r\n}', '{\r\n\r\n	\"texto\": \"¡Entrega inmediata!\",\r\n\r\n	\"color\": \"#fff\"\r\n\r\n}', '{\r\n	\"texto\": \"Disfrútalo\",\r\n	\"color\": \"#fff\"\r\n}', 'textoIzq', '2019-07-06 12:02:41'),
(3, 'desarrollo-web', 'vistas/img/banner/refacciones.jpg', '{\r\n	\"texto\": \"OFERTAS ESPECIALES\",\r\n	\"color\": \"#fff\"\r\n}', '{\r\n\r\n	\"texto\": \"50% off\",\r\n\r\n	\"color\": \"#fff\"\r\n\r\n}', '{\r\n	\"texto\": \"Termina el 31 de Octubre\",\r\n	\"color\": \"#fff\"\r\n}', 'textoCentro', '2019-07-06 12:03:00'),
(4, 'ropa-para-hombre', 'vistas/img/banner/refacciones.jpg', '{\r\n	\"texto\": \"OFERTAS ESPECIALES\",\r\n	\"color\": \"#fff\"\r\n}', '{\r\n\r\n	\"texto\": \"50% off\",\r\n\r\n	\"color\": \"#fff\"\r\n\r\n}', '{\r\n	\"texto\": \"Termina el 31 de Octubre\",\r\n	\"color\": \"#fff\"\r\n}', 'textoDer', '2019-07-06 12:03:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `idCategoria` int(11) NOT NULL,
  `categoria` text COLLATE utf8_spanish_ci NOT NULL,
  `ruta` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idCategoria`, `categoria`, `ruta`, `fecha`) VALUES
(2, 'Arnes', 'arnes', '0000-00-00 00:00:00'),
(3, 'Ejes', 'ejes', '0000-00-00 00:00:00'),
(4, 'Motor', 'motor', '0000-00-00 00:00:00'),
(5, 'Muelle', 'muelle', '0000-00-00 00:00:00'),
(6, 'Iluminacion', 'iluminacion', '0000-00-00 00:00:00'),
(7, 'Balatas', 'balatas', '0000-00-00 00:00:00'),
(9, 'Direcciones', 'direcciones', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `idComentario` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `calificacion` float NOT NULL,
  `comentario` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comercio`
--

CREATE TABLE `comercio` (
  `idComercio` int(11) NOT NULL,
  `impuesto` float NOT NULL,
  `envioNacional` float NOT NULL,
  `envioInternacional` float NOT NULL,
  `tasaMinimaNal` float NOT NULL,
  `tasaMinimaInt` float NOT NULL,
  `pais` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `comercio`
--

INSERT INTO `comercio` (`idComercio`, `impuesto`, `envioNacional`, `envioInternacional`, `tasaMinimaNal`, `tasaMinimaInt`, `pais`) VALUES
(1, 16, 50, 150, 100, 200, 'MX');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `idCompra` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `envio` int(1) NOT NULL,
  `metodo` text COLLATE utf8_spanish_ci NOT NULL,
  `pais` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deseos`
--

CREATE TABLE `deseos` (
  `idDeseo` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `idCompra` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `precio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion`
--

CREATE TABLE `direccion` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `celular` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `cp` int(5) NOT NULL,
  `estado` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `municipio` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `colonia` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `calle` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `numext` int(10) NOT NULL,
  `numint` int(10) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `direccion`
--

INSERT INTO `direccion` (`id`, `nombre`, `celular`, `cp`, `estado`, `municipio`, `colonia`, `calle`, `numext`, `numint`, `id_usuario`) VALUES
(2, 'Juan Perez', '5539361764', 57100, 'CDMX', 'GAM', 'Lindavista', 'ferna', 234, 0, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantilla`
--

CREATE TABLE `plantilla` (
  `id` int(11) NOT NULL,
  `barraSuperior` text COLLATE utf8_spanish_ci NOT NULL,
  `textoSuperior` text COLLATE utf8_spanish_ci NOT NULL,
  `colorFondo` text COLLATE utf8_spanish_ci NOT NULL,
  `colorTexto` text COLLATE utf8_spanish_ci NOT NULL,
  `logo` text COLLATE utf8_spanish_ci NOT NULL,
  `icono` text COLLATE utf8_spanish_ci NOT NULL,
  `redesSociales` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `plantilla`
--

INSERT INTO `plantilla` (`id`, `barraSuperior`, `textoSuperior`, `colorFondo`, `colorTexto`, `logo`, `icono`, `redesSociales`, `fecha`) VALUES
(1, '#000000', '#ffffff', '#47bac1', '#ffffff', 'vistas/img/plantilla/logo.png', 'vistas/img/plantilla/icono.png', '[{\r\n		\"red\": \"fa-facebook\",\r\n		\"estilo\": \"facebookBlanco\",\r\n		\"url\": \"https://facebook.com/ZapataAeropuerto\"\r\n	}, {\r\n		\"red\": \"fa-youtube\",\r\n		\"estilo\": \"youtubeBlanco\",\r\n		\"url\": \"https://www.youtube.com/channel/UCQNedhj6wafQstgFY8evQ-Q\"\r\n	}, {\r\n		\"red\": \"fa-twitter\",\r\n		\"estilo\": \"twitterBlanco\",\r\n		\"url\": \"https://twitter.com/ZAeropuerto\"\r\n	}, {\r\n		\"red\": \"fa-instagram\",\r\n		\"estilo\": \"instagramBlanco\",\r\n		\"url\": \"http://instagram.com/zapataaeropuerto\"\r\n	}\r\n\r\n]', '2019-07-06 06:35:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `idSubcategoria` int(11) NOT NULL,
  `tipo` text COLLATE utf8_spanish_ci NOT NULL,
  `ruta` text COLLATE utf8_spanish_ci NOT NULL,
  `titulo` text COLLATE utf8_spanish_ci NOT NULL,
  `titular` text COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `multimedia` text COLLATE utf8_spanish_ci NOT NULL,
  `detalles` text COLLATE utf8_spanish_ci NOT NULL,
  `precio` float NOT NULL,
  `portada` text COLLATE utf8_spanish_ci NOT NULL,
  `vistas` int(11) NOT NULL,
  `ventas` int(11) NOT NULL,
  `vistasGratis` int(11) NOT NULL,
  `ventasGratis` int(11) NOT NULL,
  `ofertadoPorCategoria` int(11) NOT NULL,
  `ofertadoPorSubCategoria` int(11) NOT NULL,
  `oferta` int(11) NOT NULL,
  `precioOferta` float NOT NULL,
  `descuentoOferta` int(11) NOT NULL,
  `imgOferta` text COLLATE utf8_spanish_ci NOT NULL,
  `finOferta` datetime NOT NULL,
  `nuevo` int(11) NOT NULL,
  `peso` float NOT NULL,
  `entrega` float NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `idCategoria`, `idSubcategoria`, `tipo`, `ruta`, `titulo`, `titular`, `descripcion`, `multimedia`, `detalles`, `precio`, `portada`, `vistas`, `ventas`, `vistasGratis`, `ventasGratis`, `ofertadoPorCategoria`, `ofertadoPorSubCategoria`, `oferta`, `precioOferta`, `descuentoOferta`, `imgOferta`, `finOferta`, `nuevo`, `peso`, `entrega`, `fecha`) VALUES
(2, 4, 5, 'fisico', 'starter-paccar-c13', 'Starter Paccar C13', 'Starter Paccar DelcoRemy', 'Starter Paccar DelcoRemy', '[{\"foto\":\"vistas/img/multimedia/starter-paccar-c13/imagen2.jpg\"}]', '{\"Descripcion1\":\"No. Parte: D616002004\",\"Descripcion2\":\"Marca Paccar\",\"Descripcion3\":\"Aplicación para Motores CAT C9/C10/C11/C13/C15\",\"Descripcion4\":\"Aplicación para motores Cummins ISM N14/ ISX 15\",\"Descripcion5\":\"\",\"Descripcion6\":\"\"}', 4045.78, 'vistas/img/productos/motor/imagen2.jpg', 29, 0, 0, 0, 0, 0, 0, 0, 0, '', '0000-00-00 00:00:00', 1, 2, 10, '2019-09-24 18:32:10'),
(3, 7, 8, 'fisico', 'juego-de-balatas', 'Juego de Balatas', 'Balatas Meritor', 'Juego de Balatas Frasle 4 levas y 4 ancla', '[{\"foto\":\"vistas/img/multimedia/juego-de-balatas/imagen3.jpg\"}]', '{\"Descripcion1\":\"No. Parte: TDAAF5554656\",\"Descripcion2\":\"Marca: Meritor\",\"Descripcion3\":\"Aplicación: Revolvedoras, Camiones de volteo\",\"Descripcion4\":\"Peso Máximo: 23 toneladas\",\"Descripcion5\":\"\",\"Descripcion6\":\"\"}', 607.37, 'vistas/img/productos/balatas/imagen3.jpg', 19, 0, 0, 0, 0, 0, 0, 0, 0, '', '0000-00-00 00:00:00', 1, 1, 10, '2019-09-24 17:12:42'),
(4, 4, 6, 'fisico', 'manguera-para-unidad-o500', 'Manguera para unidad O500', 'manguera para radiador', 'Manguera Flexible para Unidad O500', '[{\"foto\":\"vistas/img/multimedia/manguera-para-unidad-o500/imagen4.jpg\"}]', '{\"Descripcion1\":\"No. Parte: A3825010584\",\"Descripcion2\":\"Marca: Mercedes Benz\",\"Descripcion3\":\"Aplicación: Manguera a boca de vaciado del radiador para autobús O500\",\"Descripcion4\":\"\",\"Descripcion5\":\"\",\"Descripcion6\":\"\"}', 469.23, 'vistas/img/productos/motor/imagen4.jpg', 17, 0, 0, 0, 0, 0, 0, 0, 0, '', '0000-00-00 00:00:00', 1, 1, 10, '2019-10-02 16:19:48'),
(5, 5, 7, 'fisico', 'muelle-trasero-para-coronado', 'Muelle Trasero para Coronado', 'Muelle Trasero para Coronado, mercedes benz', 'Muelle Trasero para unidades Freightliner FL120 (Coronado) con suspensión trasera de 6,000 lbs', '[{\"foto\":\"vistas/img/multimedia/muelle-trasero-para-coronado/imagen5.jpg\"}]', '{\"Descripcion1\":\"No. Parte: A1614898000\",\"Descripcion2\":\"Marca: Mercedes Benz\",\"Descripcion3\":\"Aplicación: Unidades Freightliner FL120 (Coronado)\",\"Descripcion4\":\"\",\"Descripcion5\":\"\",\"Descripcion6\":\"\"}', 4867.53, 'vistas/img/productos/muelle/imagen5.jpg', 8, 0, 0, 0, 0, 0, 0, 0, 0, '', '0000-00-00 00:00:00', 1, 15, 10, '2019-09-20 15:37:45'),
(6, 9, 23, 'fisico', 'caja-de-direcciones-para-m2-35k', 'Caja de Direcciones para M2 35K', 'Caja de Dirección para unidades M2', 'Caja de Dirección para unidades M2', '[{\"foto\":\"vistas/img/multimedia/caja-de-direcciones-para-m2-35k/imagen1.jpg\"},{\"foto\":\"vistas/img/multimedia/caja-de-direcciones-para-m2-35k/imagen2.jpg\"},{\"foto\":\"vistas/img/multimedia/caja-de-direcciones-para-m2-35k/imagen3.jpg\"},{\"foto\":\"vistas/img/multimedia/caja-de-direcciones-para-m2-35k/imagen6.jpg\"}]', '{\"Descripcion1\":\"No. Parte: TAS6509AEXCH\",\"Descripcion2\":\"Marca: TRW\",\"Descripcion3\":\"Aplicación: Unidades M2 35K\",\"Descripcion4\":\"Modelo 2003\",\"Descripcion5\":\"Motor 906 o a fin a su unidad\",\"Descripcion6\":\"\"}', 9815.56, 'vistas/img/productos/direcciones/imagen6.jpg', 10, 0, 0, 0, 0, 0, 0, 0, 0, '', '0000-00-00 00:00:00', 1, 25, 10, '2019-08-29 18:59:36'),
(7, 3, 3, 'fisico', 'maza-eje-delantero-pata-fl120', 'Maza Eje Delantero pata FL120', 'Maza de eje delantero para freightliner FL 120', 'Maza de eje delantero para freightliner FL 120', '[{\"foto\":\"vistas/img/multimedia/maza-eje-delantero-pata-fl120/imagen7.jpg\"}]', '{\"Descripcion1\":\"No. Parte: TDAA2333T4232\",\"Descripcion2\":\"Marca: Meritor\",\"Descripcion3\":\"Aplicación: Eje delantero para tractocamiones FL120\",\"Descripcion4\":\"\",\"Descripcion5\":\"\",\"Descripcion6\":\"\"}', 5220, 'vistas/img/productos/ejes/imagen7.jpg', 36, 0, 0, 0, 0, 0, 0, 0, 0, '', '0000-00-00 00:00:00', 1, 15, 10, '2019-10-02 17:10:09'),
(8, 2, 4, 'fisico', 'arnes-de-motor-cummins', 'Arnes de Motor Cummins', 'Arnes de motor Cummins M11', 'Arnes para motores Cummins M11 en camiones FLD', '[{\"foto\":\"vistas/img/multimedia/arnes-de-motor-cummins/imagen8.jpg\"}]', '{\"Descripcion1\":\"No. Parte: 2864488\",\"Descripcion2\":\"Marca: Delphi\",\"Descripcion3\":\"Aplicación: Motor Cummins M11-280E plus en camiones FLD\",\"Descripcion4\":\"Modelo: 1998\",\"Descripcion5\":\"\",\"Descripcion6\":\"\"}', 0.19, 'vistas/img/productos/arnes/imagen8.jpg', 7, 0, 0, 0, 0, 0, 0, 0, 0, '', '0000-00-00 00:00:00', 1, 5, 10, '2019-09-25 17:01:25'),
(9, 9, 23, 'fisico', 'caja-de-direcciones-para-freightliner-m2', 'Caja de Direcciones para Freightliner M2', 'Caja de Direcciones para Freightliner M2', 'Caja de Direcciones para Freightliner M2', '[{\"foto\":\"vistas/img/multimedia/caja-de-direcciones-para-freightliner-m2/imagen9.jpg\"}]', '{\"Descripcion1\":\"No. Parte: TRWTAS85134A\",\"Descripcion2\":\"Marca: TRW\",\"Descripcion3\":\"Aplicación: Freightliner M2 33K\",\"Descripcion4\":\"Modelo: 2005\",\"Descripcion5\":\"Modelo 906 o a fin\",\"Descripcion6\":\"\"}', 19689.7, 'vistas/img/productos/direcciones/imagen9.jpg', 6, 0, 0, 0, 0, 0, 0, 0, 0, '', '0000-00-00 00:00:00', 1, 5, 10, '2019-08-29 19:06:39'),
(10, 2, 2, 'fisico', 'arnes-de-cabina-para-fuso-1217', 'Arnes de Cabina para Fuso 1217', 'Arnes de Cabina para Fuso 1217', 'Arnes de Cabina para Fuso 1217', '[{\"foto\":\"vistas/img/multimedia/arnes-de-cabina-para-fuso-1217/imagen10.jpg\"}]', '{\"Descripcion1\":\"No. Parte: MBFMK638958\",\"Descripcion2\":\"Marca: Fuso\",\"Descripcion3\":\"Aplicación: Motor Mitsubishi fuso\",\"Descripcion4\":\"Modelo: 2006\",\"Descripcion5\":\"\",\"Descripcion6\":\"\"}', 0.19, 'vistas/img/productos/arnes/imagen10.jpg', 46, 0, 0, 0, 0, 0, 0, 0, 0, '', '0000-00-00 00:00:00', 1, 5, 10, '2019-10-02 18:29:13'),
(501, 6, 9, 'fisico', 'torreta-strobo', 'Torreta Strobo', 'Torreta Strobo tipo montacarga', 'Aplicación: Cualquier tipo de montacarga y uso automotríz. ', '[{\"foto\":\"vistas/img/multimedia/torreta-strobo/imagen1.jpg\"}]', '{\"Descripcion1\":\"No. Parte: 4245600\",\"Descripcion2\":\"Marca: Star\",\"Descripcion3\":\"Altura: 90 milimetros\",\"Descripcion4\":\"Ancho Base: 130 milimetros\",\"Descripcion5\":\"Voltaje: 12 V - 48 Voltios\",\"Descripcion6\":\"\"}', 342.06, 'vistas/img/productos/iluminacion/imagen1.jpg', 3, 0, 0, 0, 0, 0, 0, 0, 0, '', '0000-00-00 00:00:00', 1, 1, 10, '2019-09-24 16:43:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `slide`
--

CREATE TABLE `slide` (
  `id` int(11) NOT NULL,
  `imgFondo` text COLLATE utf8_spanish_ci NOT NULL,
  `tipoSlide` text COLLATE utf8_spanish_ci NOT NULL,
  `imgProducto` text COLLATE utf8_spanish_ci NOT NULL,
  `estiloImgProducto` text COLLATE utf8_spanish_ci NOT NULL,
  `estiloTextoSlide` text COLLATE utf8_spanish_ci NOT NULL,
  `titulo1` text COLLATE utf8_spanish_ci NOT NULL,
  `titulo2` text COLLATE utf8_spanish_ci NOT NULL,
  `titulo3` text COLLATE utf8_spanish_ci NOT NULL,
  `btnVerProducto` text COLLATE utf8_spanish_ci NOT NULL,
  `url` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `slide`
--

INSERT INTO `slide` (`id`, `imgFondo`, `tipoSlide`, `imgProducto`, `estiloImgProducto`, `estiloTextoSlide`, `titulo1`, `titulo2`, `titulo3`, `btnVerProducto`, `url`, `fecha`) VALUES
(1, 'vistas/img/slide/default/back_default.jpg', 'slideOpcion1', 'vistas/img/slide/slide1/calzado.png', '{\"top\": \"15%\" ,\"right\": \"10%\" ,\"width\": \"45%\", \"left\":\"\"}', '{\"top\": \"20%\" ,\"right\": \"\" ,\"width\": \"40%\", \"left\":\"10%\"}', '{\"texto\": \"Lorem Ipsum\" ,\"color\": \"#333\"}', '{\"texto\": \"Lorem ipsum dolor sit\" ,\"color\": \"#777\"}', '{\"texto\": \"Lorem ipsum dolor sit\" ,\"color\": \"#888\"}', '<button class=\"btn btn-default backColor text-uppercase\">\r\n\r\n							VER PRODUCTO <span class=\"fa fa-chevron-right\"></span>\r\n\r\n							</button>', '#', '2017-10-05 22:13:07'),
(2, 'vistas/img/slide/default/back_default.jpg', 'slideOpcion2', 'vistas/img/slide/slide2/curso.png', '{\r\n	\"width\": \"30%\",\r\n	\"top\": \"5%\",\r\n	\"left\": \"15%\", \"right\":\"\"\r\n}', '{\r\n	\"width\": \"40%\",\r\n	\"top\": \"15%\",\r\n	\"left\": \"\",\r\n	\"right\": \"15%\"\r\n}', '{\"texto\": \"Lorem Ipsum\" ,\"color\": \"#333\"}', '{\"texto\": \"Lorem ipsum dolor sit\" ,\"color\": \"#777\"}', '{\"texto\": \"Lorem ipsum dolor sit\" ,\"color\": \"#888\"}', '<button class=\"btn btn-default backColor text-uppercase\">\r\n\r\n							VER PRODUCTO <span class=\"fa fa-chevron-right\"></span>\r\n\r\n							</button>', '#', '2019-05-18 15:07:41'),
(3, 'vistas/img/slide/slide3/fondo2.jpg', 'slideOpcion2', 'vistas/img/slide/slide3/iphone.png', '{\r\n	\"width\": \"35%\",\r\n	\"top\": \"5%\",\r\n	\"left\": \"15%\",\r\n	\"right\": \"\"\r\n}', '{\r\n	\"width\": \"40%\",\r\n	\"top\": \"15%\",\r\n	\"left\": \"\",\r\n	\"right\": \"15%\"\r\n}', '{\"texto\": \"Lorem Ipsum\" ,\"color\": \"#eee\"}', '{\"texto\": \"Lorem ipsum dolor sit\" ,\"color\": \"#ccc\"}', '{\"texto\": \"Lorem ipsum dolor sit\" ,\"color\": \"#aaa\"}', '<button class=\"btn btn-default backColor text-uppercase\">\r\n\r\n							VER PRODUCTO <span class=\"fa fa-chevron-right\"></span>\r\n\r\n							</button>', '#', '2019-05-18 15:07:45'),
(4, 'vistas/img/slide/slide4/fondo3.jpg', 'slideOpcion1', '', '', '{\r\n	\"width\": \"40%\",\r\n	\"top\": \"20%\",\r\n	\"left\": \"10%\",\r\n	\"right\": \"\"\r\n}', '{\"texto\": \"Lorem Ipsum\" ,\"color\": \"#333\"}', '{\"texto\": \"Lorem ipsum dolor sit\" ,\"color\": \"#777\"}', '{\"texto\": \"Lorem ipsum dolor sit\" ,\"color\": \"#888\"}', '', '', '2017-10-05 22:13:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategorias`
--

CREATE TABLE `subcategorias` (
  `idSubcategoria` int(11) NOT NULL,
  `subcategoria` text COLLATE utf8_spanish_ci NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `ruta` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `subcategorias`
--

INSERT INTO `subcategorias` (`idSubcategoria`, `subcategoria`, `idCategoria`, `ruta`, `fecha`) VALUES
(2, 'Arnes Cabina', 2, 'arnes-cabina', '0000-00-00 00:00:00'),
(3, 'Maza', 3, 'maza', '0000-00-00 00:00:00'),
(4, 'Arnes Motor', 2, 'arnes-motor', '0000-00-00 00:00:00'),
(5, 'Motor de Arranque', 4, 'motor-de-arranque', '0000-00-00 00:00:00'),
(6, 'Manguera', 4, 'manguera', '0000-00-00 00:00:00'),
(7, 'Muelle', 5, 'muelle', '0000-00-00 00:00:00'),
(8, 'Balatas', 7, 'balatas', '0000-00-00 00:00:00'),
(9, 'Torreta', 6, 'torreta', '0000-00-00 00:00:00'),
(23, 'Caja de Direcciones', 9, 'caja-de-direcciones', '2019-08-02 19:22:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `password` text COLLATE utf8_spanish_ci NOT NULL,
  `email` text COLLATE utf8_spanish_ci NOT NULL,
  `modo` text COLLATE utf8_spanish_ci NOT NULL,
  `foto` text COLLATE utf8_spanish_ci NOT NULL,
  `verificacion` int(11) NOT NULL,
  `emailEncriptado` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `nombre`, `password`, `email`, `modo`, `foto`, `verificacion`, `emailEncriptado`, `fecha`) VALUES
(4, 'Alfredo Corona', '$2a$07$asxx54ahjppf45sd87a5aub7LdtrTXnn.ZQdALsthndsluPeTbv.a', 'acorona@gmail.com', 'directo', 'vistas/img/usuarios/4/166.png', 0, 'e8c19263b536acd4db9d1ae7c2e94eb3', '2019-08-14 19:39:51');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`idComentario`);

--
-- Indices de la tabla `comercio`
--
ALTER TABLE `comercio`
  ADD PRIMARY KEY (`idComercio`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`idCompra`);

--
-- Indices de la tabla `deseos`
--
ALTER TABLE `deseos`
  ADD PRIMARY KEY (`idDeseo`);

--
-- Indices de la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `plantilla`
--
ALTER TABLE `plantilla`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`);

--
-- Indices de la tabla `slide`
--
ALTER TABLE `slide`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD PRIMARY KEY (`idSubcategoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `idComentario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comercio`
--
ALTER TABLE `comercio`
  MODIFY `idComercio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `idCompra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `deseos`
--
ALTER TABLE `deseos`
  MODIFY `idDeseo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `direccion`
--
ALTER TABLE `direccion`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `plantilla`
--
ALTER TABLE `plantilla`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=502;

--
-- AUTO_INCREMENT de la tabla `slide`
--
ALTER TABLE `slide`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  MODIFY `idSubcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
