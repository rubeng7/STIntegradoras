-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.7.17-log - MySQL Community Server (GPL)
-- SO del servidor:              Win32
-- HeidiSQL Versión:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para stintegradoras
CREATE DATABASE IF NOT EXISTS `stintegradoras` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `stintegradoras`;

-- Volcando estructura para tabla stintegradoras.alumno
CREATE TABLE IF NOT EXISTS `alumno` (
  `idAlumno` int(11) NOT NULL,
  `matricula` varchar(9) NOT NULL,
  PRIMARY KEY (`idAlumno`),
  UNIQUE KEY `i_matricula` (`matricula`),
  CONSTRAINT `alumno_ibfk_1` FOREIGN KEY (`idAlumno`) REFERENCES `usuario` (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla stintegradoras.alumno: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `alumno` DISABLE KEYS */;
INSERT INTO `alumno` (`idAlumno`, `matricula`) VALUES
	(2, '091415678');
/*!40000 ALTER TABLE `alumno` ENABLE KEYS */;

-- Volcando estructura para tabla stintegradoras.alumno_grupo_periodo
CREATE TABLE IF NOT EXISTS `alumno_grupo_periodo` (
  `idAlumno` int(11) NOT NULL,
  `idGrupo` int(11) NOT NULL,
  `idPeriodo` int(11) NOT NULL,
  PRIMARY KEY (`idAlumno`,`idGrupo`,`idPeriodo`),
  KEY `idGrupo` (`idGrupo`),
  KEY `idPeriodo` (`idPeriodo`),
  CONSTRAINT `alumno_grupo_periodo_ibfk_1` FOREIGN KEY (`idAlumno`) REFERENCES `alumno` (`idAlumno`),
  CONSTRAINT `alumno_grupo_periodo_ibfk_2` FOREIGN KEY (`idGrupo`) REFERENCES `grupo` (`idGrupo`),
  CONSTRAINT `alumno_grupo_periodo_ibfk_3` FOREIGN KEY (`idPeriodo`) REFERENCES `periodo` (`idPeriodo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla stintegradoras.alumno_grupo_periodo: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `alumno_grupo_periodo` DISABLE KEYS */;
INSERT INTO `alumno_grupo_periodo` (`idAlumno`, `idGrupo`, `idPeriodo`) VALUES
	(2, 1, 1),
	(2, 2, 2);
/*!40000 ALTER TABLE `alumno_grupo_periodo` ENABLE KEYS */;

-- Volcando estructura para tabla stintegradoras.carrera
CREATE TABLE IF NOT EXISTS `carrera` (
  `idCarrera` int(11) NOT NULL AUTO_INCREMENT,
  `nivel` enum('TSU','INGENIERIA','INGENIERIA PROFESIONAL','LICENCIATURA','MAESTRIA','DOCTORADO','OTRO') NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `idDivision` int(11) NOT NULL,
  PRIMARY KEY (`idCarrera`),
  UNIQUE KEY `iu_nombre` (`nombre`),
  KEY `idDivision` (`idDivision`),
  CONSTRAINT `carrera_ibfk_1` FOREIGN KEY (`idDivision`) REFERENCES `division` (`idDivision`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla stintegradoras.carrera: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `carrera` DISABLE KEYS */;
INSERT INTO `carrera` (`idCarrera`, `nivel`, `nombre`, `descripcion`, `idDivision`) VALUES
	(1, 'TSU', 'TSU en Sistemas Informáticos', 'Mi Descripción', 2),
	(3, 'INGENIERIA', 'nose', 'tampoco', 2);
/*!40000 ALTER TABLE `carrera` ENABLE KEYS */;

-- Volcando estructura para tabla stintegradoras.comite
CREATE TABLE IF NOT EXISTS `comite` (
  `idComite` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `idPeriodo` int(11) NOT NULL,
  `idDivision` int(11) NOT NULL,
  PRIMARY KEY (`idComite`),
  UNIQUE KEY `i_unidad` (`nombre`,`idPeriodo`),
  KEY `idPeriodo` (`idPeriodo`),
  KEY `FK_comite_division` (`idDivision`),
  CONSTRAINT `FK_comite_division` FOREIGN KEY (`idDivision`) REFERENCES `division` (`idDivision`),
  CONSTRAINT `comite_ibfk_1` FOREIGN KEY (`idPeriodo`) REFERENCES `periodo` (`idPeriodo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla stintegradoras.comite: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `comite` DISABLE KEYS */;
INSERT INTO `comite` (`idComite`, `nombre`, `descripcion`, `idPeriodo`, `idDivision`) VALUES
	(5, 'Comité 1', 'Es el primer comité', 1, 2);
/*!40000 ALTER TABLE `comite` ENABLE KEYS */;

-- Volcando estructura para tabla stintegradoras.comite_profesor
CREATE TABLE IF NOT EXISTS `comite_profesor` (
  `idComite` int(11) NOT NULL,
  `idProfesor` int(11) NOT NULL,
  PRIMARY KEY (`idComite`,`idProfesor`),
  KEY `idProfesor` (`idProfesor`),
  CONSTRAINT `comite_profesor_ibfk_1` FOREIGN KEY (`idComite`) REFERENCES `comite` (`idComite`),
  CONSTRAINT `comite_profesor_ibfk_2` FOREIGN KEY (`idProfesor`) REFERENCES `profesor` (`idProfesor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla stintegradoras.comite_profesor: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `comite_profesor` DISABLE KEYS */;
INSERT INTO `comite_profesor` (`idComite`, `idProfesor`) VALUES
	(5, 3),
	(5, 4);
/*!40000 ALTER TABLE `comite_profesor` ENABLE KEYS */;

-- Volcando estructura para tabla stintegradoras.direccion
CREATE TABLE IF NOT EXISTS `direccion` (
  `idDireccion` int(11) NOT NULL AUTO_INCREMENT,
  `calle` varchar(255) NOT NULL,
  `numero` int(11) NOT NULL,
  `ciudad` varchar(200) NOT NULL,
  `municipio` varchar(200) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `cp` int(11) DEFAULT NULL,
  PRIMARY KEY (`idDireccion`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla stintegradoras.direccion: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `direccion` DISABLE KEYS */;
INSERT INTO `direccion` (`idDireccion`, `calle`, `numero`, `ciudad`, `municipio`, `estado`, `cp`) VALUES
	(1, 'Marte', 1, 'Ocosingo ', 'Ocosingo', 'Chiapas', 29950),
	(2, 'margaritas ', 2, 'Ocosingo', 'Ocisingo', 'Chiapas', 29950);
/*!40000 ALTER TABLE `direccion` ENABLE KEYS */;

-- Volcando estructura para tabla stintegradoras.division
CREATE TABLE IF NOT EXISTS `division` (
  `idDivision` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idDivision`),
  UNIQUE KEY `iu_nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla stintegradoras.division: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `division` DISABLE KEYS */;
INSERT INTO `division` (`idDivision`, `nombre`, `descripcion`) VALUES
	(2, 'TIC', 'Ninguna'),
	(3, 'Agrobiotecnología', 'Puro machete');
/*!40000 ALTER TABLE `division` ENABLE KEYS */;

-- Volcando estructura para tabla stintegradoras.documento
CREATE TABLE IF NOT EXISTS `documento` (
  `idDocumento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idDocumento`),
  UNIQUE KEY `i_nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla stintegradoras.documento: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `documento` DISABLE KEYS */;
/*!40000 ALTER TABLE `documento` ENABLE KEYS */;

-- Volcando estructura para tabla stintegradoras.empresa
CREATE TABLE IF NOT EXISTS `empresa` (
  `idEmpresa` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) NOT NULL,
  `giro` varchar(80) DEFAULT NULL,
  `responsable` varchar(255) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `idDireccion` int(11) NOT NULL,
  PRIMARY KEY (`idEmpresa`),
  KEY `idDireccion` (`idDireccion`),
  CONSTRAINT `empresa_ibfk_1` FOREIGN KEY (`idDireccion`) REFERENCES `direccion` (`idDireccion`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla stintegradoras.empresa: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` (`idEmpresa`, `nombre`, `giro`, `responsable`, `telefono`, `idDireccion`) VALUES
	(1, 'Mi nueva empresa', 'Comercial', 'Ruben Miguel García Ruiz', '919 105 73 45', 1),
	(2, 'Coca cola', 'Comercial', 'Abraham', '9191132324', 2);
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;

-- Volcando estructura para tabla stintegradoras.entregable
CREATE TABLE IF NOT EXISTS `entregable` (
  `idEntregable` int(11) NOT NULL AUTO_INCREMENT,
  `idEsquema` int(11) NOT NULL,
  `fase` int(11) NOT NULL,
  `idDocumento` int(11) NOT NULL,
  `fechaLimite` datetime NOT NULL,
  PRIMARY KEY (`idEntregable`),
  UNIQUE KEY `i_unidad` (`idEsquema`,`idDocumento`,`fase`),
  KEY `idDocumento` (`idDocumento`),
  CONSTRAINT `entregable_ibfk_1` FOREIGN KEY (`idEsquema`) REFERENCES `esquema` (`idEsquema`),
  CONSTRAINT `entregable_ibfk_2` FOREIGN KEY (`idDocumento`) REFERENCES `documento` (`idDocumento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla stintegradoras.entregable: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `entregable` DISABLE KEYS */;
/*!40000 ALTER TABLE `entregable` ENABLE KEYS */;

-- Volcando estructura para tabla stintegradoras.equipo
CREATE TABLE IF NOT EXISTS `equipo` (
  `idEquipo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `idPeriodo` int(11) NOT NULL,
  `idGrupo` int(11) NOT NULL,
  `idProyecto` int(11) NOT NULL,
  `idEsquema` int(11) NOT NULL,
  `idComite` int(11) NOT NULL,
  PRIMARY KEY (`idEquipo`),
  UNIQUE KEY `i_unidad` (`nombre`,`idPeriodo`,`idGrupo`),
  KEY `idPeriodo` (`idPeriodo`),
  KEY `idGrupo` (`idGrupo`),
  KEY `idProyecto` (`idProyecto`),
  KEY `idEsquema` (`idEsquema`),
  KEY `idComite` (`idComite`),
  CONSTRAINT `equipo_ibfk_1` FOREIGN KEY (`idPeriodo`) REFERENCES `periodo` (`idPeriodo`),
  CONSTRAINT `equipo_ibfk_2` FOREIGN KEY (`idGrupo`) REFERENCES `grupo` (`idGrupo`),
  CONSTRAINT `equipo_ibfk_3` FOREIGN KEY (`idProyecto`) REFERENCES `proyecto` (`idProyecto`),
  CONSTRAINT `equipo_ibfk_4` FOREIGN KEY (`idEsquema`) REFERENCES `esquema` (`idEsquema`),
  CONSTRAINT `equipo_ibfk_5` FOREIGN KEY (`idComite`) REFERENCES `comite` (`idComite`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla stintegradoras.equipo: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `equipo` DISABLE KEYS */;
/*!40000 ALTER TABLE `equipo` ENABLE KEYS */;

-- Volcando estructura para tabla stintegradoras.equipo_alumno
CREATE TABLE IF NOT EXISTS `equipo_alumno` (
  `idEquipo` int(11) NOT NULL,
  `idAlumno` int(11) NOT NULL,
  PRIMARY KEY (`idEquipo`,`idAlumno`),
  KEY `idAlumno` (`idAlumno`),
  CONSTRAINT `equipo_alumno_ibfk_1` FOREIGN KEY (`idEquipo`) REFERENCES `equipo` (`idEquipo`),
  CONSTRAINT `equipo_alumno_ibfk_2` FOREIGN KEY (`idAlumno`) REFERENCES `alumno` (`idAlumno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla stintegradoras.equipo_alumno: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `equipo_alumno` DISABLE KEYS */;
/*!40000 ALTER TABLE `equipo_alumno` ENABLE KEYS */;

-- Volcando estructura para tabla stintegradoras.equipo_entregable
CREATE TABLE IF NOT EXISTS `equipo_entregable` (
  `idEquipo` int(11) NOT NULL,
  `idEntregable` int(11) NOT NULL,
  `rutaArchivo` varchar(255) DEFAULT NULL,
  `satisfaccion` double NOT NULL DEFAULT '0',
  `liberado` int(11) NOT NULL DEFAULT '0',
  `observaciones` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idEquipo`,`idEntregable`),
  KEY `idEntregable` (`idEntregable`),
  CONSTRAINT `equipo_entregable_ibfk_1` FOREIGN KEY (`idEquipo`) REFERENCES `equipo` (`idEquipo`),
  CONSTRAINT `equipo_entregable_ibfk_2` FOREIGN KEY (`idEntregable`) REFERENCES `entregable` (`idEntregable`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla stintegradoras.equipo_entregable: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `equipo_entregable` DISABLE KEYS */;
/*!40000 ALTER TABLE `equipo_entregable` ENABLE KEYS */;

-- Volcando estructura para tabla stintegradoras.esquema
CREATE TABLE IF NOT EXISTS `esquema` (
  `idEsquema` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `noIntegradora` enum('Integradora I','Integradora II','Integradora III','Integradora IV','Integradora V','Integradora VI','Integradora VII') NOT NULL,
  `noFases` enum('1','2','3','4','5','6','7','8','9','10','11','12') NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `idCarrera` int(11) NOT NULL,
  PRIMARY KEY (`idEsquema`),
  UNIQUE KEY `i_unidad` (`nombre`,`noIntegradora`,`idCarrera`),
  KEY `idCarrera` (`idCarrera`),
  CONSTRAINT `esquema_ibfk_1` FOREIGN KEY (`idCarrera`) REFERENCES `carrera` (`idCarrera`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla stintegradoras.esquema: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `esquema` DISABLE KEYS */;
/*!40000 ALTER TABLE `esquema` ENABLE KEYS */;

-- Volcando estructura para tabla stintegradoras.grupo
CREATE TABLE IF NOT EXISTS `grupo` (
  `idGrupo` int(11) NOT NULL AUTO_INCREMENT,
  `cuatrimestre` enum('1','2','3','4','5','6','7','8','9','10','11','12') NOT NULL,
  `letra` enum('A','B','C','D','E','F','G','H','I','J','K') NOT NULL,
  `turno` enum('Matutino','Vespertino','Nocturno') NOT NULL,
  `idCarrera` int(11) NOT NULL,
  PRIMARY KEY (`idGrupo`),
  UNIQUE KEY `i_unidad` (`cuatrimestre`,`letra`,`turno`,`idCarrera`),
  KEY `idCarrera` (`idCarrera`),
  CONSTRAINT `grupo_ibfk_1` FOREIGN KEY (`idCarrera`) REFERENCES `carrera` (`idCarrera`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla stintegradoras.grupo: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `grupo` DISABLE KEYS */;
INSERT INTO `grupo` (`idGrupo`, `cuatrimestre`, `letra`, `turno`, `idCarrera`) VALUES
	(2, '7', 'C', 'Matutino', 3),
	(1, '9', 'A', 'Vespertino', 1);
/*!40000 ALTER TABLE `grupo` ENABLE KEYS */;

-- Volcando estructura para tabla stintegradoras.periodo
CREATE TABLE IF NOT EXISTS `periodo` (
  `idPeriodo` int(11) NOT NULL AUTO_INCREMENT,
  `mesInicio` enum('0','1','2','3','4','5','6','7','8','9','10','11') NOT NULL,
  `mesFin` enum('0','1','2','3','4','5','6','7','8','9','10','11') NOT NULL,
  `anio` int(11) NOT NULL,
  PRIMARY KEY (`idPeriodo`),
  UNIQUE KEY `mesInicio_mesFin_anio` (`mesInicio`,`mesFin`,`anio`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla stintegradoras.periodo: ~11 rows (aproximadamente)
/*!40000 ALTER TABLE `periodo` DISABLE KEYS */;
INSERT INTO `periodo` (`idPeriodo`, `mesInicio`, `mesFin`, `anio`) VALUES
	(12, '0', '3', 2000),
	(13, '0', '3', 2001),
	(14, '0', '3', 2002),
	(15, '0', '3', 2003),
	(11, '0', '3', 2015),
	(5, '0', '3', 2016),
	(3, '0', '3', 2017),
	(8, '4', '7', 2016),
	(1, '4', '7', 2017),
	(10, '8', '11', 2016),
	(2, '8', '11', 2017);
/*!40000 ALTER TABLE `periodo` ENABLE KEYS */;

-- Volcando estructura para tabla stintegradoras.persona
CREATE TABLE IF NOT EXISTS `persona` (
  `idPersona` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) NOT NULL,
  `paterno` varchar(80) NOT NULL,
  `materno` varchar(80) NOT NULL,
  `idDivision` int(11) NOT NULL,
  PRIMARY KEY (`idPersona`),
  KEY `idDivision` (`idDivision`),
  CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`idDivision`) REFERENCES `division` (`idDivision`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla stintegradoras.persona: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
INSERT INTO `persona` (`idPersona`, `nombre`, `paterno`, `materno`, `idDivision`) VALUES
	(2, 'Abraham', 'Rodríguez', 'Hernández', 3),
	(3, 'Rubén Miguel', 'García', 'Ruiz', 2),
	(4, 'Yensi Fabiola ', 'Martínez', 'Pale', 2);
/*!40000 ALTER TABLE `persona` ENABLE KEYS */;

-- Volcando estructura para tabla stintegradoras.privilegio
CREATE TABLE IF NOT EXISTS `privilegio` (
  `idPrivilegio` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  PRIMARY KEY (`idPrivilegio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla stintegradoras.privilegio: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `privilegio` DISABLE KEYS */;
/*!40000 ALTER TABLE `privilegio` ENABLE KEYS */;

-- Volcando estructura para tabla stintegradoras.profesor
CREATE TABLE IF NOT EXISTS `profesor` (
  `idProfesor` int(11) NOT NULL,
  `nivelEstudios` varchar(50) NOT NULL,
  `especialidad` varchar(80) NOT NULL,
  `enComite` int(11) NOT NULL DEFAULT '0',
  `enIntegradora` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idProfesor`),
  CONSTRAINT `profesor_ibfk_1` FOREIGN KEY (`idProfesor`) REFERENCES `usuario` (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla stintegradoras.profesor: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `profesor` DISABLE KEYS */;
INSERT INTO `profesor` (`idProfesor`, `nivelEstudios`, `especialidad`, `enComite`, `enIntegradora`) VALUES
	(3, 'TSU', 'Sistemas Informáticos', 0, 1),
	(4, 'Ingenieria', 'Redes ', 0, 1);
/*!40000 ALTER TABLE `profesor` ENABLE KEYS */;

-- Volcando estructura para tabla stintegradoras.profesor_grupo_periodo
CREATE TABLE IF NOT EXISTS `profesor_grupo_periodo` (
  `idProfesor` int(11) NOT NULL,
  `idGrupo` int(11) NOT NULL,
  `idPeriodo` int(11) NOT NULL,
  PRIMARY KEY (`idProfesor`,`idGrupo`,`idPeriodo`),
  KEY `idGrupo` (`idGrupo`),
  KEY `idPeriodo` (`idPeriodo`),
  CONSTRAINT `profesor_grupo_periodo_ibfk_1` FOREIGN KEY (`idProfesor`) REFERENCES `profesor` (`idProfesor`),
  CONSTRAINT `profesor_grupo_periodo_ibfk_2` FOREIGN KEY (`idGrupo`) REFERENCES `grupo` (`idGrupo`),
  CONSTRAINT `profesor_grupo_periodo_ibfk_3` FOREIGN KEY (`idPeriodo`) REFERENCES `periodo` (`idPeriodo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla stintegradoras.profesor_grupo_periodo: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `profesor_grupo_periodo` DISABLE KEYS */;
INSERT INTO `profesor_grupo_periodo` (`idProfesor`, `idGrupo`, `idPeriodo`) VALUES
	(3, 1, 2),
	(3, 2, 1),
	(4, 2, 2);
/*!40000 ALTER TABLE `profesor_grupo_periodo` ENABLE KEYS */;

-- Volcando estructura para tabla stintegradoras.proyecto
CREATE TABLE IF NOT EXISTS `proyecto` (
  `idProyecto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `fechaInicio` date NOT NULL,
  `limite` date NOT NULL,
  `idEmpresa` int(11) NOT NULL,
  PRIMARY KEY (`idProyecto`),
  UNIQUE KEY `i_nombre` (`nombre`),
  KEY `idEmpresa` (`idEmpresa`),
  CONSTRAINT `proyecto_ibfk_1` FOREIGN KEY (`idEmpresa`) REFERENCES `empresa` (`idEmpresa`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla stintegradoras.proyecto: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `proyecto` DISABLE KEYS */;
INSERT INTO `proyecto` (`idProyecto`, `nombre`, `descripcion`, `fechaInicio`, `limite`, `idEmpresa`) VALUES
	(1, 'Pepsi', 'refrescos', '2017-05-18', '2017-08-18', 1);
/*!40000 ALTER TABLE `proyecto` ENABLE KEYS */;

-- Volcando estructura para tabla stintegradoras.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `idUsuario` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `rol` enum('Superusuario','Director','Profesor','Alumno') DEFAULT NULL,
  `activo` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `i_nombre` (`username`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `persona` (`idPersona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla stintegradoras.usuario: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`idUsuario`, `username`, `password`, `rol`, `activo`) VALUES
	(2, 'abraham', '12345678', 'Alumno', 1),
	(3, 'ruben', '12345678', 'Profesor', 1),
	(4, 'yensi', '12345678', 'Profesor', 1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;

-- Volcando estructura para tabla stintegradoras.usuario_privilegio
CREATE TABLE IF NOT EXISTS `usuario_privilegio` (
  `idUsuario` int(11) NOT NULL,
  `idPrivilegio` int(11) NOT NULL,
  PRIMARY KEY (`idUsuario`,`idPrivilegio`),
  KEY `idPrivilegio` (`idPrivilegio`),
  CONSTRAINT `usuario_privilegio_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`),
  CONSTRAINT `usuario_privilegio_ibfk_2` FOREIGN KEY (`idPrivilegio`) REFERENCES `privilegio` (`idPrivilegio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla stintegradoras.usuario_privilegio: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `usuario_privilegio` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario_privilegio` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
