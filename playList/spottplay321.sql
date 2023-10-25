-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-10-2023 a las 15:18:44
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
-- Base de datos: `spottplay321`
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
(9, 14),
(9, 15),
(12, 14),
(12, 21);

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
-- Estructura de tabla para la tabla `playlists`
--

CREATE TABLE `playlists` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `playlists`
--

INSERT INTO `playlists` (`id`, `nombre`, `descripcion`, `imagen`) VALUES
(16, 'd', 'f', NULL),
(18, 'lista1wweee', 'holaarfdf', NULL),
(20, 'h', 'h', NULL),
(21, 'hace mucho tiekpo', 'holaaaa,que tal', NULL),
(22, 'hola', 'l', NULL);

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
(1, 'Sơn Tùng MTP', 'Nguyễn Thanh Tùng, thường được biết đến với nghệ danh Sơn Tùng M-TP, là một nam ca sĩ kiêm sáng tác nhạc, rapper và diễn viên người Việt Nam.', 'images/singers/mtp.png'),
(2, 'Đức Phúc', 'Nguyễn Đức Phúc là một nam ca sĩ người Việt Nam được biết đến rộng rãi với tư cách quán quân của The Voice Vietnam 2015.', 'images/singers/ducphuc.png'),
(3, 'Hoài Lâm', 'Hoài Lâm, tên thật là Nguyễn Tuấn Lộc, là một nam ca sĩ, rapper kiêm diễn viên người Việt Nam. Anh từng giành 1 giải Cống hiến và được công chúng Việt Nam đặc biệt chú ý sau khi giành giải quán quân chương trình truyền hình thực tế Gương mặt thân quen.', 'images/singers/hoailam.png'),
(4, 'Hương Tràm', 'Hương Tràm có tên đầy đủ là Phạm Thị Hương Tràm là một nữ ca sĩ người Việt Nam. Cô là quán quân cuộc thi Giọng hát Việt mùa đầu tiên 2012.', 'images/singers/huongtram.png'),
(5, 'Chế Linh', 'Chế Linh là nam ca sĩ người Chăm nổi tiếng, đồng thời là nhạc sĩ với bút hiệu Tú Nhi và Lưu Trần Lê. Ông nổi danh từ thập niên 60 và được xem như là một trong bốn giọng nam nổi tiếng nhất của nhạc vàng thời kỳ đầu.', 'images/singers/chelinh.png'),
(8, 'Min', 'Nguyễn Minh Hằng, được biết đến với nghệ danh MIN, là một nữ ca sĩ, vũ công và nhà sản xuất âm nhạc người Việt Nam.', 'images/singers/cec.jpg'),
(9, 'Unknown', 'Random Beatiful Songs', 'images/singers/lofi.jpg'),
(10, 'Alan Walker', 'Alan Olav Walker (Northampton, Inglaterra; 24 de agosto de 1997) es un DJ, remezclador y productor discográfico noruego nacido en Northampton, Inglaterra. Es conocido por su sencillo «Faded» de 2015, que fue certificado platino en catorce países.', 'images/singers/AlanWalker.jpeg');

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
(14, 'Pixabay', 'music/pixabay.mp3', 'images/piano.jpg', '2021-06-03 14:38:34', 9),
(15, 'Midnight', 'music/midnight.mp3', 'images/Midnight_Mist.jpg', '2021-06-03 14:38:58', 9),
(16, 'Electronica', 'music/electronica.mp3', 'images/lofi.jpg', '2021-06-03 14:39:21', 9),
(17, 'Faded', 'music/Faded.mp3', 'images/faded.png', '2023-10-18 22:25:31', 10),
(18, 'Falling Down', 'music/fallingdown.mp3', 'images/fallingdown.jpg', '2023-10-18 22:26:28', 9),
(19, 'Lost On You', 'music/Lost On You.mp3', 'images/lostonyou.jpg', '2023-10-18 22:27:18', 9),
(20, 'Rather Be-12', 'music/Rather Be-12.mp3', 'images/ratherbe.jpg', '2023-10-18 22:31:14', 9),
(21, 'Stay', 'music/stay.mp3', 'images/stay.png', '2023-10-18 22:31:48', 9),
(22, 'Blood Mary', 'music/Bloody Mary.mp3', 'images/bloodymary.jpg', '2023-10-18 22:32:19', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `groupID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `groupID`) VALUES
(5, 'pum', '58af57d4977baf21166dbfb12b606789', 1),
(9, 'admin', 'c57f431343f100b441e268cc12babc34', 1),
(10, 'Harold', 'c57f431343f100b441e268cc12babc34', 2),
(12, 'vetdy03', 'a8319990656b83fc40eb7aae987f5a12', 1),
(13, 'lizbetha', '@lizbetha', 2);

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
-- Indices de la tabla `playlists`
--
ALTER TABLE `playlists`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `singers`
--
ALTER TABLE `singers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
