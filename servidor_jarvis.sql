-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 04-04-2024 a las 19:08:52
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
-- Base de datos: `servidor_jarvis`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos`
--

CREATE TABLE `juegos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `duracion` varchar(3) DEFAULT NULL,
  `min_jug` varchar(2) NOT NULL,
  `max_jug` varchar(2) DEFAULT NULL,
  `lugar` varchar(100) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `papelera` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `juegos`
--

INSERT INTO `juegos` (`id`, `nombre`, `duracion`, `min_jug`, `max_jug`, `lugar`, `descripcion`, `papelera`) VALUES
(1, '¡No lo digas!', '30', '2', NULL, 'Salón', NULL, 0),
(2, 'Party & Co. Junior', '30', '4', '20', 'Salón', NULL, 0),
(3, 'Concept', '40', '3', '12', 'Salón', NULL, 0),
(4, 'Trivial Pursuit: Edición Genus', '60', '2', '36', 'Salón', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id` int(11) NOT NULL,
  `nombre` varchar(300) NOT NULL,
  `paginas` varchar(5) DEFAULT NULL,
  `autor` varchar(100) NOT NULL,
  `editorial` varchar(100) DEFAULT NULL,
  `lugar` varchar(100) NOT NULL,
  `prestado` varchar(100) DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `descripcion` varchar(5000) DEFAULT NULL,
  `portada` varchar(100) DEFAULT NULL,
  `agno` year(4) DEFAULT NULL,
  `titulo_original` varchar(200) DEFAULT NULL,
  `deposito_legal` varchar(20) DEFAULT NULL,
  `papelera` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id`, `nombre`, `paginas`, `autor`, `editorial`, `lugar`, `prestado`, `isbn`, `descripcion`, `portada`, `agno`, `titulo_original`, `deposito_legal`, `papelera`) VALUES
(1, 'Warcross (Warcross 1)', '431', 'Marie Lu', 'Nocturna Ediciones', 'Cuarto de David, baldas', NULL, '9788416858309', 'Para los millones de usuarios que se conectan en busca de adrenalina o por la euforia de experimentar un nuevo estilo de vida, Warcross es más que un juego; es una revolución. Emika Chen trabaja como cazarrecompensas rastreando a los jugadores que vulneran la ley. Y se trata de un mundo competitivo, por lo que un día asume un desafío muy arriesgado: hackear la partida inaugural de los campeonatos mundiales. Convencida de que van a detenerla, Emika se sorprende cuando en su lugar recibe una llamada del hermético creador de Warcross con una oferta irresistible: introducirla en la próxima edición del torneo para investigar un fallo de seguridad.', 'https://covers.openlibrary.org/b/isbn/9788416858309-L.jpg', '2018', 'Warcross', NULL, 0),
(2, 'Wardraft (Warcross 2)', '400', 'Marie Lu', 'Nocturna', 'Cuarto de David, baldas', NULL, '9788416858859', NULL, 'https://covers.openlibrary.org/b/isbn/9788416858859-L.jpg', '2019', 'Wardraft', NULL, 0),
(3, 'Armada', '432', 'Ernest Cline', 'PRH Grupo Editorial', 'Cuarto de David, baldas', NULL, '9788490705797', 'El esperado regreso del autor de Ready Player One, el best seller geek en que se basa la película homónima de Steven Spielberg. Zack Lightman se ha pasado la vida soñando. Soñando con que el mundo real se pareciera un poco más al sinfín de libros, películas y videojuegos de ciencia ficción que lo han acompañado desde siempre. Soñando con el día en que un acontecimiento increíble y capaz de cambiar el mundo hiciera añicos la monotonía de su aburrida existencia y lo embarcara en una gran aventura en los confines del espacio. Pero un poco de escapismo no viene mal de vez en cuando, ¿verdad? Después de todo, Zack no deja de repetirse que sabe dónde está el límite entre lo real y lo imaginario. Que sabe que en el mundo real nadie elige para salvar el universo a un adolescente con problemas para controlar su ira, aficionado a los videojuegos y que no sabe qué hacer con su vida. Y entonces Zack ve un platillo volante. Para colmo, la nave alienígena es igual a las del videojuego al que se pasa enganchado todas las noches, un juego multijugador de naves muy popular llamado Armada en el que los jugadores tienen que proteger la Tierra de unos invasores extraterrestres. No, Zack no se ha vuelto loco. Aunque parezca imposible, aquello es muy real. Y van a ser necesarias sus habilidades y las de millones de jugadores de todo el mundo para salvar la Tierra de lo que está por venir. Al fin Zack se va convertir en un héroe. Pero a pesar del terror y la emoción que lo embargan, no puede evitar recordar todas aquellas historias de ciencia ficción con las que ha crecido y preguntarse: «¿Acaso no hay algo en todo esto que me resulta... familiar?» ENGLISH DESCRIPTION From the author of Ready Player One, a rollicking alien invasion thriller that embraces and subverts science-fiction conventions as only Ernest Cline can. Zack Lightman has never much cared for reality. He vastly prefers the countless science-fiction movies, books, and videogames he\'s spent his life consuming. And too often, he catches himself wishing that some fantastic, impossible, world-altering event could arrive to whisk him off on a grand spacefaring adventure. So when he sees the flying saucer, he\'s sure his years of escapism have finally tipped over into madness. Especially because the alien ship he\'s staring at is straight out of his favorite videogame, a flight simulator callled Armada--in which gamers just happen to be protecting Earth from alien invaders. As impossible as it seems, what Zack\'s seeing is all too real. And it\'s just the first in a blur of revlations that will force him to question everything he thought he knew about Earth\'s history, its future, even his own life--and to play the hero for real, with humanity\'s life in the balance. But even through the terror and exhilaration, he can\'t help thinking: Doesn\'t something about this scenario feel a little bit like...well...fiction? At once reinventing and paying homage to science-fiction classics, Armada is a rollicking, surprising thriller, a coming-of-age adventure, and an alien invasion tale like nothing you\'ve ever read before.', 'https://covers.openlibrary.org/b/isbn/9788490705797-L.jpg', '2018', 'Armada (Spanish Edition)', NULL, 0),
(4, 'Curso de escritura creativa', '496', 'Brandon Sanderson', 'Ediciones B', 'Cuarto de David, baldas', NULL, '9788466671897', 'El curso de escritura creativa que Brandon Sanderson lleva casi dos décadas impartiendo en la universidad, por primera vez en formato libro.\r\n\r\nCurso de escritura creativa convierte en libro las clases que Brandon Sanderson lleva 16 años impartiendo anualmente en la Universidad Brigham Young, donde estudió. Él mismo dice que nunca ha dejado de darlas porque es un recurso que necesita para seguir creciendo como escritor. El curso se centra en los engranajes de la escritura y tiene un enfoque muy práctico; en él nos habla de la trama, la ambientación y los personajes, pero también de la parte empresarial. Sin embargo, no hace falta querer ser un escritor profesional para leer este libro. Su objetivo es ayudar a cualquier lector a comunicarse mejor y crear buenos hábitos para escribir de forma consistente, con los valiosos consejos de uno de los mayores creadores de nuestro siglo.\r\n\r\n«Os animo a que utilicéis este curso del modo que más os ayude a lograr vuestros objetivos.» Brandon Sanderson', 'https://covers.openlibrary.org/b/isbn/9788466671897-L.jpg', '2022', 'Curso de escritura creativa', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas`
--

CREATE TABLE `peliculas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(300) NOT NULL,
  `duracion` varchar(4) NOT NULL,
  `lugar` varchar(100) NOT NULL,
  `director` varchar(200) DEFAULT NULL,
  `actor_principal` varchar(100) DEFAULT NULL,
  `genero` varchar(100) DEFAULT NULL,
  `agno` year(4) DEFAULT NULL,
  `poster` varchar(200) DEFAULT NULL,
  `argumento` varchar(15000) DEFAULT NULL,
  `imdb` varchar(15) DEFAULT NULL,
  `papelera` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `peliculas`
--

INSERT INTO `peliculas` (`id`, `nombre`, `duracion`, `lugar`, `director`, `actor_principal`, `genero`, `agno`, `poster`, `argumento`, `imdb`, `papelera`) VALUES
(2, '1984 (George Orwell) (Spanish)', '113', '0-9', 'Michael Radford', 'John Hurt, Richard Burton, Suzanna Hamilton', 'Drama, Sci-Fi', '1984', 'https://m.media-amazon.com/images/M/MV5BMWFkNzIzNDUtNWI1Mi00ODA2LTgyMTMtYTZiYWMxMDFlNmNhL2ltYWdlXkEyXkFqcGdeQXVyNTAyODkwOQ@@._V1_SX300.jpg', 'In a totalitarian future society, a man, whose daily work is re-writing history, tries to rebel by falling in love.', '0087803', 0),
(3, '2001 Una odisea del espacio', '148', '0-9', 'Stanley Kubrick', 'Keir Dullea,Gary Lockwood,William Sylvester,Daniel Richter', 'Adventure,Sci-Fi', '1968', 'https://m.media-amazon.com/images/M/MV5BMmNlYzRiNDctZWNhMi00MzI4LThkZTctMTUzMmZkMmFmNThmXkEyXkFqcGdeQXVyNzkwMjQ5NzM@.jpg', 'After discovering a mysterious artifact buried beneath the Lunar surface, mankind sets off on a quest to find its origins with help from intelligent supercomputer H.A.L. 9000.<i>Johnn</i><br>2001 is a story of evolution. Sometime in the distant past, someone or something nudged evolution by placing a monolith on Earth (presumably elsewhere throughout the universe as well). Evolution then enabled humankind to reach the moons surface, where yet another monolith is found, one that signals the monolith placers that humankind has evolved that far. Now a race begins between computers (HAL) and human (Bowman) to reach the monolith placers. The winner will achieve the next step in evolution, whatever that may be.<i>Larry Cousins</i><br>A black monolith has an affect on humans, the monoliths effects focusing on two specific time periods. The first period is four million years ago, at the dawn of man. After the appearance of the monolith, the ape men begin to display behavior unknown before then. The second period is the near future, in the year 2001. There are five astronauts aboard Discovery One, which is on a mission to Jupiter. At the beginning of the mission, the reason for it is unknown to the five astronauts. Three of the astronauts are in hibernation at the start of the mission to preserve the manpower over its entire course, leaving mission commander Dr. Dave Bowman and Dr. Frank Poole as the two manning the spacecraft. There is another what is often considered sixth astronaut on board, HAL 9000 - referred to simply as Hal - the artificial intelligent computer which controls all of the crafts functions, including the systems keeping the three hibernating astronauts alive. Hal is made all the more astronaut-like as it is given an artificial voice, Hal and the astronauts often having conversations. A 9000 series computer is considered infallible, any error one has ever made being human caused. Ultimately, Bowman and Poole believe that Hal is malfunctioning, they are unaware that Hals behavior is due to knowledge of classified information it has about events at Clavius, a lunar outpost, eighteen months earlier. However, the issue between the astronauts and Hal becomes a fight for survival. The mission in its entirety has profound consequences for the human race.<i>Huggo</i><br>This movie is concerned with intelligence as the division between animal and human, then asks a question: what is the next division? Technology is treated as irrelevant to the quest--literally serving as mere vehicles for the human crew and as a shell for the immature HAL entity. Story told as a montage of impressions, music, and impressive and careful attention to subliminal detail. A very influential film and still a class act, even after 25 years.<i>Robin Kenny <robink@hparc0.aus.hp.com></i><br>When a large black monolith is found beneath the surface of the moon, the reaction immediately is that it was intentionally buried. When the point of origin is confirmed as Jupiter, an expedition is sent in hopes of finding the source. When Dr. David Bowman discovers faults in the expeditionary spacecrafts communications system, he discovers more than he ever wanted to know.<i>Alexander ONeill</i><br>The monoliths have been watching us. They gave humankind the evolutionary kick in the pants it needed to survive at the Dawn of Time. In 1999, humankind discovered a second monolith on the moon. Now, in the year 2001, the S.S. Discovery and its crew, Captains Dave Bowman and Frank Poole, and their onboard computer, HAL 9000, must discover what alien force is watching Earth....<i>Tones <tones120c@aol.com></i><br>', '0062622', 0),
(4, '2010 Odisea dos (Spa-Eng)', '111', '0-9', 'Peter Hyams', 'Roy Scheider,John Lithgow,Helen Mirren,Bob Balaban', 'Adventure,Mystery,Sci-Fi,Thriller', '1984', 'https://m.media-amazon.com/images/M/MV5BOTU1NDQwZjQtODc2YS00MTE4LWE5YTctMmYwYmNiYTU2MzRmXkEyXkFqcGdeQXVyODU2MDg1NzU@.jpg', 'A joint U.S.-Soviet expedition is sent to Jupiter to learn what happened to the Discovery, and H.A.L.<i>Kenneth Chishol</i><br>In this sequel to 2001: A Space Odyssey (1968), a joint American-Soviet expedition is sent to Jupiter to discover what went wrong with the U.S.S. Discovery against a backdrop of growing global tensions. Amongst the mysteries the expedition must explain, are the appearance of a huge black monolith in Jupiters orbit and the fate of H.A.L.; the Discoverys A.I. computer. Based on the novel by Arthur C. Clarke.<i>Keith Loh loh@sfu.ca></i><br>In 2001, the spaceship Discovery appears to have never completed its mission; to find out the source of the mysterious radio beacon which eminated from the monolith found buried on the moon. Now, in 2010, Dr. Heywood Floyd (Roy Scheider), the man held responsible for Discoverys failure, is going to Jupiter. He and his crewmates must reactivate the H.A.L. 9000 computer, so they may learn what happened, and they must find out the meaning of Dave Bowmans (Keir Dulleas) last transmission; my God, its full of stars.<i>Tones <tones120c@aol.com></i><br>', '0086837', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `juegos`
--
ALTER TABLE `juegos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `juegos`
--
ALTER TABLE `juegos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=573;

--
-- AUTO_INCREMENT de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1470;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
