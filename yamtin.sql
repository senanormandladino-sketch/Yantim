-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-08-2026 a las 06:00:20
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `yamtin`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id_administrador` int(11) NOT NULL,
  `tipo_documento` varchar(100) NOT NULL,
  `numero_documento` int(20) NOT NULL,
  `primer_nombre` varchar(20) NOT NULL,
  `segundo_nombre` varchar(20) DEFAULT NULL,
  `primer_apellido` varchar(20) NOT NULL,
  `segundo_apellido` varchar(20) DEFAULT NULL,
  `correo` varchar(100) NOT NULL,
  `direccion` varchar(30) NOT NULL,
  `telefono` bigint(20) NOT NULL,
  `contraseña` varchar(10) NOT NULL,
  `fecha_nacimiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`id_administrador`, `tipo_documento`, `numero_documento`, `primer_nombre`, `segundo_nombre`, `primer_apellido`, `segundo_apellido`, `correo`, `direccion`, `telefono`, `contraseña`, `fecha_nacimiento`) VALUES
(6, 'TI', 1021315208, 'Normand', 'Daniel', 'Ladino', 'Pacheco', 'sena.normandladino@gmail.com', 'Cl 70 A sur #15-44 este', 3144131737, '1157pd', '2009-07-28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`, `descripcion`) VALUES
(1, 'Herramientas', 'Herramientas de todo tipo para uso profesional y doméstico.'),
(2, 'Materiales de construcción', 'Insumos estructurales, áridos y elementos base para obras.'),
(3, 'Plomería y fontanería', 'Tubos, conexiones, llaves y accesorios para redes de agua.'),
(4, 'Electricidad', 'Cables, interruptores, enchufes e iluminación para instalaciones.'),
(5, 'Pinturas y químicos', 'Esmaltes, selladores, adhesivos y complementos para acabados.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `IdCliente` int(11) NOT NULL,
  `TipoDocumento` varchar(100) NOT NULL,
  `NumeroDocumento` int(11) NOT NULL,
  `PrimerNombre` varchar(20) NOT NULL,
  `SegundoNombre` varchar(20) DEFAULT NULL,
  `PrimerApellido` varchar(20) NOT NULL,
  `SegundoApellido` varchar(20) DEFAULT NULL,
  `Correo` varchar(100) NOT NULL,
  `Telefono` bigint(20) NOT NULL,
  `Contraseña` varchar(10) NOT NULL,
  `FechaNacimiento` date NOT NULL,
  `Direccion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`IdCliente`, `TipoDocumento`, `NumeroDocumento`, `PrimerNombre`, `SegundoNombre`, `PrimerApellido`, `SegundoApellido`, `Correo`, `Telefono`, `Contraseña`, `FechaNacimiento`, `Direccion`) VALUES
(8, 'TI', 1021315208, 'Normand', 'Daniel', 'Ladino', 'Pacheco', 'sena.normandladino@gmail.com', 3144131737, '1157pd', '2009-07-28', 'Cl 70 A sur #15-44 este'),
(11, 'CC', 7465646, 'Ray', NULL, 'Bernal', NULL, 'brayan@gmail.com', 445445, 'brayan124', '1998-09-24', 'CL 70A SUR 15 ESTE 43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `IdDetalle` int(11) NOT NULL,
  `IdPedido` int(11) NOT NULL,
  `IdProducto` int(11) NOT NULL,
  `Cantidad` int(11) UNSIGNED NOT NULL,
  `PrecioUnitario` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_pedido`
--

INSERT INTO `detalle_pedido` (`IdDetalle`, `IdPedido`, `IdProducto`, `Cantidad`, `PrecioUnitario`) VALUES
(1, 4, 1, 1, 25000),
(2, 5, 30, 5, 15000),
(3, 6, 4, 10, 600000),
(4, 7, 10, 10, 30000),
(5, 8, 4, 1, 600000),
(6, 9, 1, 1, 25000),
(7, 9, 2, 1, 15000),
(8, 9, 3, 1, 8000),
(9, 9, 4, 1, 600000),
(10, 10, 89, 1, 45000),
(11, 10, 90, 1, 9000),
(12, 10, 91, 1, 15000),
(13, 10, 92, 1, 6000),
(14, 11, 45, 1, 3000),
(15, 11, 46, 1, 6000),
(16, 11, 47, 1, 10000),
(17, 11, 48, 1, 5000),
(18, 12, 33, 1, 22000),
(19, 12, 34, 1, 15000),
(20, 12, 35, 1, 7000),
(21, 12, 36, 1, 10000),
(22, 13, 4, 10, 600000),
(23, 14, 4, 10, 600000),
(24, 15, 4, 10, 600000),
(25, 16, 20, 1, 4000),
(26, 17, 1, 1, 25000),
(27, 17, 2, 1, 15000),
(28, 17, 3, 1, 8000),
(29, 17, 4, 1, 600000),
(30, 18, 6, 5, 18000),
(31, 19, 6, 5, 18000),
(32, 20, 6, 5, 18000),
(33, 21, 6, 5, 18000),
(34, 22, 1, 1, 25000),
(35, 22, 2, 1, 15000),
(36, 22, 3, 1, 8000),
(37, 22, 4, 1, 600000),
(38, 23, 85, 1, 3000),
(39, 23, 86, 1, 55000),
(40, 23, 87, 1, 60000),
(41, 23, 88, 1, 35000),
(42, 24, 25, 5, 300000),
(43, 25, 61, 1, 2500),
(44, 25, 62, 1, 2800),
(45, 25, 63, 1, 1800),
(46, 25, 64, 1, 25000),
(47, 26, 31, 5, 18000),
(48, 27, 29, 1, 25000),
(49, 27, 30, 1, 15000),
(50, 27, 31, 1, 18000),
(51, 27, 32, 1, 55000),
(52, 28, 1, 10, 25000),
(53, 29, 77, 1, 4000),
(54, 29, 78, 1, 6000),
(55, 29, 79, 1, 35000),
(56, 29, 80, 1, 60000),
(80, 38, 1, 1, 25000),
(81, 38, 2, 1, 15000),
(82, 38, 3, 1, 8000),
(83, 38, 4, 1, 600000),
(84, 39, 38, 10, 8000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `IdPedido` int(11) NOT NULL,
  `IdCliente` int(11) NOT NULL,
  `FechaPedido` datetime NOT NULL DEFAULT current_timestamp(),
  `CostoTotal` float NOT NULL,
  `Estado` varchar(50) NOT NULL DEFAULT 'Pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`IdPedido`, `IdCliente`, `FechaPedido`, `CostoTotal`, `Estado`) VALUES
(4, 8, '2026-08-20 15:52:32', 25000, 'Pendiente'),
(5, 8, '2026-08-20 15:56:03', 75000, 'Pendiente'),
(6, 8, '2026-08-20 15:58:21', 6000000, 'Pendiente'),
(7, 8, '2026-08-20 16:13:31', 300000, 'Pendiente'),
(8, 8, '2026-08-20 16:29:37', 600000, 'Pendiente'),
(9, 8, '2026-08-20 16:39:27', 648000, 'Pendiente'),
(10, 8, '2026-08-20 16:54:42', 75000, 'Pendiente'),
(11, 8, '2026-08-20 16:57:22', 24000, 'Pendiente'),
(12, 8, '2026-08-20 17:02:01', 54000, 'Pendiente'),
(13, 8, '2026-08-20 17:05:11', 6000000, 'Pendiente'),
(14, 8, '2026-08-20 17:05:22', 6000000, 'Pendiente'),
(15, 8, '2026-08-20 17:05:35', 6000000, 'Pendiente'),
(16, 8, '2026-08-20 17:08:37', 4000, 'Pendiente'),
(17, 8, '2026-08-20 17:14:41', 648000, 'Pendiente'),
(18, 8, '2026-08-20 17:15:37', 90000, 'Pendiente'),
(19, 8, '2026-08-20 17:15:42', 90000, 'Pendiente'),
(20, 8, '2026-08-20 17:15:45', 90000, 'Pendiente'),
(21, 8, '2026-08-20 17:21:37', 90000, 'Pendiente'),
(22, 8, '2026-08-20 17:22:03', 648000, 'Pendiente'),
(23, 8, '2026-08-20 17:24:02', 153000, 'Pendiente'),
(24, 8, '2026-08-20 17:24:39', 1500000, 'Pendiente'),
(25, 8, '2026-08-20 17:26:02', 32100, 'Pendiente'),
(26, 8, '2026-08-20 17:26:46', 90000, 'Pendiente'),
(27, 8, '2026-08-20 17:30:47', 113000, 'Pendiente'),
(28, 8, '2026-08-20 17:31:22', 250000, 'Pendiente'),
(29, 8, '2026-08-20 17:38:17', 105000, 'Pendiente'),
(38, 11, '2026-08-22 14:37:28', 648000, 'Pendiente'),
(39, 11, '2026-08-22 14:38:09', 80000, 'Entregado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(30) NOT NULL,
  `descripcion_producto` varchar(500) NOT NULL,
  `cantidad_producto` int(11) UNSIGNED NOT NULL,
  `costo_producto` float NOT NULL,
  `foto_producto` varchar(100) NOT NULL,
  `id_administrador` int(11) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre_producto`, `descripcion_producto`, `cantidad_producto`, `costo_producto`, `foto_producto`, `id_administrador`, `id_categoria`) VALUES
(1, 'Martillos', 'herramienta manual con una cabeza pesada (generalmente de metal) y un mango (comúnmente de madera), utilizada para golpear objetos', 50, 25000, '../Assets/Imagenes/martillo.jpg', NULL, 1),
(2, 'Mazos', 'herramienta de mano de gran tamaño y peso similar a un martillo, que sirve para golpear o percutir.', 5, 15000, '../Assets/Imagenes/mazos.jpg', NULL, 1),
(3, 'Destornilladores', 'herramienta de mano para apretar o aflojar tornillos, compuesta por un mango, un vástago y una hoja o punta', 6, 8000, '../Assets/Imagenes/destornilladores.jpg', NULL, 1),
(4, 'Sierras', 'es una herramienta con una hoja o disco dentado que sirve para cortar materiales duros como madera, metal o plástico', 20, 600000, '../Assets/Imagenes/sierra.jpg', NULL, 1),
(5, 'Cinceles', 'herramienta manual o mecánica de corte y labrado, generalmente hecha de acero reforzado, que se utiliza para dar forma, cortar o tallar materiales duros como madera, piedra, hormigón o metal', 30, 20000, '../Assets/Imagenes/cinceles.jpg', NULL, 1),
(6, 'Formones', 'herramienta de corte manual, principalmente utilizada en carpintería y tallado de madera, que consta de una hoja metálica afilada y un mango para su manipulación', 50, 18000, '../Assets/Imagenes/Captura.PNG', NULL, 1),
(7, 'Espátulas', 'herramienta con una hoja plana y flexible, generalmente de metal, unida a un mango', 15, 6000, '../Assets/Imagenes/espatula.PNG', NULL, 1),
(8, 'Cepillos', 'herramienta manual para alisar, nivelar, desbastar y dar acabado a superficies de madera', 56, 40000, '../Assets/Imagenes/cepillo.PNG', NULL, 1),
(9, 'Cintas métricas', 'herramienta flexible de medición para longitudes que consta de una cinta (de metal, fibra de vidrio o tela) con marcas lineales, un sistema de bloqueo y una carcasa portátil con resorte', 100, 4000, '../Assets/Imagenes/cinta metrica.PNG', NULL, 1),
(10, 'Niveles', 'herramienta de medición manual que se usa para determinar si una superficie es perfectamente horizontal (nivelada) o vertical (a plomo)', 40, 30000, '../Assets/Imagenes/niveles-burbuja.PNG', NULL, 1),
(11, 'Escuadras', 'Una escuadra es una herramienta de medición y dibujo, generalmente en forma de triángulo rectángulo o de dos reglas perpendiculares, que se utiliza para trazar y verificar ángulos rectos 90 y otros ángulos como los de 45', 10, 20000, '../Assets/Imagenes/escuadra.PNG', NULL, 1),
(12, 'Llaves', 'herramienta manual que se usa para apretar o aflojar tuercas y tornillos, aplicando un movement de torsión', 20, 10000, '../Assets/Imagenes/llaves.PNG', NULL, 1),
(13, 'Alicates', 'herramientas manuales que tienen dos brazos metálicos articulados que se usan para sujetar, doblar, cortar o torcer objetos', 140, 20000, '../Assets/Imagenes/alicates.PNG', NULL, 1),
(14, 'Pinzas', 'herramienta de sujeción con dos mangos que se aproximan en sus extremos para agarrar, sujetar, cortar o prensar objetos.', 50, 10000, '../Assets/Imagenes/pinzas.PNG', NULL, 1),
(15, 'Remachadoras', 'Una herramienta que se utiliza para unir de forma permanente dos o más piezas mediante la deformación plástica de un remache', 15, 70000, '../Assets/Imagenes/remacha.PNG', NULL, 1),
(16, 'Mordazas', 'dispositivo de sujeción diseñado para inmovilizar firmemente una pieza de trabajo mediante presión de fricción', 86, 25000, '../Assets/Imagenes/mordaza.PNG', NULL, 1),
(17, 'Cúteres', 'herramienta de corte manual con una hoja afilada y un mango, utilizada para trabajos generales de corte como papel, cartón, textiles o embalajes.', 10, 4000, '../Assets/Imagenes/cuteres.PNG', NULL, 1),
(18, 'Tijeras', 'herramienta manual de corte compuesta por dos hojas de acero con un filo en un lado, unidas en un eje o remache', 5, 10000, '../Assets/Imagenes/tijeras.PNG', NULL, 1),
(19, 'Limas', 'herramienta manual de acero endurecido utilizada para desbastar, dar forma y pulir materiales como metal, madera y plástico.', 6, 20000, '../Assets/Imagenes/limas.PNG', NULL, 1),
(20, 'Lijas', 'es un dispositivo diseñado para alisar, pulir, desbastar o preparar superficies mediante la acción abrasiva de un material, comúnmente papel de lija.', 20, 4000, '../Assets/Imagenes/lijas.PNG', NULL, 1),
(21, 'Taladros', 'herramienta eléctrica que realiza perforaciones mediante la rotación de una broca en materiales como madera, metal y plástico.', 30, 200000, '../Assets/Imagenes/taladro.PNG', NULL, 1),
(22, 'Rotomartillos', 'herramienta eléctrica potente que combina la acción de rotación y percusión para perforar materiales muy duros como concreto, mampostería y losas.', 50, 900000, '../Assets/Imagenes/rotomartillo.PNG', NULL, 1),
(23, 'Amoladoras', 'herramienta eléctrica versátil y potente diseñada para una variedad de trabajos que implican la eliminación de material mediante la abrasión, utilizando un disco giratorio a altas revoluciones.', 15, 300000, '../Assets/Imagenes/amoladoras.PNG', NULL, 1),
(24, 'Lijadoras', 'es una herramienta, generalmente eléctrica, que utiliza movimiento mecánico para frotar un material abrasivo (lija) contra una superficie, con el fin de eliminar irregularidades, alisar, limpiar o dar un acabado uniforme a materiales como madera, metal, plástico o paredes.', 56, 250000, '../Assets/Imagenes/lijhadoras.PNG', NULL, 1),
(25, 'Pistolas de calor', 'herramienta eléctrica manual diseñada para emitir un flujo concentrado de aire a alta temperatura y presión.', 100, 300000, '../Assets/Imagenes/pistola.PNG', NULL, 1),
(26, 'Brocas', 'herramienta metálica de corte que se utiliza para crear orificios circulares en diversos materiales.', 40, 5000, '../Assets/Imagenes/brocas.png', NULL, 1),
(27, 'Puntas', 'son la parte que entra en contacto con el material o elemento de fijación (como un tornillo) para aplicar fuerza y realizar una acción específica, como atornillar, desatornillar o perforar.', 100, 7000, '../Assets/Imagenes/puntas.png', NULL, 1),
(28, 'Baterías de repuesto', 'son dispositivos recargables que almacenan energía química y la convierten en energía eléctrica para alimentar la herramienta.', 20, 90000, '../Assets/Imagenes/baterias.png', NULL, 1),
(29, 'Cortatubos', 'Herramienta de corte para tubos de PVC, cobre o CPVC. Realiza cortes limpios y precisos.', 9, 25000, '../Assets/Imagenes/cortatubos.JPG', NULL, 1),
(30, 'Destapacaños', 'Herramienta manual de succión que elimina obstrucciones en lavamanos, duchas y sanitarios.', 12, 15000, '../Assets/Imagenes/destapacaños.JPG', NULL, 1),
(31, 'Llave ajustable', 'Herramienta de acero con mandíbula ajustable para tuercas y tubos de distintos tamaños.', 14, 18000, '../Assets/Imagenes/llaveAjustable.JPG', NULL, 1),
(32, 'Multímetro digital', 'Instrumento para medir voltaje, corriente y resistencia. Incluye pantalla LCD.', 10, 55000, '../Assets/Imagenes/multimetrroDigital.JPG', NULL, 1),
(33, 'Pelacables manual', 'Herramienta para retirar el aislamiento de cables eléctricos. Mango ergonómico antideslizante.', 12, 22000, '../Assets/Imagenes/pelaCables.JPG', NULL, 1),
(34, 'Destornillador aislado', 'Destornillador con aislamiento dieléctrico para trabajos eléctricos seguros.', 25, 15000, '../Assets/Imagenes/destornilladorAislado.JPG', NULL, 1),
(35, 'Brocha de 2”', 'Brocha de cerdas suaves con mango de madera. Ideal para acabados precisos y aplicación uniforme.', 50, 7000, '../Assets/Imagenes/brocha.JPG', NULL, 1),
(36, 'Rodillo de espuma', 'Rodillo de espuma de alta densidad para aplicar pintura en superficies lisas con acabado uniforme.', 35, 10000, '../Assets/Imagenes/rodillo.JPG', NULL, 1),
(37, 'Bandeja para pintura', 'Bandeja plástica con superficie texturizada para distribuir la pintura de manera uniforme en el rodillo.', 30, 6000, '../Assets/Imagenes/bandeja.JPG', NULL, 1),
(38, 'Espátula metálica', 'Espátula de acero inoxidable con mango ergonómico, perfecta para aplicar masilla o retirar pintura vieja.', 28, 8000, '../Assets/Imagenes/espatulaMetalica.JPG', NULL, 1),
(39, 'Lija para pintura', 'Lija de grano fino ideal para preparar y suavizar superficies antes de aplicar pintura o barniz.', 100, 2000, '../Assets/Imagenes/lijaPintura.JPG', NULL, 1),
(40, 'Tornillos', 'elemento de fijación con un eje roscado y una cabeza diseñada para ser accionada por una herramienta específica, como un destornillador o una llave.', 140, 6000, '../Assets/Imagenes/tornillos.png', NULL, 2),
(41, 'Clavos', 'varillas metálicas delgadas, puntiagudas en un extremo y aplanadas en el otro, que se usan como sujetadores en carpintería y construcción.', 50, 15000, '../Assets/Imagenes/clavos.png', NULL, 2),
(42, 'Tuercas', 'Pieza metálica con un agujero central roscado que se utiliza para fijar un elemento a un tornillo o perno.', 15, 25000, '../Assets/Imagenes/tuercas.png', NULL, 2),
(43, 'Pernos', 'elemento de fijación metálico cilíndrico con cabeza en un extremo y rosca en el otro, que se utiliza para unir dos o más piezas de forma segura y desmontable, generalmente junto con una tuerca.', 86, 10000, '../Assets/Imagenes/pernos.png', NULL, 2),
(44, 'Arandelas', 'placa delgada, usualmente en forma de disco con un agujero central, que se utiliza en ensamblajes mecánicos y de herramientas para distribuir la carga de un elemento de fijación roscado y proteger las superficies.', 10, 5000, '../Assets/Imagenes/arandelas.png', NULL, 2),
(45, 'Remaches', 'elemento de fijación permanente que une dos o más piezas de material a través de un cuerpo cilíndrico y una cabeza.', 5, 3000, '../Assets/Imagenes/remaches.png', NULL, 2),
(46, 'Alambre', 'hilo de metal delgado y resistente que se fabrica estirando metales como acero, cobre, aluminio o latón gracias a su ductilidad.', 6, 6000, '../Assets/Imagenes/alambre.png', NULL, 2),
(47, 'Cuerda de nylon', 'cuerda sintética hecha de poliamida, caracterizada por su gran resistencia, durabilidad, elasticidad y flexibilidad.', 20, 10000, '../Assets/Imagenes/nylon.png', NULL, 2),
(48, 'Tensores', 'dispositivo mecánico utilizado para aplicar tensión y mantener la fuerza en cables, cuerdas, cadenas o elementos estructurales.', 30, 5000, '../Assets/Imagenes/tensores.png', NULL, 2),
(49, 'Cemento', 'es un aglutinante hidráulico, un polvo inorgánico que, al mezclarse con agua, forma una pasta que fragua y se endurece.', 50, 30000, '../Assets/Imagenes/cemento.png', NULL, 2),
(50, 'Cal', 'material de construcción fundamental utilizado como aglutinante en morteros, enlucidos y estucos para unir ladrillos, bloques y revestir paredes.', 15, 17000, '../Assets/Imagenes/cal.png', NULL, 2),
(51, 'Arena', 'La arena de construcción es un agregado fino que se usa para fabricar hormigón, mortero y otros materiales, compuesto por partículas de rocas y minerales triturados de tamaño entre 0.063 mm y 2 mm.', 56, 15000, '../Assets/Imagenes/arena.png', NULL, 2),
(52, 'Yeso', 'es un material derivado del mineral aljez (sulfato de calcio dihidratado) que, tras un proceso de calcinación y mezclado con agua, se endurece para formar paredes, techos y acabados interiores.', 100, 35000, '../Assets/Imagenes/yeso.png', NULL, 2),
(53, 'Tejas', 'son piezas impermeables, de diversos materiales y formas, que se solapan para recubrir tejados inclinados, protegiendo las estructuras del agua, el viento y otros agentes climáticos.', 40, 35000, '../Assets/Imagenes/tejas.png', NULL, 2),
(54, 'Ladrillos', 'unidades de material, usualmente cerámicas o de hormigón, con forma rectangular o paralelepípeda que se usan para construir muros, paredes y otros elementos estructurales.', 1000, 80000, '../Assets/Imagenes/ladrillos.png', NULL, 2),
(55, 'Bloques', 'unidades de construcción prefabricadas, generalmente hechas de cemento, arena y áridos, que se utilizan para levantar muros y estructuras.', 2000, 20000, '../Assets/Imagenes/bloque.png', NULL, 2),
(56, 'Madera', 'material fibroso y duro, utilizado como elemento estructural (vigas, pilares) y de acabado en construcciones, que destaca por su resistencia, ligereza, y propiedades aislantes térmicas y acústicas.', 140, 25000, '../Assets/Imagenes/madera.png', NULL, 2),
(57, 'Perfiles metálicos', 'elementos estructurales de acero u otro metal, conformados en una variedad de formas y tamaños, que se utilizan para dar soporte, formar el armazón y crear la estructura de una edificación.', 50, 150000, '../Assets/Imagenes/perfiles.png', NULL, 2),
(58, 'Tubo PVC', 'Tubería plástica de PVC para sistemas de conducción hídrica o desagües sanitarios.', 15, 8000, '../Assets/Imagenes/PVC.png', NULL, 3),
(59, 'Cobre', 'es un metal de transición, de color rojo anaranjado, conocido por su alta conductividad eléctrica y térmica, maleabilidad y ductilidad.', 86, 30000, '../Assets/Imagenes/cobre.png', NULL, 3),
(60, 'CPVC', 'es un termoplástico obtenido al clorar el PVC. Es un material de alta temperatura utilizado en tuberías para agua potable (fría y caliente).', 10, 10000, '../Assets/Imagenes/CPVC.png', NULL, 3),
(61, 'Codo PVC', 'Accesorio que permite cambiar la dirección del flujo en una tubería de PVC. Resistente y de fácil instalación.', 15, 2500, '../Assets/Imagenes/codoPVC.JPG', NULL, 3),
(62, 'Tee PVC', 'Conector en forma de \'T\' para unir tres tramos de tubería y ramificar el flujo de agua o desagüe.', 18, 2800, '../Assets/Imagenes/teePVC.JPG', NULL, 3),
(63, 'Cople PVC', 'Pieza para conectar dos tramos de tubería PVC, asegurando continuidad y estanqueidad en la instalación.', 20, 1800, '../Assets/Imagenes/complePVC.JPG', NULL, 3),
(64, 'Grifo cromado', 'Llave de paso metálica con acabado cromado brillante. Ideal para cocinas y lavamanos.', 10, 25000, '../Assets/Imagenes/grifo.JPG', NULL, 3),
(65, 'Llave de paso', 'Dispositivo que controla el flujo del agua en las redes internas. Fabricada en latón resistente a la corrosión.', 10, 12000, '../Assets/Imagenes/llaveDePaso.JPG', NULL, 3),
(66, 'Fregadero de acero', 'Fregadero de acero inoxidable duradero y de fácil limpieza. Ideal para cocinas residenciales.', 6, 80000, '../Assets/Imagenes/fregadero.JPG', NULL, 3),
(67, 'Soporte para toalla', 'Accesorio metálico cromado de pared para colgar toallas de baño o cocina. Diseño elegante y resistente.', 10, 20000, '../Assets/Imagenes/soporteToalla.JPG', NULL, 3),
(68, 'Portajabón', 'Base plástica o metálica para mantener el jabón seco y ordenado en lavamanos o duchas.', 18, 10000, '../Assets/Imagenes/portaJabon.JPG', NULL, 3),
(69, 'Cabezal de ducha', 'Cabezal de ducha con sistema de ahorro de agua y múltiples modos de presión. Fácil instalación.', 7, 35000, '../Assets/Imagenes/cabezal.JPG', NULL, 3),
(70, 'Portacepillos', 'Accesorio de baño para organizar cepillos dentales, fabricado en material resistente a la humedad.', 15, 12000, '../Assets/Imagenes/portacepillos.JPG', NULL, 3),
(71, 'Cable de cobre', 'Cable flexible de cobre con aislamiento PVC, ideal para instalaciones eléctricas residenciales.', 100, 2500, '../Assets/Imagenes/cableCobre.JPG', NULL, 4),
(72, 'Cable de aluminio', 'Cable liviano y resistant a la corrosión. Se usa en acometidas eléctricas y redes de baja tensión.', 80, 1800, '../Assets/Imagenes/cableAluminio.JPG', NULL, 4),
(73, 'Cable calibre 12', 'Cable de cobre trenzado, con recubrimiento PVC, para iluminación, tomas y circuitos de potencia media.', 120, 3000, '../Assets/Imagenes/cableCalibre.JPG', NULL, 4),
(74, 'Tomacorriente doble', 'Tomacorriente doble de 110V fabricado en material aislante. Ideal para uso doméstico o comercial.', 40, 7000, '../Assets/Imagenes/tomaCorriente.JPG', NULL, 4),
(75, 'Extensión eléctrica 3 m', 'Extensión con triple toma y cable reinforced. Incluye interruptor y protección térmica.', 25, 18000, '../Assets/Imagenes/extencion.JPG', NULL, 4),
(76, 'Adaptador múltiple', 'Adaptador múltiple para conectar hasta tres dispositivos. Compacto, seguro y resistente al calor.', 35, 5000, '../Assets/Imagenes/adaptador.JPG', NULL, 4),
(77, 'Interruptor sencillo', 'Interruptor de encendido y apagado con diseño moderno. Fácil instalación y gran durabilidad.', 50, 4000, '../Assets/Imagenes/interruptorSencillo.JPG', NULL, 4),
(78, 'Bombillo LED 9W', 'Bombillo LED de bajo consumo, luz blanca fría, con base E27. Ahorra hasta 80 % de energía.', 100, 6000, '../Assets/Imagenes/bombilla.JPG', NULL, 4),
(79, 'Foco exterior 20W', 'Reflector LED resistente al agua y polvo (IP65). Perfecto para iluminar patios o fachadas.', 15, 35000, '../Assets/Imagenes/foco.JPG', NULL, 4),
(80, 'Lámpara de techo', 'Luminaria decorativa con base metálica y difusor acrílico. Ideal para interiores.', 8, 60000, '../Assets/Imagenes/lampara.JPG', NULL, 4),
(81, 'Linterna recargable', 'Linterna LED con batería recargable. Potente y práctica para cortes de energía o exteriores.', 20, 25000, '../Assets/Imagenes/linterna.JPG', NULL, 4),
(82, 'Masilla para plomería', 'Compuesto sellador ideal para uniones, juntas y grifos. Asegura una instalación sin filtraciones.', 10, 6000, '../Assets/Imagenes/masilla.JPG', NULL, 5),
(83, 'Sellador', 'Sellador siliconado para evitar fugas y aislar humedad en tuberías, lavamanos y duchas.', 8, 7500, '../Assets/Imagenes/sellador.JPG', NULL, 5),
(84, 'Cinta de teflón', 'Cinta selladora para uniones roscadas. Evita fugas de agua o gas en conexiones metálicas y plásticas.', 30, 1000, '../Assets/Imagenes/cintaTeflon.JPG', NULL, 5),
(85, 'Cinta aislante', 'Cinta de PVC de alta adherencia para empalmes eléctricos. Disponible en varios colores.', 50, 3000, '../Assets/Imagenes/cintaAislante.JPG', NULL, 5),
(86, 'Pintura para interior', 'Pintura vinílica de alta cobertura para paredes interiores. Secado rápido y acabado mate.', 15, 55000, '../Assets/Imagenes/pinturaInterior.JPG', NULL, 5),
(87, 'Pintura para exterior', 'Pintura acrílica resistente a la intemperie y rayos UV. Ideal para fachadas y muros exteriores.', 10, 60000, '../Assets/Imagenes/pinturaExteriores.JPG', NULL, 5),
(88, 'Sellador acrílico', 'Sellador base agua para preparar superficies antes de pintar. Mejora adherencia y rendimiento.', 20, 35000, '../Assets/Imagenes/selladorAclilico.JPG', NULL, 5),
(89, 'Barniz transparente', 'Barniz protector brillante para madera. Realza el color natural y protege contra la humedad.', 12, 45000, '../Assets/Imagenes/barniz.JPG', NULL, 5),
(90, 'Silicona sellante', 'Sellante flexible de silicona ideal para baños, cocinas y exteriores. Resistente al agua y al moho.', 30, 9000, '../Assets/Imagenes/siliconaSellante.JPG', NULL, 5),
(91, 'Pegamento industrial', 'Adhesivo de alta resistencia para madera, metal, cerámica y plástico. Secado rápido.', 25, 15000, '../Assets/Imagenes/pegamento.JPG', NULL, 5),
(92, 'Cinta adhesiva multipropósito', 'Cinta de alta adherencia para reparaciones y sellados. Ideal para uso doméstico o industrial.', 40, 6000, '../Assets/Imagenes/cintaMultiproposito.JPG', NULL, 5),
(93, 'Solvente para pintura', 'Disolvente líquido para diluir pinturas, esmaltes y barnices. Facilita limpieza.', 18, 8000, '../Assets/Imagenes/solvente.JPG', NULL, 5),
(94, 'Aerosol / Spray', 'Spray pintable de secado rápido para metal, madera y plástico. Buena cobertura y resistencia.', 40, 12000, '../Assets/Imagenes/aereosol.JPG', NULL, 5);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id_administrador`),
  ADD UNIQUE KEY `numero_documento` (`numero_documento`,`correo`,`telefono`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`IdCliente`),
  ADD UNIQUE KEY `NumeroDocumento` (`NumeroDocumento`,`Correo`,`Telefono`);

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`IdDetalle`),
  ADD KEY `IdPedido` (`IdPedido`),
  ADD KEY `IdProducto` (`IdProducto`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`IdPedido`),
  ADD KEY `IdCliente` (`IdCliente`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD UNIQUE KEY `nombre_producto` (`nombre_producto`),
  ADD KEY `id_administradorFK` (`id_administrador`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id_administrador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `IdCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `IdDetalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `IdPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`IdPedido`) REFERENCES `pedido` (`IdPedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`IdProducto`) REFERENCES `producto` (`id_producto`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`IdCliente`) REFERENCES `clientes` (`IdCliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_administrador`) REFERENCES `administrador` (`id_administrador`),
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
