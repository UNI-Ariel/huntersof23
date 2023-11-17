-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-11-2023 a las 22:31:13
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `myspaotplay`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favourites`
--

CREATE TABLE `favourites` (
  `uid` int(11) NOT NULL,
  `songID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Volcado de datos para la tabla `favourites`
--

INSERT INTO `favourites` (`uid`, `songID`) VALUES
(10, 23),
(10, 24);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `groupName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Volcado de datos para la tabla `groups`
--

INSERT INTO `groups` (`id`, `groupName`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `listsongs`
--

CREATE TABLE `listsongs` (
  `playlist_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `playlists`
--

CREATE TABLE `playlists` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `singers`
--

CREATE TABLE `singers` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `info` varchar(255) NOT NULL,
  `image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Volcado de datos para la tabla `singers`
--

INSERT INTO `singers` (`id`, `name`, `info`, `image`) VALUES
(1, 'Lady Gaga', 'Descripción de la Artista.\r\nStefani Joanne Angelina Germanotta (Nueva York, 28 de marzo de 1986), más conocida por su nombre artístico Lady Gaga, es una cantante, compositora, productora, bailarina, actriz, activista y diseñadora de moda estadounidense.', 'images/Lady.jpg'),
(2, 'Jess Glynne', 'Descripción de la Artista.\r\nJames Delaney es un teclista irlandés, conocidos Jessica Hannah Glynne ', 'images/jess.jpg'),
(3, 'Alan Walker', 'Descripción del Artista.\r\nAlan Olav Walker (Northampton, Inglaterra; 24 de agosto de 1997) es un DJ, remezclador y productor discográfico noruego nacido en Northampton, Inglaterra.', 'images/alan.jpg'),
(4, 'LP', 'Descripción del Artista.\r\nLaura Pergolizzi (Long Island, 18 de marzo de 1981), conocida artísticamente como LP, es una cantautora y compositora estadounidense.', 'images/LP.jpg'),
(5, 'Justin Bieber', 'Descripción del Artista.\r\nJustin Drew Bieber (London, Ontario; 1 de marzo de 1994) es un cantautor canadiense.', 'images/Justin.jpg'),
(8, 'James Delaney', 'Descripción del Artista.\r\nJames Delaney es un teclista irlandés que , durante los últimos 20 años , ha actuado con una amplia variedad de artistas conocidos', 'images/Delaney.jpg'),
(9, 'Unknown', 'Random Beatiful Songs', 'images/singers/lofi.jpg'),
(10, 'Imagine Dragons', 'Descripción del artista.\r\nDaniel Coulter Reynolds (Las Vegas, Nevada, 14 de julio de 1987), más conocido como Dan Reynolds, es un cantante, compositor y músico estadounidense.', 'images/AImagineD.jpg'),
(11, 'Coldplay', 'Descripción del artista.\r\nChris Martin\r\n(Christopher Anthony John Martin; Exeter, Devon, 1977) Cantante y compositor inglés, líder de la banda Coldplay.', 'images/artista de codplay.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `songs`
--

CREATE TABLE `songs` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `filePath` varchar(50) NOT NULL,
  `imgPath` varchar(50) NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT current_timestamp(),
  `singerID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Volcado de datos para la tabla `songs`
--

INSERT INTO `songs` (`id`, `title`, `filePath`, `imgPath`, `dateAdded`, `singerID`) VALUES
(17, 'Bloody Mary', 'music/Bloody Mary.mp3', 'images/bloodymary.jpg', '2023-10-26 01:40:40', 1),
(18, 'Faded', 'music/faded.mp3', 'images/faded.png', '2023-10-26 01:45:42', 3),
(19, 'Lost On You', 'music/Lost On You.mp3', 'images/lostonyou.jpg', '2023-10-26 01:51:57', 4),
(20, 'Rather Be-12', 'music/Rather Be-12.mp3', 'images/ratherbe.jpg', '2023-10-26 01:55:03', 2),
(21, 'Fallingdown', 'music/fallingdown.mp3', 'images/fallingdown.jpg', '2023-10-26 01:56:07', 8),
(22, 'Stay', 'music/stay.mp3', 'images/stay.png', '2023-10-26 01:57:33', 5),
(23, 'Bones', 'music/bones.mp3', 'images/bones.jpg', '2023-10-31 06:49:22', 10),
(24, 'Magic', 'music/magic.mp3', 'images/magic.jpg', '2023-10-31 06:54:53', 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `groupID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `groupID`) VALUES
(10, 'Harold', '', 'c57f431343f100b441e268cc12babc34', 2),
(29, 'admin', 'admin@', '21232f297a57a5a743894a0e4a801fc3', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`uid`,`songID`),
  ADD KEY `favourites_ibfk_2` (`songID`);

--
-- Indices de la tabla `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `listsongs`
--
ALTER TABLE `listsongs`
  ADD KEY `listsongs_ibfk_1` (`playlist_id`),
  ADD KEY `listsongs_ibfk_2` (`song_id`);

--
-- Indices de la tabla `playlists`
--
ALTER TABLE `playlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `singers`
--
ALTER TABLE `singers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `singerID` (`singerID`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groupID` (`groupID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `playlists`
--
ALTER TABLE `playlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `singers`
--
ALTER TABLE `singers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `favourites`
--
ALTER TABLE `favourites`
  ADD CONSTRAINT `favourites_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favourites_ibfk_2` FOREIGN KEY (`songID`) REFERENCES `songs` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `listsongs`
--
ALTER TABLE `listsongs`
  ADD CONSTRAINT `listsongs_ibfk_1` FOREIGN KEY (`playlist_id`) REFERENCES `playlists` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `listsongs_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `songs` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `playlists`
--
ALTER TABLE `playlists`
  ADD CONSTRAINT `playlists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `songs`
--
ALTER TABLE `songs`
  ADD CONSTRAINT `songs_ibfk_1` FOREIGN KEY (`singerID`) REFERENCES `singers` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`groupID`) REFERENCES `groups` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
